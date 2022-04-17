<?php

namespace PhpTemplates;

class Template
{
    /**
     * configs keyed by namespace
     */
    protected $configs = [];
    protected $destPath;
    
    public function __construct(string $srcPath, string $destPath) {
        $this->destPath = $destPath;
        $this->configs['default'] = new Config('default', $srcPath);
    }
    
    public function load(string $rfilepath, array $data = [], $slots = [])
    {
        $start_time = microtime(true);
        $template = $this->get($rfilepath, $data, $slots);
        $template->render($data);
        print_r('<br>'.(microtime(true) - $start_time));
    }

    public function get(string $rfilepath, array $data = [], $slots = [])
    {
        if (isset(Parsed::$templates[$rfilepath])) {
            return Parsed::template($rfilepath, $data);
        } else {
            $requestName = preg_replace('(\.template|\.php)', '', $rfilepath);
            // init the document with custom settings as src_path, aliases
            // paths will fallback on default Config in case of file not found or setting not found
            $doc = new Document($this->destPath, $requestName);
            if ($path = $doc->exists($this->destPath) && 0) {} 
            else {
                $process = new Process($rfilepath, $this->configs);
                (new TemplateFunction($process, $rfilepath))->parse();
                $doc->setContent($process->getResult());
                $path = $doc->save();
            }

            require_once($path);
            return Parsed::template($requestName, $data)->setSlots($slots);
        }
    }

    public function raw(\Closure $cb, $data = [])
    {
        return Parsed::raw(null, $cb, $data);
    }
    
    /**
     * Add additional parse src path
     */
    public function addPath($name, $srcPath)
    {
        if (isset($this->configs[$name])) {
            throw new \Exception("Config '$name' already exists");
        }
        $this->configs[$name] = new Config($name, $srcPath);
    }

    public function replacePath($name, $srcPath)
    {
        if (!isset($this->configs[$name])) {
            $this->addPath($name, $srcPath);
        } else {
            $this->configs[$name]->setSrcPath($srcPath);
        }
    }
    
    public function addDirective(string $key, \Closure $callable, $path = 'default'): void
    {
        if (!isset($this->configs[$path])) {
            throw new \Exception('Config path not found');
        } 
        elseif ($this->configs[$path]->hasDirective($key)) {
            throw new \Exception('Directive already exists');
        }
        $this->configs[$path]->addDirective($key, $callable);
    }

    public function addAlias(string $key, string $value, $path = 'default'): void
    {
        if (!isset($this->configs[$path])) {
            throw new \Exception('Config path not found');
        } 
        elseif ($this->configs[$path]->hasAlias($key)) {
            throw new \Exception('Alias already exists');
        }
        $this->configs[$path]->addAlias($key, $value);
    }
    
    public function setDestPath($dest)
    {
        $this->destPath = $dest;
    }
}
