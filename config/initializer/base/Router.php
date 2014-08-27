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
class Router extends PhalconRouter
{

    protected $default_controller = 'index';
    protected $default_action = 'index';
    protected $default_format = 'html';
    protected $default_index_action = 'index';
    protected $not_found_controller = 'error';
    protected $not_found_action = 'error404';

    public function __construct()
    {
        parent::__construct();
    }

    public function add($pattern, $paths = NULL, $httpMethods = NULL)
    {
        $route_name = $this->generateRouteName($paths);
        $Route = parent::add($pattern, $paths, $httpMethods);
        if ($route_name) {
            $Route->setName($route_name);
        }
        return $Route;
    }

    public function generateRouteName($paths)
    {
        $route_name = '';
        if (is_array($paths)) {
            // set names only for routes
            if (isset($paths['controller']) &&
                    !is_integer($paths['controller']) &&
                    isset($paths['action']) &&
                    !is_integer($paths['action'])) {
                $route_name .= str_replace('_', '-', strtolower($paths['controller']));
                $route_name .= '_' . str_replace('_', '-', strtolower($paths['action']));
                if (isset($paths['format']) && !is_integer($paths['format'])) {
                    $route_name .= '_' . strtolower($paths['format']);
                }
            }
        } elseif (is_string($paths) && strpos($paths, '::') !== FALSE) {
            $paths_parts = explode('::', strtolower($paths));
            $route_name .= $paths_parts[0] . '_' . $paths_parts[1];
        }
        return empty($route_name) ? null : $route_name;
    }

    public function loadApplicationRoutes()
    {
        require_once(APP_ROOT_DIR . '/config/environment/' . APP_ENV . '/routing.php');
    }

    public function loadDefaults()
    {
        $this->removeExtraSlashes(true);
        $this->setDefaultController($this->default_controller);
        $this->setDefaultAction($this->default_action);

        $this->add('/:controller/:action\.([a-z]+)/:params', array(
            'controller' => 1,
            'action' => 2,
            'format' => 3,
            'params' => 4,
        ))->setName('default-schema');

        $this->add('/:controller\.([a-z]+)/:int', array(
            'controller' => 1,
            'action' => $this->default_index_action,
            'id' => 3,
            'format' => 2
        ))->setName('default-schema-action-with-id');

        $this->add('/:controller\.([a-z]+)[/]?', array(
            'controller' => 1,
            'format' => 2,
            'action' => $this->default_index_action
        ))->setName('default-schema-action');

        $this->add('/', array(
            'controller' => $this->default_controller,
            'action' => $this->default_action,
            'format' => $this->default_format
        ))->setName('index');

        $this->notFound(array(
            'controller' => $this->not_found_controller,
            'action' => $this->not_found_action,
            'format' => $this->default_format
        ));
    }

}
