<?php

namespace Config;

require_once(APP_ROOT_DIR . '/config/initializer/base/ApplicationCli.php');

use \Config\Initializer\Base\ApplicationCli as BaseApplication;

class ApplicationCli
        extends BaseApplication
{

    protected static $used_services = array(
        self::SERVICE_CONFIG,
        'errorHandler',
        'exceptionHandler',
        self::SERVICE_URL,
        self::SERVICE_CACHE,
        self::SERVICE_CRYPT,
        self::SERVICE_ROUTER,
        self::SERVICE_ACL,
        self::SERVICE_AUTH,
        self::SERVICE_PROPEL,
        self::SERVICE_CLI_APP
    );

    public function __construct()
    {
        parent::__construct();
    }

}
