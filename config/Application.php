<?php

namespace Config;

require_once(APP_ROOT_DIR . '/config/initializer/base/Application.php');

use Config\Initializer\Base\Application as BaseApplication;

class Application
        extends BaseApplication
{

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
        self::SERVICE_AUTH,
    );

    public function __construct()
    {
        parent::__construct();
    }

}
