<?php

namespace App\Library\Session\Adapter;

use Phalcon\Session\Adapter\Files as PhalconFiles;

class Files extends PhalconFiles
{
    use \App\Library\Session\ConfigurableSessionTrait;
}
