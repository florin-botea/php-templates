<?php

namespace PhpTemplates;

use IvoPetkov\HTML5DOMDocument;
use PhpTemplates\Traits\CanParseNodes;

class TemplateFunction 
{
    use CanParseNodes;
    
    /**
     * Current processing thread contextual data holder (like config, parsed index, other cross entities shared data)
     * @var Process
     */
    protected $process;

    /**
     * If the current template is parsed from a file, or from an existing DomNode (like slot nodes)
     * @var boolean
     */
    private $wasRecentlyLoaded = false;

    /**
     * Data passed to component using node attributes
     *
     * @var array
     */
    private $data = [];

    /**
     * When a template file has <props/> node, if called as component tag, 
     * make an array_diff_keys between them and passed attributes to obdain the p-bind="$this->attrs" variables
     * @var array
     */
    private $props = [];


// refactor end
    
    private $attrs; // computed at calling render function moment

    private $name;
    private $node;
    private $trimHtml = false;
    private $depth = 0;

    public function __construct(Process $process, $node, $context = null)
    {
        $this->process = $process;
        if (is_string($node)) {
            $path = array_filter(explode(':', $node));
            if (count($path) > 1) {
                $cfgKey = $path[0];
            } else {
                $cfgKey = 'default';
            }
            $this->process->withConfig($cfgKey);
            $path = end($path);
            $this->name = $node;
            //$this->process = new Process($this->name, $cfg, $this->process);
            $node = $this->load($path);
            $this->wasRecentlyLoaded = true;
        }    
        elseif (is_string($context)) {
            $this->name = $context;
        }
        
        $this->node = $node;
    }
    
    public function parse()
    {
        if ($this->wasRecentlyLoaded && method_exists($this->node, 'querySelector')) {
            if ($extends = $this->node->querySelector('extends')) {
                $this->extends($extends);
            }
            if ($props = $this->node->querySelector('props')) {
                $this->props = $this->getProps($props);
            }
        }
        $this->parseNode($this->node);

        $this->register();
    }
    
    protected function register()
    {
        if ($this->trimHtml) {
            $htmlString = $this->trimHtml($this->node);
        }
        elseif ($this->node->ownerDocument) {
            $htmlString = $this->node->ownerDocument->saveHtml($this->node);
        } else {
            $htmlString = $this->node->saveHtml();
        }

        $htmlString = $this->getTemplateFunction($htmlString);
        $this->process->addTemplateFunction($this->name, $htmlString);
    }

    private function extends($extends)
    {
        $extendedTemplate = $extends->getAttribute('template');
        (new TemplateFunction($this->process, $extendedTemplate))->parse();

        $this->process->addEventListener('rendering', $this->name, "function(\$template, \$data) {
            \$comp = Parsed::template('$extendedTemplate', \$data);
            \$comp->addSlot('default', \$template);
            \$comp->render(\$data);
            return false;
        }");

        $extends->parentNode->removeChild($extends);
    }

    private function getProps($propsNode)
    {
        $props = [];
        foreach ($propsNode->attributes as $attr) {
            $props[$attr->nodeName] = $attr->nodeValue;
        }
        $propsNode->parentNode->removeChild($propsNode);
        
        return $props;
    }

    /**
     * Load the given route document using this.document settings with fallback on default settings
     */
    public function load($rfilepath)
    {
        $srcFile = null;
        $tried = [];
        foreach ($this->process->getSrcPaths() as $srcPath) {
            $filepath = rtrim($srcPath, '/').'/'.$rfilepath.'.template.php';
            if (file_exists($filepath)) {
                $srcFile = $filepath;
                break;
            }
            $tried[] = $filepath;
        }

        if (!$srcFile) {
            $message = implode(' or ', $tried);
            throw new \Exception("Template file $message not found");
        }
        
        $this->process->addDependencyFile($srcFile);
        $node = new HTML5DOMDocument();

        $html = file_get_contents($srcFile);
        $html = $this->removeHtmlComments($html);
        $html = $this->collectBrokingBlocks($html);
        $this->trimHtml = strpos($html, '<body') === false;
        $node->loadHtml($html);

        return $node;
    }

    public function escapeSpecialCharacters($html) {
        return str_replace(['&lt;', '&gt;', '&amp;'], ['&\lt;', '&\gt;', '&\amp;'], $html);
    }
    
    private function collectBrokingBlocks($html)
    {
        
        $html = preg_replace_callback('/(?<!<)<\?php(.*?)\?>/s', function($m) {
            $rid = '__r'.uniqid();
            $this->process->toBeReplaced($rid, $m[0]);
            return $rid.'="__empty__"';
        }, $html);
        
        $html = preg_replace_callback('/(?<!@)@php(.*?)@endphp/s', function($m) {
            $rid = '__r'.uniqid();
            $this->process->toBeReplaced($rid, '<?php ' . $m[1] . ' ?>');
            return $rid.'="__empty__"';
        }, $html);
        
        $html = preg_replace_callback('/{{(((?!{{).)*)}}/', function($m) {
            if ($eval = trim($m[1])) {
                $rid = '__r'.uniqid();
                $this->process->toBeReplaced($rid, "<?php echo htmlspecialchars($eval); ?>");
                return $rid.'="__empty__"';
            }
            return '';
        }, $html);
        
        return $html;
    }

    public function trimHtml($dom)
    {
        $body = $dom->getElementsByTagName('body')->item(0);

        if (!$body) {
            return '';
        }

        $content = '';
        foreach ($body->childNodes as $node)
        {
            $content.= $dom->saveHtml($node).PHP_EOL;
        }
        return $content;
    }
    
    protected function getTemplateFunction(string $templateString) 
    {
        $templateString = " ?> $templateString <?php ";
        if ($this->props) {
            $props = Helper::arrayToEval($this->props);
            $fnheader = PHP_EOL."\$props = $props; ";
            $fnheader .= ' $this->attrs = array_diff_key($this->data, $props);';
            $fnheader .= ' $data = array_merge($props, $data);';
        } else {
            $fnheader = PHP_EOL.'$this->attrs = $this->data;';
        }
        $fnheader .= PHP_EOL.'extract($data);';
        $fnDeclaration = 'function ($data, $slots) {';
        $fnDeclaration .= $fnheader;
        $fnDeclaration .= $templateString;
        $fnDeclaration .= '}';

        return $fnDeclaration;
    }
 
    public function removeHtmlComments($content = '') {
    	return preg_replace('~<!--.+?-->~ms', '', $content);
    }

    public function __get($prop)
    {
        return $this->$prop;
    }
}