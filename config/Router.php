<?php

namespace Config;

require_once(APP_ROOT_DIR . '/config/initializer/base/Router.php');

use Config\Initializer\Base\Router as BaseRouter;

class Router extends BaseRouter {

    protected $default_controller = 'index';
    protected $default_action = 'index';

    public function __construct() {
        parent::__construct(FALSE);
        $this->loadDefaults();
        $this->loadApplicationRoutes();
    }

}

return new Router;