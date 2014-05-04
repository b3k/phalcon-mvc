<?php

return array(
    'primary_connection' => 'default',
    'profiler' => array(
        'class' => '\Runtime\Runtime\Util\Profiler',
        'slow_treshold' => 0.2,
        'details' => array(
            
        )
    ),
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
        ),
        'slaves' => array(
            array(
                'adapter' => 'mysql',
                'host' => '127.0.0.2',
                'username' => 'slave1',
                'password' => 'slave1',
            ),
            array(
                'adapter' => 'mysql',
                'host' => '127.0.0.3',
                'username' => 'slave1',
                'password' => 'slave1',
            )
        )
    )
);
