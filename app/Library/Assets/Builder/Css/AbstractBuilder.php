<?php

namespace App\Library\Assets\Builder\Css;

abstract class AbstractBuilder
{

    protected $_input;
    protected $_output;
    protected $_adapter = '\App\Library\Assets\Builder\Css\Adapater\AbstractAdapter';
    protected $_adapterInstance;

    public function getAdapter()
    {
        return $this->_adapter;
    }

    public function getAdapterInstance()
    {
        // if we already have instance, just give it
        if ($this->_adapterInstance instanceof AdapterAbstract) {
            return $this->_adapterInstance;
        } elseif (is_object($this->_adapterInstance) && !$this->_adapterInstance instanceof AdapterAbstract) {
            // if we have object but not AdapeterAbstract - put error
            throw new \RuntimeException(sprintf("Adapter class %s should be instance of %s.",
                $this->getAdapter(), 'AdapterAbstract'));
        }
        // if given adapeter class dosent exists
        if (!class_exists($this->getAdapter())) {
            throw new \RuntimeException(sprintf("Adapeter %s does not exists.",
                $this->getAdapter()));
        }

        $this->_adapterInstance = new $this->getAdapter();
        return $this->_adapterInstance;
    }

    public function setInputFile(\SplFileObject $input)
    {
        $this->_input = (string) $input->fread($input->getSize());
    }

    public function setInputString($input)
    {
        $this->_input = (string) $input;
    }

    public function getInput()
    {
        return $this->_input;
    }

    public function build()
    {
        if (empty($this->_input)) {
            throw new \RuntimeException(sprintf("Input is empty."));
        }
        
        $this->_output = (string) $this->getAdapterInstance()->build($this->getInput());
    }

    public function writeOutputToFile(\SplFileObject $output)
    {
        return $output->fwrite($this->_input) !== NULL;
    }

    public function getOutput()
    {
        return $this->_output;
    }

}
