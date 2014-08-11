<?php

namespace App\Controllers;

/**
 * Error controller
 */
class ErrorController extends ControllerBase
{

    protected $use_https = true;
    protected $vars = array(
        'title' => 'My default title',
        'breadcrumb' => array('About')
    );
    protected $respond_to = array(
        'html', 'xml'
    );

    public function error403Action()
    {
        
    }

    public function error404Action()
    {
        
    }

    public function error500Action()
    {
        
    }

}
