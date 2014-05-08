<?php

namespace Config\Initializer\Base;

require_once(APP_ROOT_DIR . '/config/initializer/base/Application.php');

class ApplicationCli extends Application
{

    protected static $used_services = array(
        self::SERVICE_CONFIG,
        'errorHandler',
        'exceptionHandler',
        self::SERVICE_URL,
        self::SERVICE_CRYPT,
        self::SERVICE_ROUTER,
        self::SERVICE_ACL,
        self::SERVICE_AUTH,
        self::SERVICE_CLI_APP
    );

    public function __construct($di = null)
    {
        $this->di = $di ? $di : new \Phalcon\DI\FactoryDefault\CLI();
        parent::__construct($this->di);
    }

    public function handle()
    {
        $this->di->get(self::SERVICE_CLI_APP)->run();
    }

}
