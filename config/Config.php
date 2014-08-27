<?php

namespace Config;

require_once(APP_ROOT_DIR . '/config/initializer/base/Config.php');

use \Config\Initializer\Base\Config as BaseConfig;

class Config extends BaseConfig
{

    /**
     * Name of file which stores compiled configuration in APP_TMP dir.
     *
     * @return string
     */
    public function getConfigCacheFilename()
    {
        return 'compiled_config.php';
    }

    /**
     * Array with default values, which can be overriden by enviroment config
     *
     * @return array
     */
    public function getDefaultConfigValues()
    {
        return array(
            'application' => array(
                'controllersDir' => '/../app/controllers/',
                'modelsDir' => '/../app/models/',
                'viewsDir' => '/../app/views/',
                'pluginsDir' => '/../app/helpers/',
                'libraryDir' => '/../app/libs/',
                'baseUri' => '/',
                'i18n' => array(
                    'default' => 'en_GB'
                )
            ),
            'mailer' => array(
                'username' => '',
                'password' => ''
            ),
            'common' => array(
            )
        );
    }

    public function getForceConfigValues()
    {
        return array();
    }
}

// Initialize Config
return new Config();
