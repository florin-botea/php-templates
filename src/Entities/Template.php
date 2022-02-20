<?php

namespace PhpTemplates\Entities;

use IvoPetkov\HTML5DOMDocument;
use PhpTemplates\Config;
use PhpTemplates\Document;
use PhpTemplates\Helper;

/**
 * is actually component, but used in different contexts, even on root
*/
class Template extends AbstractEntity
{
    private $name;

    public function __construct(Document $doc, $node, $context = null)
    {
        parent::__construct($doc, $node, is_string($context) ? null : $context);
        if (is_string($node)) {
            $this->name = $node;
        } 
        elseif (is_string($context)) {
            $this->name = $context;
        }
    }
    
    public function newContext()
    {
        $this->thread = uniqid();
        Php::setThread($this->thread);
        if (method_exists($this->node, 'querySelector')) {
            if ($extends = $this->node->querySelector('extends')) {
                $this->extends($extends);
            }
        }
        $this->parseNode($this->node);//dom($this->node);d(123);
        $this->register();
    }
    
    protected function register()
    {
        while ($this->document->toberemoved) {
            $node = array_pop($this->document->toberemoved);
            try {
                @$node->parentNode && @$node->parentNode->removeChild($node);
            } catch (\Exception $e) {}
        }

        if ($this->trimHtml) {
            $htmlString = $this->trimHtml($this->node);
        }
        elseif ($this->node->ownerDocument) {
            $htmlString = $this->node->ownerDocument->saveHtml($this->node);
        } else {
            $htmlString = $this->node->saveHtml();
        }
        // make replaces
        $htmlString = preg_replace('/<html>[\s\n\r]*<\/html>/', '', $htmlString);
        $htmlString = preg_replace('/\?\&gt;[\s\r\n\t]*\&lt;\?php[\s\r\n\t;]*else/', 'else', $htmlString);
        $htmlString = preg_replace_callback('/{{(((?!{{).)*)}}/', function($m) {
            if ($eval = trim($m[1])) {
                return "<?php echo htmlspecialchars($eval); ?>";
            }
            return '';
        }, $htmlString);

        $htmlString = $this->getTemplateFunction($htmlString);
        $this->document->templates[$this->name] = $htmlString;
    }

    // public function componentContext()
    // {

    // }

    // public function slotContext()
    // {

    // }

    private function extends($extends)
    {
        $extendedTemplate = $extends->getAttribute('template');
        (new Template($this->document, $extendedTemplate))->newContext();

        $this->document->addEventListener('rendering', $this->name, "function(\$template, \$data) {
            \$comp = Parsed::template('$extendedTemplate', \$data);
            \$comp->addSlot('default', \$template);
            \$comp->render(\$data);
            return false;
        }");

        $extends->parentNode->removeChild($extends);
    }
}