<?php

return array(
    'cache' => array(
        'frontend_adapter' => '\Phalcon\Cache\Frontend\Data',
        'frontend_options' => array(
            'lifetime' => 8200
        ),
        'backend_adapter' => '\Phalcon\Cache\Backend\File',
        'backend_options' => array(
            'cacheDir' => APP_TMP_DIR . DS . 'cache',
            'prefix' => 'cache_'
        ),
    ),
    'viewCache' => array(
        'frontend_adapter' => '\Phalcon\Cache\Frontend\Output',
        'frontend_options' => array(
            'lifetime' => 8200
        ),
        'backend_adapter' => '\Phalcon\Cache\Backend\File',
        'backend_options' => array(
            'cacheDir' => APP_TMP_DIR . DS . 'cache',
            'prefix' => 'view_'
        ),
    )
);
