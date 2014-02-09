<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

try {
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
    define('APP_APPLICATION_DIR', APP_ROOT_DIR . '/app');
    define('APP_TMP_DIR', APP_ROOT_DIR . '/tmp');
    define('APP_PUBLIC_DIR', BASE_DIR . '/public');

    /**
     * Read the configuration
     */
    $config = require_once APP_ROOT_DIR . '/config/config.php';

    /**
     * Exception and error handler
     */
    require_once APP_ROOT_DIR . '/config/exception.php';

    /**
     * Read auto-loader
     */
    require_once APP_ROOT_DIR . '/config/loader.php';

    /**
     * Read services
     */
    require_once APP_ROOT_DIR . '/config/services.php';

    /**
     * Handle the request
     */
    if (php_sapi_name() !== 'cli') {
        $application = new \ExtPhal\Config\Initializers\Application($di);
    } else {
        $application = new \ExtPhal\Config\Initializers\ApplicationCli($di);
    }
    //echo $application->handle()->getContent();
    $application->run();
    echo $application->getOutput();
} catch (Exception $e) {
    echo $e->getMessage(), '<br>';
    echo nl2br(htmlentities($e->getTraceAsString()));
}
