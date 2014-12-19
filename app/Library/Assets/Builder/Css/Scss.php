<?php

namespace App\Library\Assets\Builder\Css;

use App\Library\Assets\Builder\Css\AbstractBuilder;

class Scss extends AbstractBuilder
{

    protected $general_cmd = 'node-scss %s %s';

    public function build()
    {
        
        if ($this->getInput() instanceof \SplFileObject && $this->getOutput() instanceof \SplFileObject) {
            shell_exec(
                sprintf($this->general_cmd, $this->getInput()->getRealPath(),
                    $this->getOutput()->getRealPath()));

            return $this;
        }
    }

}
