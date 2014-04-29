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
    'cookies' => array(
        'encrypt' => TRUE
    ),
    'amazon' => array(
        'AWSAccessKeyId' => '',
        'AWSSecretKey' => ''
    )
);
