<?php

namespace App\Controllers;

/**
 * Display the default index page.
 */
class ErrorController extends ControllerBase
{
    public function error404Action()
    {
        $this->view->setTemplateBefore('public');
    }

}
