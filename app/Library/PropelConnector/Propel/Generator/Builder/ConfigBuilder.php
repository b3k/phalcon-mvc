<?php

namespace App\Library\PropelConnector\Propel\Generator\Builder;

class ConfigBuilder
{

    private $input_config;
    private $output_xml;
    private $default_datasource;
    private $adapters = array('sqlite', 'pgsql', 'mysql', 'oracle', 'mssql');

    const CONF_DEFAULT_DATASOURCE = 'default';
    const CONF_DEFAULT_CHARSET = 'utf-8';
    const CONF_KEY_DEFAULT_DATASOURCE = 'default_datasource';
    const CONF_KEY_DATASOURCES = 'datasources';
    const CONF_KEY_DATASOURCES_ADAPTER = 'adapter';
    const CONF_KEY_DATASOURCES_HOST = 'host';
    const CONF_KEY_DATASOURCES_PORT = 'port';
    const CONF_KEY_DATASOURCES_USERNAME = 'username';
    const CONF_KEY_DATASOURCES_PASSWORD = 'password';
    const CONF_KEY_DATASOURCES_DBNAME = 'dbname';
    const CONF_KEY_DATASOURCES_CHARSET = 'charset';
    const CONF_KEY_DATASOURCES_INIT_QUERY = 'init_query';
    const CONF_KEY_DATASOURCES_CACHE_QUERY = 'cache_query';
    const CONF_KEY_DATASOURCES_OPTIONS = 'options';
    const CONF_KEY_DATASOURCES_OPTIONS_PDO = 'pdo';
    const CONF_KEY_DATASOURCES_OPTIONS_ATTRIBUTES = 'attributes';
    const CONF_KEY_DATASOURCES_PERSISTENT = 'persistent';
    const CONF_KEY_DATASOURCES_SLAVES = 'slaves';
    const CONF_KEY_PROFILER = 'profiler';
    const CONF_KEY_PROFILER_CLASS = 'class';
    const CONF_KEY_PROFILER_SLOW_TRESHOLD = 'slow_treshold';
    const CONF_KEY_PROFILER_DETAILS = 'details';
    const CONF_KEY_PROFILER_DETAILS_NAME = 'name';
    const CONF_KEY_PROFILER_DETAILS_PRECISION = 'precision';
    const CONF_KEY_PROFILER_DETAILS_PAD = 'pad';
    const CONF_KEY_PROFILER_INNER_GLUE = 'inner_glue';
    const CONF_KEY_PROFILER_OUTER_GLUE = 'outer_glue';
    const CONF_KEY_LOG = 'log';
    const CONF_KEY_LOG_ENABLED = 'enabled';
    const CONF_KEY_LOG_TYPE = 'type';
    const CONF_KEY_LOG_IDENT = 'ident';
    const CONF_KEY_LOG_NAME = 'name';
    const CONF_KEY_LOG_LEVEL = 'level';

    public function __construct(Array $database_config)
    {
        if (empty($database_config)) {
            throw new \RuntimeException("Database config array is empty.");
        }

        $this->input_config = $database_config;

        try {
            $this->validate();
        } catch (\Exception $ex) {
            throw new \RuntimeException("Database config is not valid: " . $ex->getMessage());
        }
        
        try {
            $this->buildXml();
        } catch (Exception $ex) {
            throw new \RuntimeException("Bild exception: " . $ex->getMessage());
        }
    }

    public function buildXml()
    {
        $this->output_xml = '';
        try {
            $Xml = new \SimpleXMLElement('<config></config>');
            foreach (array('datasources', 'log', 'profiler') as $part) {
                $method = 'buildXml' . ucfirst(strtolower($part));
                if (method_exists($this, $method)) {
                    $this->$method($Xml);
                }
            }
            $this->output_xml = $Xml->asXML();
        } catch (\Exception $e) {
            throw new \RuntimeException('Can not build XML config: ' . $e->getMessage());
        }
        return $this;
    }

    public function saveXml($filepath)
    {
        return file_put_contents($filepath, $this->output_xml);
    }
    
    public function getXml() {
        return $this->output_xml;
    }

    public function buildXmlDatasources(\SimpleXMLElement $BaseXml)
    {
        $Xml = $BaseXml->addChild('propel');
        $XmlDatasources = $Xml->addChild('datasources');
        $XmlDatasources->addAttribute('default', $this->default_datasource);

        foreach ($this->input_config[self::CONF_KEY_DATASOURCES] as $datasource_key => $datasource_arr) {

            $XmlDatasource = $XmlDatasources->addChild('datasource');
            $XmlDatasource->addAttribute('id', $datasource_key);
            $XmlDatasource->addChild('adapter', $datasource_arr[self::CONF_KEY_DATASOURCES_ADAPTER]);
            $XmlDatasourceConnection = $XmlDatasource->addChild('connection');
            $XmlDatasourceConnection->addChild('classname', 'DebugPDO');

            $DsnString = $this->getDsnStringFromDatasource($datasource_arr);

            $XmlDatasourceConnection->addChild('dsn', $DsnString);
            $XmlDatasourceConnection->addChild('user', $datasource_arr[self::CONF_KEY_DATASOURCES_USERNAME]);
            $XmlDatasourceConnection->addChild('password', $datasource_arr[self::CONF_KEY_DATASOURCES_PASSWORD]);

            // set persistent
            if (isset($datasource_arr[self::CONF_KEY_DATASOURCES_PERSISTENT])) {
                $XmlOptions = $XmlDatasourceConnection->addChild('options');
                $XmlOption = $XmlOptions->addChild('option', ($datasource_arr[self::CONF_KEY_DATASOURCES_PERSISTENT] == true ? 'true' : 'false'));
                $XmlOption->addAttribute('id', 'ATTR_PERSISTENT');
            }

            // set cache
            if (isset($datasource_arr[self::CONF_KEY_DATASOURCES_CACHE_QUERY])) {
                $XmlAttributes = $XmlDatasourceConnection->addChild('attributes');
                $XmlAttribute = $XmlAttributes->addChild('option', ($datasource_arr[self::CONF_KEY_DATASOURCES_CACHE_QUERY] == true ? 'true' : 'false'));
                $XmlAttribute->addAttribute('id', 'PROPEL_ATTR_CACHE_PREPARES');
            }

            // set charset
            if (isset($datasource_arr[self::CONF_KEY_DATASOURCES_CHARSET])) {
                $XmlSettings = $XmlDatasourceConnection->addChild('settings');
                $XmlAttribute = $XmlSettings->addChild('setting', ($datasource_arr[self::CONF_KEY_DATASOURCES_CHARSET]));
                $XmlAttribute->addAttribute('id', 'charset');
            }

            // set other pdo connection options
            if (isset($datasource_arr[self::CONF_KEY_DATASOURCES_OPTIONS]) && isset($datasource_arr[self::CONF_KEY_DATASOURCES_OPTIONS][self::CONF_KEY_DATASOURCES_OPTIONS_PDO]) && is_array($datasource_arr[self::CONF_KEY_DATASOURCES_OPTIONS][self::CONF_KEY_DATASOURCES_OPTIONS_PDO]) && count($datasource_arr[self::CONF_KEY_DATASOURCES_OPTIONS][self::CONF_KEY_DATASOURCES_OPTIONS_PDO]) > 0) {
                $XmlOptions = isset($XmlOptions) && is_object($XmlOptions) ? $XmlOptions : $XmlDatasourceConnection->addChild('options');
                foreach ($datasource_arr[self::CONF_KEY_DATASOURCES_OPTIONS][self::CONF_KEY_DATASOURCES_OPTIONS_PDO] as $option_key => $option_val) {
                    $XmlOption = $XmlOptions->addChild('option', ($option_val === true ? 'true' : ($option_val === false ? 'false' : (string) $option_val)));
                    $XmlOption->addAttribute('id', strtoupper($option_key));
                }
            }

            // set pdo attributes
            if (isset($datasource_arr[self::CONF_KEY_DATASOURCES_OPTIONS]) && isset($datasource_arr[self::CONF_KEY_DATASOURCES_OPTIONS][self::CONF_KEY_DATASOURCES_OPTIONS_ATTRIBUTES]) && count($datasource_arr[self::CONF_KEY_DATASOURCES_OPTIONS][self::CONF_KEY_DATASOURCES_OPTIONS_ATTRIBUTES]) > 0) {
                $XmlAttributes = isset($XmlAttributes) && is_object($XmlAttributes) ? $XmlAttributes : $XmlDatasourceConnection->addChild('attributes');
                foreach ($datasource_arr[self::CONF_KEY_DATASOURCES_OPTIONS][self::CONF_KEY_DATASOURCES_OPTIONS_ATTRIBUTES] as $option_key => $option_val) {
                    $XmlAttribute = $XmlAttributes->addChild('option', ($option_val === true ? 'true' : ($option_val === false ? 'false' : (string) $option_val)));
                    $XmlAttribute->addAttribute('id', strtoupper($option_key));
                }
            }

            // init queries
            if (isset($datasource_arr[self::CONF_KEY_DATASOURCES_INIT_QUERY]) && count($datasource_arr[self::CONF_KEY_DATASOURCES_INIT_QUERY]) > 0) {
                $XmlSettings = isset($XmlSettings) && is_object($XmlSettings) ? $XmlSettings : $XmlDatasourceConnection->addChild('settings');
                $XmlQueries = $XmlSettings->addChild('setting');
                $XmlQueries->addAttribute('id', 'queries');
                foreach ($datasource_arr[self::CONF_KEY_DATASOURCES_INIT_QUERY] as $query_val) {
                    $XmlQuery = $XmlQueries->addChild('query', $query_val);
                }
            }
            
            if (isset($datasource_arr[self::CONF_KEY_DATASOURCES_SLAVES]) && count($datasource_arr[self::CONF_KEY_DATASOURCES_SLAVES]) > 0) {
                $XmlSlaves = $XmlDatasource->addChild('slaves');
                foreach ($datasource_arr[self::CONF_KEY_DATASOURCES_SLAVES] as $slave) {
                    $DsnString = $this->getDsnStringFromDatasource($slave);
                    $XmlSlaveConnection = $XmlSlaves->addChild('connection');
                    $XmlSlaveConnection->addChild('dsn', $DsnString);
                }
            }
        }
        return $BaseXml;
    }

    public function getDsnStringFromDatasource(Array $datasource_arr)
    {
        switch ($datasource_arr[self::CONF_KEY_DATASOURCES_ADAPTER]) {
            case 'sqlite':
            case 'sqlite2':
                $DsnString = $datasource_arr[self::CONF_KEY_DATASOURCES_ADAPTER] . ':';
                if (strtolower($datasource_arr[self::CONF_KEY_DATASOURCES_DBNAME]) === 'memory') {
                    $DsnString .= ':memory:';
                    break;
                } else {
                    $DsnString .= $datasource_arr[self::CONF_KEY_DATASOURCES_DBNAME];
                }
                break;
            case 'mysql':
                $DsnString = $datasource_arr[self::CONF_KEY_DATASOURCES_ADAPTER] . ':';
                if (substr(strtolower($datasource_arr[self::CONF_KEY_DATASOURCES_HOST]), 0, 11) === 'unix_socket') {
                    $DsnString .= $datasource_arr[self::CONF_KEY_DATASOURCES_HOST] . ';';
                } else {
                    $DsnString .= 'host=' . $datasource_arr[self::CONF_KEY_DATASOURCES_HOST] . ';';
                }
                if (isset($datasource_arr[self::CONF_KEY_DATASOURCES_PORT])) {
                    $DsnString .= 'port=' . $datasource_arr[self::CONF_KEY_DATASOURCES_PORT] . ';';
                }
                $DsnString .= 'dbname=' . $datasource_arr[self::CONF_KEY_DATASOURCES_DBNAME];
                break;
            case 'pgsql':
                $DsnString = $datasource_arr[self::CONF_KEY_DATASOURCES_ADAPTER] . ':';
                $DsnString .= 'host=' . $datasource_arr[self::CONF_KEY_DATASOURCES_HOST] . ';';
                if (isset($datasource_arr[self::CONF_KEY_DATASOURCES_PORT])) {
                    $DsnString .= 'port=' . $datasource_arr[self::CONF_KEY_DATASOURCES_PORT] . ';';
                }
                $DsnString .= 'dbname=' . $datasource_arr[self::CONF_KEY_DATASOURCES_DBNAME] . ';';
                if (isset($datasource_arr[self::CONF_KEY_DATASOURCES_USERNAME])) {
                    $DsnString .= 'user=' . $datasource_arr[self::CONF_KEY_DATASOURCES_USERNAME] . ';';
                }
                if (isset($datasource_arr[self::CONF_KEY_DATASOURCES_PASSWORD])) {
                    $DsnString .= 'password=' . $datasource_arr[self::CONF_KEY_DATASOURCES_PASSWORD];
                }
                break;
            default:

                break;
        }

        return rtrim($DsnString, ';');
    }

    public function buildXmlLog(\SimpleXMLElement $BaseXml)
    {
        $Xml = $BaseXml->addChild('log');
        if (isset($this->input_config[self::CONF_KEY_LOG]) && is_array($this->input_config[self::CONF_KEY_LOG])) {
            $log_input = $this->input_config[self::CONF_KEY_LOG];
            if (isset($log_input[self::CONF_KEY_LOG_ENABLED]) && $log_input[self::CONF_KEY_LOG_ENABLED] == true) {
                $Xml->addChild('ident', !isset($log_input[self::CONF_KEY_LOG_IDENT]) ? 'default' : $log_input[self::CONF_KEY_LOG_IDENT]);
                $Xml->addChild('name', !isset($log_input[self::CONF_KEY_LOG_NAME]) ? 'default' : $log_input[self::CONF_KEY_LOG_NAME]);
                $Xml->addChild('type', !isset($log_input[self::CONF_KEY_LOG_TYPE]) ? 'console' : $log_input[self::CONF_KEY_LOG_TYPE]);
                $Xml->addChild('level', !isset($log_input[self::CONF_KEY_LOG_LEVEL]) ? 7 : $log_input[self::CONF_KEY_LOG_LEVEL]);
            }
        }
        return $BaseXml;
    }

    public function buildXmlProfiler(\SimpleXMLElement $BaseXml)
    {
        $Xml = $BaseXml->addChild('profiler');
        if (isset($this->input_config[self::CONF_KEY_PROFILER]) && is_array($this->input_config[self::CONF_KEY_PROFILER])) {
            $profiler_config = $this->input_config[self::CONF_KEY_PROFILER];

            if (isset($profiler_config[self::CONF_KEY_PROFILER_CLASS])) {
                $Xml->addAttribute('class', $profiler_config[self::CONF_KEY_PROFILER_CLASS]);
            }
            if (isset($profiler_config[self::CONF_KEY_PROFILER_SLOW_TRESHOLD])) {
                $Xml->addChild('slowTreshold', $profiler_config[self::CONF_KEY_PROFILER_SLOW_TRESHOLD]);
            }
            if (isset($profiler_config[self::CONF_KEY_PROFILER_DETAILS]) && count($profiler_config[self::CONF_KEY_PROFILER_DETAILS]) > 0) {
                $XmlDetails = $Xml->addChild('detalis');
                foreach ($profiler_config[self::CONF_KEY_PROFILER_DETAILS] as $detail_key => $detail_val) {
                    $XmlDetail = $XmlDetails->addChild($detail_key);
                    $XmlDetail->addAttribute('name', $detail_val[self::CONF_KEY_PROFILER_DETAILS_NAME]);
                    $XmlDetail->addAttribute('precision', $detail_val[self::CONF_KEY_PROFILER_DETAILS_PRECISION]);
                    $XmlDetail->addAttribute('pad', $detail_val[self::CONF_KEY_PROFILER_DETAILS_PAD]);
                }
                $Xml->addChild('innerGlue', $profiler_config[self::CONF_KEY_PROFILER_INNER_GLUE]);
                $Xml->addChild('outerGlue', $profiler_config[self::CONF_KEY_PROFILER_OUTER_GLUE]);
            }
        }
        return $BaseXml;
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
        if (isset($this->input_config[self::CONF_KEY_LOG]) && is_array($this->input_config[self::CONF_KEY_LOG])) {
            if (!isset($this->input_config[self::CONF_KEY_LOG][self::CONF_KEY_LOG_TYPE])) {
                throw new \Exception("Log should have set type.");
            }
            if (!isset($this->input_config[self::CONF_KEY_LOG][self::CONF_KEY_LOG_IDENT])) {
                throw new \Exception("Log should have set ident.");
            }
            if (!isset($this->input_config[self::CONF_KEY_LOG][self::CONF_KEY_LOG_LEVEL])) {
                throw new \Exception("Log should have set level.");
            }
        }
        
    }

    public function validateProfiler()
    {
        if (isset($this->input_config[self::CONF_KEY_PROFILER]) && is_array($this->input_config[self::CONF_KEY_PROFILER])) {
            if (!isset($this->input_config[self::CONF_KEY_PROFILER][self::CONF_KEY_PROFILER_CLASS])) {
                throw new \Exception("Profiler should have set class.");
            }
        }
    }

    public function validateDatasources()
    {

        
        
        if (!isset($this->input_config[self::CONF_KEY_DATASOURCES]) || count($this->input_config[self::CONF_KEY_DATASOURCES]) == 0) {
            throw new \Exception("Database should have at least one datasource.");
        }

        $this->default_datasource = isset($this->input_config[self::CONF_KEY_DEFAULT_DATASOURCE]) ? $this->input_config[self::CONF_KEY_DEFAULT_DATASOURCE] : self::CONF_DEFAULT_DATASOURCE;

        print_r($this->default_datasource);
        
        if (!isset($this->input_config[self::CONF_KEY_DATASOURCES]) || !isset($this->input_config[self::CONF_KEY_DATASOURCES][$this->default_datasource])) {
            throw new \Exception("Not defined or unknown key in default_datasource.");
        }

        foreach ($this->input_config[self::CONF_KEY_DATASOURCES] as $datasource_key => $datasource) {
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
