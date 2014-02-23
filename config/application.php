<?php

namespace \Config\Initializers;

use Phalcon\Loader;
use Phalcon\Cache\Frontend\Data as CacheData;
use Phalcon\Cache\Frontend\Output as CacheOutput;
use Phalcon\Db\Adapter;
use Phalcon\Db\Adapter\Pdo;
use Phalcon\Db\Profiler as DatabaseProfiler;
use Phalcon\DI;
use Phalcon\Events\Manager;
use Phalcon\Mvc\Application as PhalconApplication;

class Application extends BaseInitializer {

    public function initialize() {
        $this->di = new FactoryDefault();
        $this->application = new PhalconApplication();
        $this->di->setShared('application', $this);
        
    }

}

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

