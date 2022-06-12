<?php

namespace PhpTemplates\Entities;

use DOMAttr;
use PhpTemplates\Config;
use PhpTemplates\Helper;
use IvoPetkov\HTML5DOMDocument;
use PhpTemplates\Directive;
use PhpTemplates\InvalidNodeException;
use PhpTemplates\Process;
use PhpTemplates\Traits\CanParseNodes;
use PhpTemplates\Dom\DomNode;
use PhpTemplates\Dom\PhpNode;

abstract class AbstractEntity
{
    use CanParseNodes;
    
    /**
     * Current processing thread contextual data holder (like config, parsed index, other cross entities shared data)
     * @var Process
     */
    protected $process;

    /**
     * recursive parent context
     *
     * @var AbstractEntity $context
     */
    protected $context;

    /**
     * current DomNode
     *
     * @var DomNode $node
     */
    protected $node;

    /**
     * Found attributes on current node
     *
     * @var array $attrs
     */

    protected $attrs = [];
    
    /**
     * Used to not override above variables in case of multi-level nest, eg:
     * var1 = comp1
     * var2 = var1->addSlot(x);
     *
     * @var integer
     */
    protected $depth = 0;
    
    /**
     * prefix for special php blocks (p-if, p-for)
     *
     * @var string
     */
    protected $pf = 'p-';
    
    /**
     * Creating a new instance by giving the main process as param, the node and the context
     *
     * @param Process $process
     * @param string|DomNode $node string when is component, DomNode when is simple node
     * @param AbstractEntity $context
     */
    public function __construct(Process $process, $node, $context = null) //todo interfata ca param 3
    {
        if (is_string($context)) {
            $this->name = $context;
            $context = null;
        }

        if ($context) {
            $ct_type = explode('\\', get_class($context));
            $ct_type = end($ct_type);

            if (!in_array($ct_type, ['SimpleNode'])) {
                $this->depth = $context->depth +1;
            }
        }

        if (isset($this->process->config['prefix'])) {
            $this->pf = $this->process->config['prefix'];
        }

        $this->process = $process;
        $this->node = $node;

        $this->context = $context;
    }
    
    //abstract public function rootContext();
    //abstract public function componentContext();
    //abstract public function slotContext();
   
    /**
     * Get root Entity in a nested context (first element in a nested structure)
     *
     * @return AbstractParser
     */
    public function getRoot(): AbstractEntity
    {
        if ($this->depth === 0) {
            return $this;
        }
        
        return $this->context->getRoot();
    }
    
    /**
     * Wrap node inside control structures and returns the aggregated node datas as array (like :class and class under 1 single key named :class)
     *
     * @param [type] $node
     * @param callable $cb
     * @return array
     */
    protected function depleteNode($node): array
    {
        $attrs = $node->attributes;
        $extracted_attributes = [];

        foreach ($attrs as $a) {
            $k = $a->nodeName;

            if (strpos($k, $this->pf) === 0) 
            {
                // check if is a custom directive and unpack its result as attributes
                if ($directive = $this->process->getDirective(substr($k, strlen($this->pf)))) {
                    $result = $directive($a->nodeValue);
                    if (empty($result)) {
                        throw new InvalidNodeException('Directive should return an associative array with node => value parsable by PhpTemplates', $node);
                    }
                    foreach ($result as $k => $val) {
                        $extracted_attributes[] = new DOMAttr($k, $val);
                    }
                    // directive unpacked his data, next attr!!!
                    continue;
                }
            }
            $extracted_attributes[] = clone $a;
        }

        // aggregate attributes in bind form with attrs in static form, like :class and class under :class key
        $c_structs = [];
        $data = [];
        $binds = [];
        foreach ($extracted_attributes as $a) {
            $k = $a->nodeName;
            if (strpos($k, $this->pf) === 0) {
                $k = substr($k, strlen($this->pf));
                if (in_array($k, Config::allowedControlStructures)) {
                    $c_structs[] = [$k, $a->nodeValue];
                    continue;
                }
            }
            $k = $a->nodeName;
       
            if (array_key_exists($k, $this->attrs)) {
                $this->attrs[$k] = $a->nodeValue;
            } 
            elseif ($k[0] === ':') {
                $binds[$k][] = $a->nodeValue;
            }
            else {
                $data[$k][] = $a->nodeValue;
            }
        }

        // remove all node attrs
        $node->removeAttributes();
        
        // aggregate attributes in bind form with attrs in static form, like :class and class under :class key
        foreach ($data as $k => $val) {
            $bk = ':'.$k;
            $bind = isset($binds[$bk]) ? $binds[$bk] : null;
            
            if ($bind) {
                $val = array_map(function($attr) {
                    return "'$attr'";
                }, $val);
                $val = array_merge($val, $bind);
                $val = 'attr('.implode(',',$val).')';
                unset($binds[$bk]);
                unset($data[$k]);
                $data[$bk] = $val;
            } else {
                $data[$k] = implode(' ', $val);
            }
        }
        
        // implode attribute values, eg: '.class' with :class="@php echo x; @endphp" under 1 'magic' merger method 
        foreach ($binds as $bk => $bval) {
            $k = substr($bk, 1);
            if (count($bval) > 1) {
                $bval = 'attr('.implode(',',$bval).')';
            } else {
                $bval = $bval[0];
            }

            $data[$bk] = $bval;
        }

        // now consider the control structures like p-if, p-for, etc
        $cstruct = null;
        $condNode = null;
        foreach ($c_structs as $struct) {
            list($statement, $args) = $struct;
            $phpnode = new PhpNode($statement, $args);
            if ($cstruct) {
                $cstruct->appendChild($phpnode);
            } else {
                $condNode = $phpnode;
            }
            $cstruct = $phpnode;
        }
        if ($condNode) {
            $node->parentNode->insertBefore($condNode, $node);
            $cstruct->appendChild($node->detach());
            $node = $condNode;
        }
        
        return $data;
    }

    /**
     * After the node has been depleted and has 0 attributes, proceed to populate it with parsed attributes
     *
     * @param DomNode|null $node when null, return the data attrs as array => case component($data=[])
     * @param array $data
     * @return mixed
     */
    protected function fillNode($node, array $data)
    {
        if (is_null($node)) {
            $_data = [];
            foreach ($data as $k => &$val) {
                if ($k[0] === ':') {
                    $k = substr($k, 1);
                } else {
                    $val = "'$val'";
                }
                $_data[$k] = $val;
            }
            return $_data;
        }

        if (!method_exists($node, 'setAttribute')) {
            return;
        }
        foreach ($data as $k => $val) {
            if ($k[0] === ':') {
                $k = substr($k, 1);
                $rid = '__r'.uniqid();
                $val = "<?php echo $val; ?>";
            }
            elseif ($k === 'p-bind') {
                $rid = '__r'.uniqid();
                $k = '<?php foreach('.$val.' as $k=>$v) echo "$k=\"$v\" "; ?>';
                $val = '';
            }
            elseif ($k === 'p-raw') {
                $rid = '__r'.uniqid();
                $k = "<?php echo $val; ?>";
                $val = '';
            }
            $node->setAttribute($k, $val);
        }
    }
    
    protected function childNodes($node = null)
    {
        if (!$node) {
            $node = $this->node;
        }
        $cnodes = [];
        if (!$node->childNodes) {
            return $cnodes;
        }
        foreach ($node->childNodes as $cn) {
            if (Helper::isEmptyNode($cn)) 
            continue;
            
            $cnodes[] = $cn;
        }
        
        return $cnodes;
    }
//remove it
    protected function getNodeSlots($node, $forceDefault = false): array
    {
        $slots = [];
        if (!$node->childNodes) {
            return $slots;
        }

        // slots bound together using if else stmt should be keeped together
        $lastPos = null;
        foreach ($node->childNodes as $slotNode) {
            if (Helper::isEmptyNode($slotNode)) {
                continue;
            }

           $slotPosition = null;
           if ($slotNode->nodeName !== '#text') {
               $slotPosition = $slotNode->getAttribute('slot');
               $slotNode->removeAttribute('slot');
           }
            if ($forceDefault || !$slotPosition) {
                $slotPosition = 'default';
            }

            if ($slotNode->nodeName === '#text') {
                $slots[$slotPosition][] = $slotNode;
            }
            elseif (!$slotNode->hasAttribute('p-elseif') && !$slotNode->hasAttribute('p-else')) {
                // stands its own
                $container = new DomDocument();dd(66);
                $slotNode = $container->importNode($slotNode, true);
                $container->appendChild($slotNode);
                $slots[$slotPosition][] = $container;
                $lastPos = $slotPosition;
            } else {
                // has dependencies above
                if (isset($slots[$lastPos])) {dd(1);
                    $i = count($slots[$lastPos]) -1;
                    $slotNode = $slots[$lastPos][$i]->importNode($slotNode, true);
                    $slots[$lastPos][$i]->appendChild($slotNode);
                }
            }
        }

        return $slots;
    }
    
    protected function removeNode($node) {
        $node->parentNode->removeChild($node);
    }
    
    protected function nextSibling($node)
    {
        $node = $node->nextSibling;
        while ($node && Helper::isEmptyNode($node)) {
            $node = $node->nextSibling;
        }
        return $node;
    }

    public function __get($prop)
    {
        return $this->$prop;
    }
}