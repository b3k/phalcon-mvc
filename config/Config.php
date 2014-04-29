<?php

namespace Config;

require_once(APP_ROOT_DIR . '/config/initializer/base/Config.php');

use \Config\Initializer\Base\Config as BaseConfig;

class Config extends BaseConfig {

    protected $config_cache_file = 'cache/config.php';

    protected $default_config_values = array(
        'database' => array(
            'adapter' => 'Mysql',
            'host' => 'localhost',
            'dbname' => 'test_db',
            'username' => 'root',
            'password' => ''
        ),
        'application' => array(
            'controllersDir' => '/../app/controllers/',
            'modelsDir' => '/../app/models/',
            'viewsDir' => '/../app/views/',
            'pluginsDir' => '/../app/helpers/',
            'libraryDir' => '/../app/libs/',
            'baseUri' => '/'
        ),
        'mailer' => array(
            'username' => '',
            'password' => ''
        ),
        'common' => array(
        )
    );

    /**
     * Some options that will be forced
     *
     * @var array
     */
    protected $force_config_values = array(
        //'database' => array('adapter' => 'Mysql')
    );
    
}


return new Config();