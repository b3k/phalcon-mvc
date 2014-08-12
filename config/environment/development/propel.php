<?php

return array(
    'propel' => array(
        'database' => array(
            'connections' => array(
                'default' => array(
                    'adapter' => 'mysql',
                    'classname' => 'Propel\Runtime\Connection\DebugPDO',
                    'dsn' => 'mysql:host=localhost;dbname=upcheck',
                    'user' => 'root',
                    'password' => '1769root',
                    'attributes' => array(),
                    'settings' => array(
                        'charset' => 'utf8',
                        'queries' => array(
                            'set names utf8;'
                        )
                    ),
                )
            )
        ),
        'runtime' => array(
            'defaultConnection' => 'mysource',
            'connections' => array('default'),
            'log' => array(
                'defaultLogger' => array(
                    'type' => 'stream',
                    'path' => '/tmp/propel.log',
                    'level' => 100
                )
            ),
            'profiler' => array(
                'classname' => '\Propel\Runtime\Util\Profiler',
                'slowTreshold' => 0.1,
                'details' => array(
                    'time' => array(
                        'precision' => 3,
                        'pad' => 8
                    ),
                    'memory' => array(
                        'precision' => 3,
                        'pad' => 8
                    ),
                ),
                'innerGlue' => ":",
                'outerGlue' => "|"
            )
        ),
        'generator' => array(
            'defaultConnection' => 'default',
            'connections' => array('default'),
            'tablePrefix' => ''
        )
    )
);
