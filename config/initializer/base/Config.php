<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Config\Initializer\Base;

use \Phalcon\Config as PhalconConfig;
use Symfony\Component\Filesystem\Filesystem;
use \App\Library\Utilities\Utilities;

/**
 * Description of Config
 *
 * @author b3k
 */
class Config extends PhalconConfig
{

    private $env = null;
    private $base_path = null;
    private $loadable_config_groups = array(
        'propel', 'application', 'models',
        'common', 'mailer', 'acl', 'cache'
    );
    private $filesystem;

    public function getDefaultConfigValues()
    {
        return array();
    }

    public function getLoadableConfigGroups()
    {
        return $this->loadable_config_groups;
    }

    public function getConfigCacheFilename()
    {
        return 'compiled_config.php';
    }

    public function getBasePath()
    {
        return $this->base_path;
    }

    public function setBasePath($base_path)
    {
        $this->base_path = $base_path;
    }

    public function getEnv()
    {
        return !$this->env ? APP_ENV : $this->env;
    }

    public function setEnv($env)
    {
        $this->env = $env;
    }

    public function getForceConfigValues()
    {
        return array();
    }

    public function getFilesystem()
    {
        if (!$this->filesystem) {
            $this->filesystem = new Filesystem();
        }
        return $this->filesystem;
    }

    public function __construct()
    {
        if (is_readable(APP_TMP_DIR . DS . $this->getConfigCacheFilename())) {
            return parent::__construct(require(APP_TMP_DIR . DS . $this->getConfigCacheFilename()));
        }
        $this->setEnv(APP_ENV);
        $this->setBasePath(APP_CONFIG_DIR . DS . 'environment' . DS . strtolower($this->getEnv()) . DS);

        // Create folders if cache folder dosen't exists
        if (!file_exists($this->getBasePath())) {
            $this->getFilesystem()->mkdir($this->getBasePath(), 0777);
        }

        $config = $this->getDefaultConfigValues();

        // get the config
        foreach ($this->getLoadableConfigGroups() as $group) {
            if (is_readable($this->getBasePath() . $group . '.php')) {
                $config = Utilities::array_merge_recursive_distinct(
                                // default values
                                $config,
                                // set values
                                array($group => require($this->getBasePath() . strtolower($group) . '.php'))
                );
            }
        }
        $forced_values = $this->getForceConfigValues();
        if ($forced_values && count($forced_values) > 0) {
            $config = Utilities::array_merge_recursive_distinct(
                            $config,
                            // force config values
                            $forced_values
            );
        }

        // warmup cache
        $this->warmupCache($config);

        return parent::__construct($config);
    }

    public function warmupCache($config)
    {
        $this->getFilesystem()->mkdir(dirname(APP_TMP_DIR . DS . $this->getConfigCacheFilename()));
        $this->getFilesystem()->dumpFile(APP_TMP_DIR . DS . $this->getConfigCacheFilename(), $this->dumpAsString($config));
    }

    protected function dumpAsString($array)
    {
        return '<?php return ' . var_export($array, true) . ';';
    }

}
