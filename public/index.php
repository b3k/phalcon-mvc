<?php

ini_set('display_errors', 1);
error_reporting(E_ALL | E_STRICT);

define('APP_ENV_PRODUCTION', 'production');
define('APP_ENV_STAGING', 'staging');
define('APP_ENV_TEST', 'test');
define('APP_ENV_DEVELOPMENT', 'development');
define('APP_ENV', getenv('APP_ENV') ? getenv('APP_ENV') : APP_ENV_PRODUCTION);

define('APP_VERSION', '0.1');
define('APP_PHALCON_REQUIRED_VERSION', '1.3.0');
define('APP_PHP_REQUIRED_VERSION', '5.4.0');

define('DS', DIRECTORY_SEPARATOR);

define('APP_ROOT_DIR', dirname(__DIR__));
define('APP_APPLICATION_DIR', APP_ROOT_DIR . DS . 'app');
define('APP_CONFIG_DIR', APP_ROOT_DIR . DS . 'config');
define('APP_VIEWS_DIR', APP_APPLICATION_DIR . DS . 'Views');
define('APP_TMP_DIR', APP_ROOT_DIR . DS . 'tmp');
define('APP_PUBLIC_DIR', APP_ROOT_DIR . DS . 'public');

require_once APP_ROOT_DIR . '/config/exceptions/exceptions.php';

require APP_ROOT_DIR . "/vendor/autoload.php";

try {
    /**
     * Handle the request
     */
    require_once APP_ROOT_DIR . '/config/Application.php';
    $Application = new Config\Application();

    /**
     * Run application
     */
    $Response = $Application->handle();


    /**
     * Put content
     */
    echo $Response->getContent();
    
    /**
     * End application
     */
    exit(0);
    
} catch (Exception $e) {
    echo $e->getMessage(), '<br />';
    echo nl2br(htmlentities($e->getTraceAsString()));
}
