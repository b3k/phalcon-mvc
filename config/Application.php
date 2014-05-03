<?php

namespace Config;

require_once(APP_ROOT_DIR . '/config/initializer/base/Application.php');

use Config\Initializer\Base\Application as BaseApplication;

class Application extends BaseApplication
{
    public function __construct()
    {
        parent::__construct();
    }

}
