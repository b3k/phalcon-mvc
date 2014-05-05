<?php

namespace App\Library\PropelConnector\Propel\Generator\Builder;

class ConfigBuilder
{

    private $input_config;
    private $output;
    private $default_datasource;
    private $adapters = array('sqlite', 'pgsql', 'mysql', 'oracle', 'mssql');

    const CONF_DEFAULT_DATASOURCE = 'default_datasource';
    const CONF_DEFAULT_CHARSET = 'utf-8';
    const CONF_DEFAULT_CACHE_QUERY = TRUE;
    const CONF_KEY_DEFAULT_DATASOURCE = 'default';
    const CONF_KEY_DATASOURCES = 'datasources';
    const CONF_KEY_DATASOURCES_ADAPTER = 'adapter';
    const CONF_KEY_DATASOURCES_HOST = 'host';
    const CONF_KEY_DATASOURCES_USERNAME = 'username';
    const CONF_KEY_DATASOURCES_PASSWORD = 'password';
    const CONF_KEY_DATASOURCES_DBNAME = 'dbname';
    const CONF_KEY_DATASOURCES_CHARSET = 'charset';
    const CONF_KEY_DATASOURCES_INIT_QUERY = 'init_query';
    const CONF_KEY_DATASOURCES_SLAVES = 'slaves';
    const CONF_KEY_PROFILER = 'profiler';
    const CONF_KEY_PROFILER_CLASS = 'type';
    const CONF_KEY_PROFILER_SLOW_TRESHOLD = 'slow_treshold';
    const CONF_KEY_PROFILER_DETAILS = 'details';
    const CONF_KEY_PROFILER_INNER_GLUE = 'inner_glue';
    const CONF_KEY_PROFILER_OUTER_GLUE = 'outer_glue';
    const CONF_KEY_LOG = 'log';
    const CONF_KEY_LOG_TYPE = 'type';
    const CONF_KEY_LOG_IDENT = 'ident';
    const CONF_KEY_LOG_LEVEL = 'level';

    public function __construct(Array $database_config)
    {
        if (empty($database_config)) {
            throw new \RuntimeException("Database config array is empty.");
        }

        $this->input_config = $database_config;

        try {
            $this->validate();
            $this->buildXml();
        } catch (\Exception $ex) {
            throw new \RuntimeException("Database config is not valid: " . $ex->getMessage());
        }
    }

    public function buildXml()
    {
        $this->output = '<?xml version="1.0"?>';
        foreach (array('datasources', 'log', 'profiler') as $part) {
            $method = 'buildXml' . ucfirst(strtolower($part));
            if (method_exists($this, $method)) {
                $this->$method();
            }
        }
    }

    public function buildXmlDatasources()
    {
        $Xml = \SimpleXMLElement('<propel></propel>');
        $XmlDatasources = $Xml->addChild('datasources');
        $XmlDatasources->addAttribute('default', $this->default_datasource);

        foreach ($this->input_config[self::CONF_KEY_DATASOURCES] as $datasource_key => $datasource_arr) {
            $XmlDatasource = $XmlDatasources->addChild('datasource');
            $XmlDatasource->addAttribute('id', $datasource_key);
            $XmlDatasource->addChild('adapter', $datasource_arr[self::CONF_KEY_DATASOURCES_ADAPTER]);
            $XmlDatasourceConnection = $XmlDatasource->addChild('connection');
            $XmlDatasourceConnection->addChild('classname', 'DebugPDO');
            $XmlDatasourceConnection->addChild('dsn', 'mysql:host=localhost;dbname=bookstore');
            $XmlDatasourceConnection->addChild('user', 'mysql:host=localhost;dbname=bookstore');
            $XmlDatasourceConnection->addChild('password', 'mysql:host=localhost;dbname=bookstore');
            $XmlDatasourceConnection->addChild('options');
            $XmlDatasourceConnection->addChild('settings');
            $XmlDatasource->addChild('slaves');
        }

        return $Xml;
    }

    public function buildXmlLog()
    {
        $Xml = \SimpleXMLElement('<log></log>');
        return $Xml;
    }

    public function buildXmlProfiler()
    {
        $Xml = \SimpleXMLElement('<profiler></profiler>');
        return $Xml;
    }

    public function validate()
    {
        foreach (array('datasources', 'log', 'profiler') as $part) {
            $method = 'validate' . ucfirst(strtolower($part));
            if (method_exists($this, $method)) {
                $this->$method();
            }
        }
    }

    public function validateLog()
    {
        if (isset($this->database_config[self::CONF_KEY_LOG]) && is_array($this->database_config[self::CONF_KEY_LOG])) {
            if (!isset($this->database_config[self::CONF_KEY_LOG][self::CONF_KEY_CONF_TYPE])) {
                throw new \Exception("Log should have set type.");
            }
            if (!isset($this->database_config[self::CONF_KEY_LOG][self::CONF_KEY_CONF_IDENT])) {
                throw new \Exception("Log should have set ident.");
            }
            if (!isset($this->database_config[self::CONF_KEY_LOG][self::CONF_KEY_CONF_LEVEL])) {
                throw new \Exception("Log should have set level.");
            }
        }
    }

    public function validateProfiler()
    {
        if (isset($this->database_config[self::CONF_KEY_PROFILER]) && is_array($this->database_config[self::CONF_KEY_PROFILER])) {
            if (!isset($this->database_config[self::CONF_KEY_PROFILER][self::CONF_KEY_PROFILER_CLASS])) {
                throw new \Exception("Profiler should have set class.");
            }
        }
    }

    public function validateDatasources()
    {

        if (!isset($this->database_config[self::CONF_KEY_DATASOURCES]) || count($this->database_config[self::CONF_KEY_DATASOURCES]) == 0) {
            throw new \Exception("Database should have at least one datasource.");
        }

        $this->default_datasource = isset($this->database_config[self::CONF_DEFAULT_DATASOURCE]) ? $this->database_config[self::CONF_KEY_DEFAULT_DATASOURCE] : self::CONF_DEFAULT_DATASOURCE;

        if (!isset($this->database_config[$this->default_datasource]) || !isset($this->database_config[self::CONF_KEY_DATASOURCES][$this->default_datasource])) {
            throw new \Exception("Not defined or unknown key in default_datasource.");
        }

        foreach ($this->database_config[self::CONF_KEY_DATASOURCES] as $datasource_key => $datasource) {
            if (!isset($datasource[self::CONF_KEY_DATASOURCES_ADAPTER])) {
                throw new \Exception('No adapter defined');
            }
            if (!isset($datasource[self::CONF_KEY_DATASOURCES_HOST])) {
                throw new \Exception('No host defined');
            }
            if (!isset($datasource[self::CONF_KEY_DATASOURCES_USERNAME])) {
                throw new \Exception('No username defined');
            }
            if (!isset($datasource[self::CONF_KEY_DATASOURCES_PASSWORD])) {
                throw new \Exception('No password defined');
            }
            if (!isset($datasource[self::CONF_KEY_DATASOURCES_DBNAME])) {
                throw new \Exception('No database defined');
            }

            if (isset($datasource[self::CONF_KEY_DATASOURCES_INIT_QUERY]) && !is_array($datasource[self::CONF_KEY_DATASOURCES_INIT_QUERY])) {
                throw new \Exception('init_query should be array');
            }

            if (isset($datasource[self::CONF_KEY_DATASOURCES_SLAVES])) {
                if (!is_array($datasource[self::CONF_KEY_DATASOURCES_SLAVES])) {
                    throw new \Exception('slaves should be array');
                }
                if (count($datasource[self::CONF_KEY_DATASOURCES_SLAVES]) > 0) {
                    foreach ($datasource[self::CONF_KEY_DATASOURCES_SLAVES] as $slave) {
                        if (!isset($slave[self::CONF_KEY_DATASOURCES_ADAPTER])) {
                            throw new \Exception('No adapter defined');
                        }
                        if (!isset($slave[self::CONF_KEY_DATASOURCES_HOST])) {
                            throw new \Exception('No host defined');
                        }
                        if (!isset($slave[self::CONF_KEY_DATASOURCES_USERNAME])) {
                            throw new \Exception('No username defined');
                        }
                        if (!isset($slave[self::CONF_KEY_DATASOURCES_PASSWORD])) {
                            throw new \Exception('No password defined');
                        }
                        if (!isset($slave[self::CONF_KEY_DATASOURCES_DBNAME])) {
                            throw new \Exception('No database defined');
                        }
                    }
                }
            }
        }
    }

}
