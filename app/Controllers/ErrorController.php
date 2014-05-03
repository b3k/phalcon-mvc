<?php

namespace App\Controllers;

/**
 * Display the default index page.
 */
class ErrorController extends ControllerBase
{
    public function error404Action()
    {
        die('404');
    }

    public function error500Action()
    {
        die('404');
    }

}
