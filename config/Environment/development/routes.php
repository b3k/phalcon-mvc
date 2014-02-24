<?php

$router = new Phalcon\Mvc\Router();

$router->add('/confirm/{code}/{email}', array(
    'controller' => 'user_control',
    'action' => 'confirmEmail'
));

$router->add('/reset-password/{code}/{email}', array(
    'controller' => 'user_control',
    'action' => 'resetPassword'
));

$r = array(
    'resources' => array(
        '/reset-password/{code}/{email}' => array(
            'method' => 'get',
            'controller' => 'user',
            'action' => 'someaction',
            'namespace' => 'namespace',
            'convert' => array(
                'code' => function($code) { return $code; },
                'email' => function($code) { return $code; }
            ),
            'params' => array(
                'pram1' => '',
                'param2' => ''
            )
        )
    ),
);


return $router;
