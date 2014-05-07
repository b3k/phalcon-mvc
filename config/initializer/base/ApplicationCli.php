<?php

namespace Config\Initializer\Base;

class ApplicationCli extends Config\Initializer\Base\Application
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
    );

    public function __construct($di = null)
    {
        $this->di = $di ? $di : new \Phalcon\DI\FactoryDefault\CLI();
        parent::__construct($this->di);
    }

    public function handle()
    {
        return FALSE;
    }

}
