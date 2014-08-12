<?php

/**
 * This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license MIT License
 */

namespace App\Library\PropelConnector\Propel\Common\Config;

use Propel\Common\Config\ConfigurationManager as PropelConfigurationManager;
use Propel\Common\Config\Exception\InvalidArgumentException;
use Propel\Common\Config\Loader\DelegatingLoader;
use Symfony\Component\Finder\Finder;
use Propel\Common\Config\PropelConfiguration;
use Symfony\Component\Config\Definition\Processor;

/**
 * Class ConfigurationManager
 *
 * Class to load and process configuration files. Supported formats are: php, ini (or .properties), yaml, xml, json.
 *
 * @author Cristiano Cinotti
 */
class ConfigurationManager extends PropelConfigurationManager
{

    const CONFIG_FILE_NAME = 'propel';

    /**
     * Array of configuration values
     *
     * @var array
     */
    protected $config = array();

    public function __construct($configPath = null, $extraConf = array())
    {
        $this->load($configPath, $extraConf);
        $this->process();
    }

    protected function load($configPath, $extraConf = array())
    {
        if (null === $extraConf) {
            $extraConf = array();
        }
        $finder = new Finder();
        $finder->in($configPath)->depth(0)->files()->name(self::CONFIG_FILE_NAME . '.*')->notName('*.dist');
        $files = iterator_to_array($finder);
        //print_r($files);
        $numFiles = count($files);

        if ($numFiles !== 1) {
            if ($numFiles <= 0) {
                throw new InvalidArgumentException('Propel configuration file not found');
            }
            throw new InvalidArgumentException('Propel expects only one configuration file');
        }
        $file = current($files);
        $fileName = $file->getPathName();
        $delegatingLoader = new DelegatingLoader();
        $conf = $delegatingLoader->load($fileName);
        $distConf = array();
        $this->config = array_replace_recursive($distConf, $conf, $extraConf);
    }

    /**
     * Validate the configuration array via Propel\Common\Config\PropelConfiguration class
     * and add default values.
     *
     * @param array $extraConf Extra configuration to merge before processing. It's useful when a child class overwrite
     *                         the constructor to pass a built-in array of configuration, without load it from file. I.e.
     *                         Propel\Generator\Config\QuickGeneratorConfig class.
     */
    protected function process($extraConf = null)
    {
        if (null === $extraConf && count($this->config) <= 0) {
            return null;
        }
        $processor = new Processor();
        $configuration = new PropelConfiguration();

        if (is_array($extraConf)) {
            $this->config = array_replace_recursive($this->config, $extraConf);
        }
        $this->config = $processor->processConfiguration($configuration, $this->config);
        //Workaround to remove empty `slaves` array from database.connections
        foreach ($this->config['database']['connections'] as $name => $connection) {
            if (count($connection['slaves'] <= 0)) {
                unset($this->config['database']['connections'][$name]['slaves']);
            }
        }
    }

    /**
     * Return the whole configuration array
     *
     * @return array
     */
    public function get()
    {
        return $this->config;
    }

    /**
     * Return a specific section of the configuration array.
     * It ca be useful to get, in example, only 'buildtime' values.
     *
     * @param  string $section the section to be returned
     * @return array
     */
    public function getSection($section)
    {
        if (!array_key_exists($section, $this->config)) {
            return null;
        }

        return $this->config[$section];
    }

    /**
     * Return a specific configuration property.
     * The name of the requested property must be given as a string, representing its hierarchy in the configuration
     * array, with each level separated by a dot. I.e.:
     * <code> $config['database']['adapter']['mysql']['tableType']</code>
     * is expressed by:
     * <code>'database.adapter.mysql.tableType</code>
     *
     * @param $name The name of property, expressed as a dot separated level hierarchy
     * @throws Propel\Common\Config\Exception\InvalidArgumentException
     * @return mixed The configuration property
     */
    public function getConfigProperty($name)
    {
        if (!is_string($name)) {
            throw new InvalidArgumentException("Invalid configuration property name '$name'.");
        }

        $keys = explode('.', $name);
        $output = $this->get();
        foreach ($keys as $key) {
            if (!array_key_exists($key, $output)) {
                return null;
            }
            $output = $output[$key];
        }

        return $output;
    }

    /**
     * Return an array of parameters relative to configured connections, for `runtime` or `generator` section.
     * It's useful for \Propel\Generator\Command\ConfigConvertCommand class
     *
     * @param  string     $section `runtime` or `generator` section
     * @return array|null
     */
    public function getConnectionParametersArray($section = 'runtime')
    {
        if (!in_array($section, array('runtime', 'generator'))) {
            return null;
        }

        $output = array();
        foreach ($this->config[$section]['connections'] as $connection) {
            $output[$connection] = $this->config['database']['connections'][$connection];
        }

        return $output;
    }

}
