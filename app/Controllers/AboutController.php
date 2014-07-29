<?php

namespace App\Controllers;

/**
 * Display the "About" page.
 */
class AboutController extends ControllerBase
{

    protected $layout = 'main';
    
    protected $template = 'default';
    
    protected $vars = array(
        'title' => 'My default title',
        'breadcrumb' => array('About')
    );
        
    public function indexAction()
    {
        
    }

}
