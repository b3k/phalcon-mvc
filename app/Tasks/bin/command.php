<?php

umask(0);

// just for getting env before initializing application
if (isset($argv)) {
    foreach ($argv as $arg) {
        if (substr(trim($arg), 0, 6) == '--env=') {
            $argv_env = substr($arg, 6);
            break;
        }
    }
}

define('APP_ENV_PRODUCTION', 'production');
define('APP_ENV_STAGING', 'staging');
define('APP_ENV_TEST', 'test');
define('APP_ENV_DEVELOPMENT', 'development');
define('APP_ENV', isset($argv_env) ? $argv_env : APP_ENV_DEVELOPMENT);

define('APP_VERSION', '0.1');
define('APP_PHALCON_REQUIRED_VERSION', '1.3.0');
define('APP_PHP_REQUIRED_VERSION', '5.4.0');

define('DS', DIRECTORY_SEPARATOR);

define('APP_ROOT_DIR', dirname(dirname(dirname(__DIR__))));
define('APP_APPLICATION_DIR', APP_ROOT_DIR . DS . 'app');
define('APP_CONFIG_DIR', APP_ROOT_DIR . DS . 'config');
define('APP_VIEWS_DIR', APP_APPLICATION_DIR . DS . 'Views');
define('APP_TMP_DIR', APP_ROOT_DIR . DS . 'tmp' . DS . APP_ENV);
define('APP_LOG_DIR', APP_ROOT_DIR . DS . 'log');
define('APP_PUBLIC_DIR', APP_ROOT_DIR . DS . 'public');

require_once APP_ROOT_DIR . '/config/exceptions/exceptions.php';

require_once APP_CONFIG_DIR . '/ApplicationCli.php';

if (!class_exists('\Symfony\Component\Console\Application')) {
    if (file_exists($file = __DIR__ . '/../../../vendor/autoload.php') || file_exists($file = __DIR__ . '/../autoload.php')) {
        require_once $file;
    } elseif (file_exists($file = __DIR__ . '/../autoload.php.dist')) {
        require_once $file;
    }
}

$ApplicationCli = new \Config\ApplicationCli();

$ApplicationCli->handle();
