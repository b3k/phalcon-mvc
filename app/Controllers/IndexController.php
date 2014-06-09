<?php

namespace App\Controllers;

/**
 * Display the default index page.
 */
class IndexController extends ControllerBase
{

    public function indexAction()
    {
        die('sdsd');
        $this->view->setTemplateBefore('public');
    }

}
