<?php

namespace App\Library\Assets\Builder\Css;

/**
 * Abstract builder
 * 
 */
abstract class AbstractBuilder
{

    protected $_input;
    protected $_output;
    protected $_config;

    public function getConfig()
    {
        return $this->_config;
    }

    public function setConfig($config)
    {
        $this->_config = $config;
        return $this;
    }

    /**
     * Set input
     * 
     * @param string|\SplFileObject $input
     * @throws \Exception
     */
    public function setInput($input)
    {
        if ($input instanceof \SplFileObject) {
            $this->setInputFile($input);
        } elseif (is_string($input)) {
            $this->setInputString($input);
        } else {
            throw new \Exception('Not supported input.');
        }
        return $this;
    }

    /**
     * Set the output file
     * 
     * @param string|\SplFileObject $output
     * @return \App\Library\Assets\Builder\Css\AbstractBuilder
     * @throws \Exception
     */
    public function setOutput($output)
    {
        if ($output instanceof \SplFileObject) {
            $this->_output = $output;
        } elseif (is_string($output)) {
            $this->_output = new \SplFileObject((string) $output, 'w+');
        } else {
            throw new \Exception('Not supported output.');
        }
        return $this;
    }

    public function setInputFile(\SplFileObject $input)
    {
        $this->_input = $input;
        return $this;
    }

    public function setInputString($input)
    {
        $filepath = tempnam(APP_TMP_DIR);
        file_put_contents($filepath, (string) $input);
        $this->setInputFile(new \SplFileObject($filepath, 'r'));
        return $this;
    }

    public function getInput()
    {
        return $this->_input;
    }

    public function writeOutputToFile(\SplFileObject $output)
    {
        return $output->fwrite($this->_input) !== NULL;
    }

    public function getOutput()
    {
        return $this->_output;
    }

    abstract public function build();
}
