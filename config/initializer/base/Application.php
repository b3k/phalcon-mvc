<?php

namespace Config\Initializer\Base;

class Application extends \Phalcon\Mvc\Application {

    protected $di;
    protected $config;
    protected $routing;
    protected static $services = array(
        'config',
        'errorHandler',
        'exceptionHandler',
        'dispatcher',
        'router',
        'url',
        'request',
        'response',
        'cookies',
        'filter',
        'flash',
        'flashSession',
        'session',
        'eventsManager',
        'db',
        'crypt',
        'modelsMetadata',
        'modelsCache',
        'viewCache'
    );

    public function __construct() {
        $this->config = require_once APP_ROOT_DIR . '/config/Config.php';
        $this->routing = require_once APP_ROOT_DIR . '/config/Router.php';

        date_default_timezone_set($this->config->application->timezone);

        $this->di = new \Phalcon\DI\FactoryDefault();

        $this->loadServices();

        $this->di->set('app', $this);

        parent::setDI($this->di);
    }

    public function run() {
        return $this->handle();
    }

    protected function loadServices() {
        foreach (self::$services as $service) {
            $method = 'init' . ucfirst($service);
            if (method_exists($this, $method)) {
                $this->$method();
            }
        }
    }

    protected function initViewCache() {
        $config = $this->config;
        $this->di->set('viewsCache', function() use ($config) {
            $frontCache = new \Phalcon\Cache\Frontend\Output(array(
                "lifetime" => 86400
            ));
            $cache = new Phalcon\Cache\Backend\File($frontCache, array(
                "cacheDir" => APP_ROOT_DIR . '/tmp/'
            ));
            return $cache;
        });
    }

    protected function initTransactionManager() {
        $this->di->set('transactionManager', function() {
            
        });
    }

    protected function initModelsCache() {
        $this->di->set('modelsCache', function() {
            
        });
    }

    protected function initModelsMetadata() {
        $this->di->set('modelsMetadata', function() {
            
        });
    }

    protected function initAnnotations() {
        $this->di->set('annotations', function() {
            
        });
    }

    protected function initLoader() {
        $loader = new \Phalcon\Loader();
        $loader->registerNamespaces(array(
            'App\Models' => APP_ROOT_DIR . ''
        ))->register();
    }

    protected function initEscaper() {
        $this->di->set('escaper', function() {
            
        });
    }

    protected function initTag() {
        $this->di->set('tag', function() {
            
        });
    }

    protected function initCrypt() {
        $this->di->set('crypt', function() {
            
        });
    }

    protected function initDb() {
        $this->di->set('db', function() {
            
        });
    }

    protected function initSecurity() {
        $this->di->set('security', function() {
            
        });
    }

    protected function initFlashSession() {
        $this->di->set('flashSession', function() {
            
        });
    }

    protected function initEventsManager() {
        $this->di->set('eventsManager', function() {
            
        });
    }

    protected function initSession() {
        $config = $this->config;
        $this->di->set('session', function() use ($config) {
            $session = new \Phalcon\Session\Adapter\Files();
            $session->start();
            return $session;
        });
    }

    protected function initFlash() {
        $config = $this->config;
        $this->di->set('flash', function() use ($config) {
            $flash = new \Phalcon\Flash\Session(array(
                'warning' => 'alert alert-warning',
                'notice' => 'alert alert-info',
                'success' => 'alert alert-success',
                'error' => 'alert alert-danger',
                'dismissable' => 'alert alert-dismissable',
            ));
            return $flash;
        });
    }

    protected function initCookies() {
        $this->di->set('cookies', function() {
            
        });
    }

    protected function initFilter() {
        $this->di->set('filter', function() {
            
        });
    }

    protected function initResponse() {
        $this->di->set('url', function() {
            
        });
    }

    protected function initUrl() {
        $config = $this->config;
        $this->di->set('url', function() use ($config) {
            $url = new \Phalcon\Mvc\Url();
            $url->setBaseUri($config->app->base_uri);
            $url->setStaticBaseUri($config->app->static_base_uri);
            return $url;
        });
    }

    protected function initRequest() {
        $this->di->set('request', function() {
            return new \Phalcon\Http\Request();
        });
    }

    protected function initDispatcher() {
        $this->di->set('dispatcher', function() {
            
        });
    }

    protected function initRouter() {
        $routing = $this->routing;
        $this->di->set('router', function() use ($routing) {
            return $routing;
        });
    }

    protected function initErrorHandler() {
        set_error_handler(function ($err_severity, $err_msg, $err_file, $err_line, array $err_context) {
            if (0 === error_reporting()) {
                return false;
            }
            switch ($err_severity) {
                case \E_ERROR: throw new ErrorException($err_msg, 0, $err_severity, $err_file, $err_line);
                case \E_WARNING: throw new WarningException($err_msg, 0, $err_severity, $err_file, $err_line);
                case \E_PARSE: throw new ParseException($err_msg, 0, $err_severity, $err_file, $err_line);
                case \E_NOTICE: throw new NoticeException($err_msg, 0, $err_severity, $err_file, $err_line);
                case \E_CORE_ERROR: throw new CoreErrorException($err_msg, 0, $err_severity, $err_file, $err_line);
                case \E_CORE_WARNING: throw new CoreWarningException($err_msg, 0, $err_severity, $err_file, $err_line);
                case \E_COMPILE_ERROR: throw new CompileErrorException($err_msg, 0, $err_severity, $err_file, $err_line);
                case \E_COMPILE_WARNING: throw new CoreWarningException($err_msg, 0, $err_severity, $err_file, $err_line);
                case \E_USER_ERROR: throw new UserErrorException($err_msg, 0, $err_severity, $err_file, $err_line);
                case \E_USER_WARNING: throw new UserWarningException($err_msg, 0, $err_severity, $err_file, $err_line);
                case \E_USER_NOTICE: throw new UserNoticeException($err_msg, 0, $err_severity, $err_file, $err_line);
                case \E_STRICT: throw new StrictException($err_msg, 0, $err_severity, $err_file, $err_line);
                case \E_RECOVERABLE_ERROR: throw new RecoverableErrorException($err_msg, 0, $err_severity, $err_file, $err_line);
                case \E_DEPRECATED: throw new DeprecatedException($err_msg, 0, $err_severity, $err_file, $err_line);
                case \E_USER_DEPRECATED: throw new UserDeprecatedException($err_msg, 0, $err_severity, $err_file, $err_line);
            }
        });
    }

    protected function initExceptionHandler() {
        set_exception_handler(function($exception) {
            echo 'Exception throwed: ' . $exception->getMessage();
        });
    }

    protected function initConfig() {
        $this->di->set('config', $this->config);
    }

}

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

