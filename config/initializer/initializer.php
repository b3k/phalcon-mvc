<?php

namespace \Config\Initializers;

use Phalcon\Loader;
use Phalcon\Cache\Frontend\Data as CacheData;
use Phalcon\Cache\Frontend\Output as CacheOutput;
use Phalcon\Db\Adapter;
use Phalcon\Db\Adapter\Pdo;
use Phalcon\Db\Profiler as DatabaseProfiler;
use Phalcon\DI\FactoryDefault;

abstract class BaseInitializer {   
    
    protected $di;
    
    abstract public function initialize();
}
