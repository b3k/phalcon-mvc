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

    abstract public function build();

    public function writeOutputToFile(\SplFileObject $output)
    {
        return $output->fwrite($this->_input) !== NULL;
    }

    public function getOutput()
    {
        return $this->_output;
    }

}
