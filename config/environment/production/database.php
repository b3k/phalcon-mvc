<?php

return array(
    'log' => array(
        'enabled' => true,
        'type' => 'file',
        'name' => '/tmp/to/',
        'ident' => 'falconidae',
        'level' => 7
    ),
    'default' => array(
        'adapter' => 'mysql',
        'host' => '127.0.0.1',
        'username' => 'root',
        'password' => '1769root',
        'dbname' => 'upcheck',
        'charset' => 'utf-8',
        'cache_query' => true,
        'options' => array(
            'pdo' => array(
                'ATTR_PERSISTENT' => false
            ),
            'ATTR_STATEMENT_CLASS' => 'PDOStatement',
            'ATTR_ERRMODE' => 'PDO::ERRMODE_WARNING',
        ),
        'init_query' => array(
            'select * from table1;',
            'select * from table2;'
        )
    ),
    'slave' => array(
        'adapter' => 'mysql',
        'host' => '127.0.0.2',
        'username' => 'slave1',
        'password' => 'slave1',
    )
);
