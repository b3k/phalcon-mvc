<?php

namespace App\Library\Assets\Builder\Css;

use App\Library\Assets\Builder\Css\AbstractBuilder;

class Less extends AbstractBuilder
{

    protected $general_cmd = 'lessc %s';
    protected $file2file_cmd = '%s > %s';

    public function build()
    {
        if ($this->getInput() instanceof \SplFileObject && $this->getOutput() instanceof \SplFileObject) {
            $result = shell_exec(
                sprintf($this->general_cmd, 
                    sprintf($this->file2file_cmd, $this->getInput()->getRealPath(), $this->getOutput()->getRealPath())));
        }
        
    }
    

}
