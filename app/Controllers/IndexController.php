<?php

namespace App\Controllers;

/**
 * Display the default index page.
 */
class IndexController extends ControllerBase
{

    public function indexAction()
    {
        $this->getAssetsManager()->addCss('test1.css');
        $this->getAssetsManager()->addCss('test2.css');
        //$this->getAssetsManager()->addCss('asset/file2');
        //$this->getAssetsManager()->addCss('asset/file2.scss');
    }

}
