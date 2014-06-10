<?php

return array(
    'baseUri' => '/',
    'staticBaseUri' => '/',
    'timezone' => 'Europe/Warsaw',
    'publicUrl' => 'upcheck.net',
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
        'repository_class' => 'App\Model\UserQuery',
        'throttling' => TRUE,
        'login_column' => 'user_email'
    ),
    'cookies' => array(
        'encrypt' => TRUE
    ),
    'amazon' => array(
        'AWSAccessKeyId' => '',
        'AWSSecretKey' => ''
    )
);
