<?php

namespace App\Library\Cache;

use Phalcon\Mvc\User\Component;
use Phalcon\Cache\BackendInterface;

class Manager extends Component
{

    protected $backends = array();

    /**
     * Cache manager allows you to save data in multi-layered cache system
     * 
     * if you want to save some data in cache, its saved in all backends.
     * 
     * if you want to get some data, manager will ask each backend and if any of them answer, then we stops process and return value
     * 
     * @param array $backends
     * @throws \RuntimeException
     */
    public function __construct(Array $backends)
    {
        if (empty($backends)) {
            throw new \RuntimeException("Cache manager should have at least one cache backend.");
        }

        foreach ($backends as $backend) {
            if ($backend instanceof BackendInterface) {
                $this->backends[] = $backend;
            }
        }
    }

    public function save($key, $value, $lifetime = null)
    {
        foreach ($this->backends as $backend) {
            $backend->save($key, $value, $lifetime);
        }
        return true;
    }

    public function get($key)
    {
        foreach ($this->backends as $backend) {
            if ($backend->exists($key)) {
                return $backend->get($key);
            }
        }
    }

    public function is_set($name)
    {
        
    }

    public function __get($name)
    {
        return $this->get($name);
    }

    public function __set($name, $value)
    {
        return $this->set($name, $value);
    }

    public function __isset($name)
    {
        return $this->is_set($name);
    }

}
