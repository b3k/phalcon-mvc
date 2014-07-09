<?php

return array(
    'cache' => array(
        'frontend_adapter' => '\Phalcon\Cache\Backend\Data',
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
        'frontend_adapter' => '\Phalcon\Cache\Backend\Output',
        'frontend_options' => array(
            'lifetime' => 8200
        ),
        'backend_adapter' => '\Phalcon\Cache\Backend\File',
        'backend_options' => array(
            'cacheDir' => APP_TMP_DIR . DS . 'cache',
            'prefix' => 'view_'
        ),
    ),
    'backends' => array(
        array(
            'adapter' => '\Phalcon\Cache\Backend\File',
            'lifetime' => 600,
            'options' => array(
                'cacheDir' => APP_TMP_DIR . DS . 'cache',
                'prefix' => 'cache1_'
            )
        ),
        array(
            'adapter' => '\Phalcon\Cache\Backend\Apc',
            'lifetime' => 1200,
            'options' => array(
                'cacheDir' => APP_TMP_DIR . DS . 'cache',
                'prefix' => 'cache2_'
            )
        )
    )
);
