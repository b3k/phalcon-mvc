<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Config\Initializer\Base;

use \Phalcon\Config as PhalconConfig;

/**
 * Description of Config
 *
 * @author b3k
 */
class Config extends PhalconConfig {

    protected $env = null;
    protected $base_path = null;
    protected $loadable_config_groups = array(
        'database', 'application', 'models', 'common', 'mailer'
    );
    protected $config_cache_file = 'cache/config.php';

    public function __construct() {
        $this->env = APP_ENV;
        $this->base_path = APP_ROOT_DIR . DS . 'config' . DS . 'environment' . DS . strtolower($this->env) . DS;
        if (is_readable($this->config_cache_file)) {
            return parent::__construct(require(APP_TMP_DIR . DS . $this->config_cache_file));
        }
        $config = array();

        // make all values strtolower
        $this->loadable_config_groups = array_map(function($v) {
            return strtolower(trim($v));
        }, $this->loadable_config_groups);

        // get the config
        foreach ($this->loadable_config_groups as $group) {
            if (is_readable($this->base_path . $group . '.php')) {
                $config[$group] = array_merge($this->default_config_values[$group], require($this->base_path . strtolower($group) . '.php'), isset($this->force_config_values[$group]) ? $this->force_config_values[$group] : array());
            }
        }
        $this->warmupCache($config);
        return parent::__construct($config);
    }

    public function warmupCache($config) {
        file_put_contents(APP_TMP_DIR . DS . $this->config_cache_file, $this->dumpAsString($config));
    }

    protected function dumpAsString($array) {
        return '<?php return ' . var_export($array, true) . ';';
    }

}
