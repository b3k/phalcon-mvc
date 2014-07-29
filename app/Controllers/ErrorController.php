<?php

namespace App\Controllers;

/**
 * Error controller
 */
class ErrorController extends ControllerBase
{

    protected $layout = 'main2';
    
    protected $template = 'default';
    
    protected $use_https = true;
    
    protected $vars = array(
        'title' => 'My default title',
        'breadcrumb' => array('About')
    );

    public function error403Action()
    {
        die('403');
    }

    public function error404Action()
    {
        die('404');
    }

    public function error500Action()
    {
        die('500');
    }

}
