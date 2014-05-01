<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Config\Initializer\Base;

use \Phalcon\Mvc\Router as PhalconRouter;

/**
 * Description of Config
 *
 * @author b3k
 */
class Router extends PhalconRouter {

    protected $default_controller = 'index';
    protected $default_action = 'index';
    protected $default_index_action = 'index';
    
    protected $not_found_controller = 'error';
    protected $not_found_action = 'error404';


    public function __construct() {
        parent::__construct();
    }

    public function loadApplicationRoutes() {
        require_once(APP_ROOT_DIR . '/config/environment/' . APP_ENV . '/routing.php');
    }

    public function loadDefaults() {
        $this->setDefaultController($this->default_controller);
        $this->setDefaultAction($this->default_action);

        $this->add('/:controller/:action/:params', array(
            'controller' => 1,
            'action' => 2,
            'params' => 3,
        ));

        $this->add('/:controller/:int', array(
            'controller' => 1,
            'action' => $this->default_index_action,
            'id' => 2,
        ));

        $this->add('/:controller[/]?', array(
            'controller' => 1,
            'action' => $this->default_index_action
        ));

        $this->add('/', array(
            'controller' => $this->default_controller,
            'action' => $this->default_action
        ));

        $this->notFound(array(
            'controller' => $this->not_found_controller,
            'action' => $this->not_found_action
        ));
    }

}
