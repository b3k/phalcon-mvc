<?php
namespace Config;

require_once(APP_ROOT_DIR . '/config/initializer/base/ApplicationCli.php');

use \Config\Initializer\Base\ApplicationCli as BaseApplication;

class ApplicationCli extends BaseApplication
{
    public function __construct()
    {
        parent::__construct();
    }

}
