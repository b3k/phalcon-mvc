<?php

return array(
    'propel' => array(
        'database' => array(
            'connections' => array(
                'default' => array(
                    'adapter' => 'mysql',
                    'classname' => 'Propel\Runtime\Connection\DebugPDO',
                    'dsn' => 'mysql:host=localhost;dbname=pkinguin',
                    'user' => 'root',
                    'password' => '1769root',
                    'attributes' => array(),
                    'charset' => 'utf8'
                )
            )
        ),
        'runtime' => array(
            'defaultConnection' => 'mysource',
            'connections' => array('default'),
            'log' => array(
                'defaultLogger' => array(
                    'type' => 'file',
                    'path' => '/tmp/propel.log',
                    'level' => ''
                )
            ),
            'profiler' => array(
                'classname' => '\Propel\Runtime\Util\Profiler',
                'slowTreshold' => 0.1,
                'time' => array(
                    'precision' => 3,
                    'pad' => 8
                ),
                'memory' => array(
                    'precision' => 3,
                    'pad' => 8
                ),
                'innerGlue' => ":",
                'outerGlue' => "|"
            )
        ),
        'generator' => array(
            'defaultConnection' => 'default',
            'connections' => array('default'),
            'tablePrefix' => 'falco_'
        )
    )
);
