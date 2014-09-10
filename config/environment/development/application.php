<?php

return array(
    'baseUri' => '/',
    'staticBaseUri' => '/',
    'timezone' => 'Europe/Warsaw',
    'publicUrl' => 'upcheck.net',
    'log' => array(
        'adapter_class' => 'Phalcon\Logger\Adapter\File',
        'formatter_class' => 'Phalcon\Logger\Formatter\Line',
        'format' => '[%date%][%type%] %message%',
        'path' => APP_LOG_DIR . DS . APP_ENV . '.log'
    ),
    'i18n' => array(
        'default' => 'pl_PL'
    ),
    'security' => array(
        'key' => 'IOjscifo9e080123nsdkk'
    ),
    'crypt' => array(
        'key' => 'UKneuif8923jhsnkKHal-__sdsdad',
        'cipher' => 'tripledes',
        'mode' => 'cbc',
        'padding' => \Phalcon\Crypt::PADDING_DEFAULT
    ),
    'users' => array(
        'manager' => 'App\Library\PropelConnector\User\Manager\Manager',
        'throttling' => TRUE,
        'login_column' => 'user_email',
    ),
    'session' => array(
        'name' => 'FSID',
        'cookie' => array(
            'lifetime' => 345600,
            'path' => '/',
            'secure' => '0',
            'httponly' => '1'
        ),
        'uniqueId' => 'falconidae',
        'hash' => 'sha1'
    ),
    'cookies' => array(
        'encrypt' => TRUE
    ),
    'amazon' => array(
        'AWSAccessKeyId' => '',
        'AWSSecretKey' => ''
    )
);
