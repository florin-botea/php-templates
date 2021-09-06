<?php

namespace DomDocument\PhpTemplates;

use DomDocument\PhpTemplates\Parser;

class Template
{
    // requestName => [requestName => filemtime, ...other components]
    private static $dependencies = null;
    private static $timestamps = []; // cache file $timestamps
    
    public static function getUpdatedAt(string $file)
    {
        if (!isset(self::$timestamps[$file])) {
            self::$timestamps[$file] = filemtime($file);
        }
        return self::$timestamps[$file];
    }
    
    private $options = [
        'prefix' => '@',
        'src_path' => 'views/',
        'dest_path' => 'parsed/',
        'track_changes' => true,
    ];
    
    private $checkedDependencies = [];
    private $requestName;
    private $srcFile;
    private $destFile;
    private $slots = [];
    
    public function __construct(array $options = [])
    {
        if (self::$dependencies === null) {
            self::$dependencies = require_once('dependencies_map.php');
        }
        $this->mergeOptions($options);
    }
    
    private function mergeOptions($options)
    {
        if (isset($options['prefix'])) {
            if (!trim($options['prefix'])) {
                unset($options['prefix']);
            }
        }
        $this->options = (object) array_merge((array) $this->options, $options);
    }
    
    public function load(string $rfilepath, array $data = [], array $slots = [], array $options = [])
    {
        $this->setData($rfilepath, $data, $slots);
check hhash, 
if file found
mount slots
else
mount parser
mount slots

        $this->getParsedHtml();

        // new parser($cfg)->parse(file) intoarce str html
        // replaces urile salvate pe o statica
        // cand ajung la un comp, inlocuiesc nodul cu chemare funcie cf reqname.i
        // ii trec ca sloturi nodurile si intorc cu load() optiune sa imi intoarca string si am ajuns aici
        // save pe statica nume f => declarare function
        // la fel si cand dau de sloturi daca sunt, daca nu, delete nodurile
        // la final, trb doar sa fac replaceuri si output si sa curat staticele
    }

    private function getParsedHtml() 
    {
        $this->destFile = $this->getDestFile(); // based on req file, timestamp, slotsHash

        $hasChanged = $this->options->track_changes && $this->syncDependencies($this->requestName);
        if (!$hasChanged && file_exists($this->destFile)) {
            return require($this->destFile);
        }

        $parser = new Parser($this->srcFile, $this->data, $this->slots, (array) $this->options);
        if (!Parser::root) {
            Parser::root = $parser;
        }
        $parser->parse();
    }

    private function getSrcFile()
    {
        if (!$this->srcFile) {
            $f = $this->options->src_path;
            $this->srcFile = $f.$this->requestName.'.template.php';
        }
        return $this->srcFile;
    }
    
    // based on this output, we decide if to recompile template
    private function getDestFile()
    {
        if (!$this->destFile) {
            $f = str_replace('/', '_', $this->requestName);
            if ($this->options->track_changes) {
                $f .= '-'.self::getUpdatedAt($this->getSrcFile());
            }
            if ($slotsHash = $this->getHash()) {
                $f .= '-'.$slotsHash;
            }
            $this->destFile = $f;
        }
        return $this->destFile;
    }
    
    private function syncDependencies(string $reqName): bool
    {
        // ignoee self from list for avoíding infinite loop
        if (in_array($reqName, $this->checkedDependencies)) {
            return false;
        }
        $this->checkedDependencies[] = $reqName;
        
        $dependencies = self::$dependencies[$reqName] ?? [];
        $updated = false;
        foreach ($dependencies as $_reqName => $timestamp) {
            $nowstamp = filemtime($this->getSrcFile($_reqName));
            self::$dependencies[$reqName][$_reqName] = $nowstamp;
            $updated = $updated || $timestamp === $nowstamp;
            $updated = $updated || $this->syncDependencies($reqName);
        }
        return $updated;
    }
    
    private function getHash(): string
    {// if is qslot, add q, mode and (str hash/comp time)
        $hash = self::getUpdatedAt($this->getSrcFile());
        foreach ($this->slots as $slot) {
            if ($slot instanceof self) {
                $hash .= filemtime($slot->getSrcFile());
                $hash .= $slot->getHash();
            } 
            else {
                
            }
        }
        if (!$hash) {
            return '';
        }
        return substr(md5($hash, true), 0, 12);
    }
    
    
    
    public function component(string $rfilepath, array $data = [], array $slots = [], array $options = [])
    {
        $this->setData($rfilepath, $data, $slots);

        return $this;
    }

    private function setData(string $rfilepath, array $data = [], array $slots = [], array $options = [])
    {
        $this->rfilepath = $rfilepath;
        $this->data = $data;
        $this->slots = $slots;
        $this->requestName = preg_replace('(\.template|\.php)', '', $this->rfilepath);
        $this->srcFile = $this->getSrcFile();
    }
}
