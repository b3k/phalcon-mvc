<?php

namespace Config;

use \Phalcon\Config as PhalconConfig;

class Config extends PhalconConfig {

    const CONFIG_CACHE_FILE = '/../tmp/cache/config.php';

    /**
     * You can set some global default options here
     * 
     * @var array
     */
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
        'models' => array(
            'metadata.adapter' => 'Memmory'
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
        'database' => array('adapter' => 'Mysql')
    );
    protected $env = null;
    protected $base_path = null;

    public function __construct($env) {
        $this->env = $env;
        $this->base_path = APP_ROOT_DIR . DS . 'config' . DS . 'environment' . DS . strtolower($env) . DS;
        if (is_readable(self::CONFIG_CACHE_FILE)) {
            return parent::__construct(require(self::CONFIG_CACHE_FILE));
        }
        $config = array();
        if (is_readable($this->base_path . 'database.php')) {
            $config['database'] = array_merge($this->default_config_values['database'], require($this->base_path . 'database.php'), isset($this->force_config_values['database']) ? $this->force_config_values['database'] : array());
        }
        if (is_readable($this->base_path . 'application.php')) {
            $config['application'] = array_merge($this->default_config_values['application'], require($this->base_path . 'application.php'), isset($this->force_config_values['application']) ? $this->force_config_values['application'] : array());
        }
        if (is_readable($this->base_path . 'models.php')) {
            $config['models'] = array_merge($this->default_config_values['models'], require($this->base_path . 'models.php'), isset($this->force_config_values['models']) ? $this->force_config_values['models'] : array());
        }
        if (is_readable($this->base_path . 'mailer.php')) {
            $config['mailer'] = array_merge($this->default_config_values['mailer'], require($this->base_path . 'mailer.php'), isset($this->force_config_values['mailer']) ? $this->force_config_values['mailer'] : array());
        }
        if (is_readable($this->base_path . 'common.php')) {
            $config['common'] = array_merge($this->default_config_values['common'], require($this->base_path . 'common.php'), isset($this->force_config_values['common']) ? $this->force_config_values['common'] : array());
        }
        return parent::__construct($config);
    }

    public function warmupCache() {
        file_put_contents(APP_ROOT_DIR . self::CONFIG_CACHE_FILE, $this->dumpAsString());
    }

    protected function dumpAsString($array = null) {
        if (!$array) {
            $array = $this->toArray();
        }
        return '<?php return ' . var_export($array, true) . ';';
    }

}
