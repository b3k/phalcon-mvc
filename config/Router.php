<?php

namespace Config;

require_once(APP_ROOT_DIR . '/config/initializer/base/Router.php');

use Config\Initializer\Base\Router as BaseRouter;

class Router extends BaseRouter
{
    /**
     * Default controller: index
     *
     * @var string
     */
    protected $default_controller = 'index';
    
    /**
     * Default action: index
     *
     * @var string
     */
    protected $default_action = 'index';

    /**
     * Create instance, load whole configuration and routes
     * 
     */
    public function __construct()
    {
        parent::__construct(FALSE);
        $this->loadDefaults();
        $this->loadApplicationRoutes();
    }

}

/**
 * Initialize Router
 */
return new Router;