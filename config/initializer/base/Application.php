<?php

namespace Config\Initializer\Base;

/**
 * 
 */
class Application extends \Phalcon\Mvc\Application {

    const SERVICE_CONFIG = 'config';
    const SERVICE_VIEW = 'view';
    const SERVICE_LOADER = 'loader';
    const SERVICE_ROUTER = 'router';
    const SERVICE_COOKIES = 'cookies';
    const SERVICE_URL = 'url';
    const SERVICE_SECURITY = 'security';
    const SERVICE_FLASH = 'flash';
    const SERVICE_FLASH_SESSION = 'flashSession';
    const SERVICE_SESSION = 'flashSession';
    const SERVICE_DISPATCHER = 'dispatcher';
    const SERVICE_VIEWS_CACHE = 'viewCache';
    const SERVICE_CACHE = 'cache';
    const SERVICE_CRYPT = 'crypt';
    const SERVICE_ACL = 'acl';

    protected $di;
    protected $config;

    /**
     * @var array
     */
    protected $routing;

    /**
     *
     * @var array
     */
    protected $base_acl_list = array(
        'default' => \Phalcon\Acl::DENY,
        'list' => array(
            'index' => array(
                'index' => '*',
            ),
            'user' => array(
                'logout' => '*',
                'login' => '*',
                'resetPassword' => '*',
            ),
            'error' => array(
                'error404' => '*',
                'error500' => '*'
            )
        ),
        'roles' => array(
            'guest', 'user', 'admin'
        )
    );
    protected $response;

    /**
     * @var array
     */
    protected static $used_services = array(
        self::SERVICE_CONFIG,
        'errorHandler',
        'exceptionHandler',
        self::SERVICE_DISPATCHER,
        self::SERVICE_SECURITY,
        self::SERVICE_URL,
        self::SERVICE_COOKIES,
        self::SERVICE_SESSION,
        self::SERVICE_FLASH,
        self::SERVICE_FLASH_SESSION,
        self::SERVICE_CRYPT,
        self::SERVICE_VIEWS_CACHE,
        self::SERVICE_VIEW,
        self::SERVICE_ROUTER,
        self::SERVICE_ACL,
    );

    public function __construct($di = null) {
        $this->config = require_once APP_CONFIG_DIR . DS . 'Config.php';
        $this->routing = require_once APP_CONFIG_DIR . DS . 'Router.php';

        date_default_timezone_set($this->config->application->timezone);

        $this->di = $di ? $di : new \Phalcon\DI\FactoryDefault();

        $this->loadServices();

        $this->di->set('app', $this);

        parent::__construct($this->di);
    }

    protected function loadServices() {
        foreach (self::$used_services as $service) {
            $method = 'init' . ucfirst($service);
            if (method_exists($this, $method)) {
                $this->$method();
            }
        }
    }

    public function getBaseAclList() {
        return $this->base_acl_list;
    }

    protected function initConfig() {
        $this->di->set(self::SERVICE_CONFIG, $this->config);
    }

    protected function initAcl() {
        $config = $this->config;
        $this->di->set(self::SERVICE_ACL, function() use ($config) {
            $Acl = new \App\Library\User\Acl\Acl();
            return $Acl;
        });
    }

    protected function initView() {
        $config = $this->config;
        $this->di->set(self::SERVICE_VIEW, function() use ($config) {
            $view = new \Phalcon\Mvc\View();
            $view->setViewsDir(APP_VIEWS_DIR . DS);
            $view->registerEngines(
                    array(
                        '.volt' => function($view, $di) {
                    $volt = new \Phalcon\Mvc\View\Engine\Volt($view, $di);

                    $volt->setOptions(array(
                        "compiledPath" => APP_TMP_DIR . DS . 'volt' . DS,
                        "compiledExtension" => ".compiled"
                    ));

                    return $volt;
                },
                        '.php' => 'Phalcon\Mvc\View\Engine\Php'
                    )
            );
            return $view;
        });
    }

    protected function initDispatcher() {
        $config = $this->config;
        $this->di->set(self::SERVICE_DISPATCHER, function() use ($config) {
            $EventsManager = new \Phalcon\Events\Manager();
            $EventsManager->attach("dispatch", function($event, $dispatcher, $exception) {
                if ($event->getType() == 'beforeException') {
                    switch ($exception->getCode()) {
                        case \Phalcon\Dispatcher::EXCEPTION_HANDLER_NOT_FOUND:
                        case \Phalcon\Dispatcher::EXCEPTION_ACTION_NOT_FOUND:
                            //var_dump($dispatcher->getNamespaceName());
                            //var_dump($dispatcher->getActionName());
                            $dispatcher->forward(array(
                                'controller' => 'error',
                                'action' => 'error404'
                            ));
                            return FALSE;
                    }
                }
            });

            $Dispatcher = new \Phalcon\Mvc\Dispatcher();
            $Dispatcher->setDefaultNamespace('App\Controllers');
            $Dispatcher->setEventsManager($EventsManager);
            return $Dispatcher;
        });
    }

    protected function initSecurity() {
        $config = $this->config;
        $this->di->set(self::SERVICE_SECURITY, function() use ($config) {
            $Security = new \Phalcon\Security();
            $Security->setDefaultHash($config->application->security->key);
            return $Security;
        });
    }

    protected function initViewCache() {
        $config = $this->config;
        foreach (array(self::SERVICE_VIEWS_CACHE, self::SERVICE_CACHE) as $service) {
            $this->di->set($service, function() use ($config) {
                $frontendAdapter = $config->cache->{$service}->frontend_adapter;
                $backendAdapter = $config->cache->{$service}->backend_adapter;

                $FrontCache = new $frontendAdapter(array(
                    $config->cache->{$service}->frontend_options->toArray()
                ));
                $BackendCache = new $backendAdapter($FrontCache, array(
                    $config->cache->{$service}->backend_options->toArray()
                        )
                );
                return $BackendCache;
            });
        }
    }

    protected function generateClassMap() {
        $Finder = new \Symfony\Component\Finder\Finder();
        $Finder->files()->in(APP_APPLICATION_DIR)->notPath(APP_VIEWS_DIR)->name('*.php');
        $result = array();
        foreach ($Finder as $file) {
            $path = explode('/', $file->getRelativePathname());
            $path = array_map(function($path) {
                return ucfirst(strtolower($path));
            }, $path);
            $result['App\\' . str_replace('.php', '', implode('\\', $path))] = $file->getRealpath();
        }
        //var_dump($result);
    }

    /**
     * We use composer autoloader
     */
    protected function initLoader() {

        /* if (!file_exists(APP_TMP_DIR . DS . 'classmap.php')) {
          $this->generateClassMap();
          } */

        $loader = new \Phalcon\Loader();
        $loader->registerNamespaces(array(
            'App\Controllers' => APP_APPLICATION_DIR . DS . 'controllers' . DS,
            'App\Models' => APP_APPLICATION_DIR . DS . 'models' . DS,
            'App\Forms' => APP_APPLICATION_DIR . DS . 'forms' . DS,
            'App\Library' => APP_APPLICATION_DIR . DS . 'library' . DS,
            'App\Tasks' => APP_APPLICATION_DIR . DS . 'tasks' . DS,
            'App\Config' => APP_APPLICATION_DIR . DS . 'config' . DS,
        ))->register();
    }

    protected function initCrypt() {
        $config = $this->config;
        $this->di->set(self::SERVICE_CRYPT, function() use ($config) {
            $crypt = new \Phalcon\Crypt();
            $crypt->setKey($config->application->crypt->key);
            $crypt->setCipher($config->application->crypt->cipher);
            $crypt->setMode($config->application->crypt->mode);
            $crypt->setPadding($config->application->crypt->mode);
            return $crypt;
        });
    }

    protected function initSession() {
        $config = $this->config;
        $this->di->set(self::SERVICE_SESSION, function() use ($config) {
            $session = new \Phalcon\Session\Adapter\Files();
            $session->setOptions(array('uniqueId' => $config->application->session->uniqueId));
            $session->start();
            return $session;
        });
    }

    protected function initFlash() {
        $config = $this->config;
        $this->di->set(self::SERVICE_FLASH, function() use ($config) {
            $flash = new \Phalcon\Flash\Direct(array(
                'warning' => 'alert alert-warning',
                'notice' => 'alert alert-info',
                'success' => 'alert alert-success',
                'error' => 'alert alert-danger',
                'dismissable' => 'alert alert-dismissable',
            ));
            return $flash;
        });
    }

    protected function initFlashSession() {
        $config = $this->config;
        $this->di->set(self::SERVICE_FLASH_SESSION, function() use ($config) {
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

    protected function initUrl() {
        $config = $this->config;
        $this->di->set(self::SERVICE_URL, function() use ($config) {
            $url = new \Phalcon\Mvc\Url();
            $url->setBaseUri($config->application->baseUri);
            $url->setStaticBaseUri($config->application->staticBaseUri);
            return $url;
        });
    }

    protected function initCookies() {
        $config = $this->config;
        $this->di->set(self::SERVICE_COOKIES, function() use ($config) {
            $Cookies = new \Phalcon\Http\Response\Cookies();
            $Cookies->useEncryption($config->application->cookies->encrypt);
            return $Cookies;
        });
    }

    protected function initRouter() {
        $routing = $this->routing;
        $this->di->set(self::SERVICE_ROUTER, function() use ($routing) {
            return $routing;
        });
    }

    protected function initErrorHandler() {
        set_error_handler(function ($err_severity, $err_msg, $err_file, $err_line, array $err_context) {
            if (0 === error_reporting()) {
                return false;
            }
            switch ($err_severity) {
                case \E_ERROR: throw new \ErrorException($err_msg, 0, $err_severity, $err_file, $err_line);
                case \E_WARNING: throw new \WarningException($err_msg, 0, $err_severity, $err_file, $err_line);
                case \E_PARSE: throw new \ParseException($err_msg, 0, $err_severity, $err_file, $err_line);
                case \E_NOTICE: throw new \NoticeException($err_msg, 0, $err_severity, $err_file, $err_line);
                case \E_CORE_ERROR: throw new \CoreErrorException($err_msg, 0, $err_severity, $err_file, $err_line);
                case \E_CORE_WARNING: throw new \CoreWarningException($err_msg, 0, $err_severity, $err_file, $err_line);
                case \E_COMPILE_ERROR: throw new \CompileErrorException($err_msg, 0, $err_severity, $err_file, $err_line);
                case \E_COMPILE_WARNING: throw new \CoreWarningException($err_msg, 0, $err_severity, $err_file, $err_line);
                case \E_USER_ERROR: throw new \UserErrorException($err_msg, 0, $err_severity, $err_file, $err_line);
                case \E_USER_WARNING: throw new \UserWarningException($err_msg, 0, $err_severity, $err_file, $err_line);
                case \E_USER_NOTICE: throw new \UserNoticeException($err_msg, 0, $err_severity, $err_file, $err_line);
                case \E_STRICT: throw new \StrictException($err_msg, 0, $err_severity, $err_file, $err_line);
                case \E_RECOVERABLE_ERROR: throw new \RecoverableErrorException($err_msg, 0, $err_severity, $err_file, $err_line);
                case \E_DEPRECATED: throw new \DeprecatedException($err_msg, 0, $err_severity, $err_file, $err_line);
                case \E_USER_DEPRECATED: throw new \UserDeprecatedException($err_msg, 0, $err_severity, $err_file, $err_line);
            }
        });
    }

    protected function initExceptionHandler() {
        set_exception_handler(function($exception) {
            echo 'Exception throwed: ' . $exception->getMessage();
        });
    }

    public function request($location, $data = null) {
        $dispatcher = clone $this->getDI()->get('dispatcher');

        if (isset($location['controller'])) {
            $dispatcher->setControllerName($location['controller']);
        } else {
            $dispatcher->setControllerName('index');
        }

        if (isset($location['action'])) {
            $dispatcher->setActionName($location['action']);
        } else {
            $dispatcher->setActionName('index');
        }

        if (isset($location['params'])) {
            if (is_array($location['params'])) {
                $dispatcher->setParams($location['params']);
            } else {
                $dispatcher->setParams((array) $location['params']);
            }
        } else {
            $dispatcher->setParams(array());
        }

        $dispatcher->dispatch();

        $response = $dispatcher->getReturnedValue();
        if ($response instanceof ResponseInterface) {
            return $response->getContent();
        }

        return $response;
    }

}
