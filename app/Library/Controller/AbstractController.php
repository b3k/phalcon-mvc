<?php

namespace App\Library\Controller;

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Dispatcher;
use App\Library\User\Auth\UserInterface;

abstract class AbstractController extends Controller
{

    /**
     * Use Traits to implement some alias\helpers methods
     * 
     * - ResponseTrait
     * - RequestTrait
     * - CookiesTrait
     * - FlashBehaviour
     */
    use \App\Library\Controller\Traits\Response,
        \App\Library\Controller\Traits\Request,
        \App\Library\Controller\Traits\Flash,
        \App\Library\Controller\Traits\Asset,
        \App\Library\Controller\Traits\Cookie;

    /**
     *
     * @var string
     */
    protected $main_view = 'layouts/base/html';
    
    /**
     *
     * @var string
     */
    protected $template = 'default';
    
    /**
     *
     * @var string
     */
    protected $layout = null;
    
    /**
     *
     * @var string
     */
    protected $base_uri = null;
    
    /**
     *
     * @var bool
     */
    protected $use_https = null;
    
    /**
     *
     * @var string
     */
    protected $static_base_uri = null;
    
    /**
     *
     * @var array 
     */
    protected $respond_to = array('html', 'xml', 'json');
    
    /**
     *
     * @var string
     */
    protected $response_with = 'html';
    
    /**
     *
     * @var array
     */
    protected $vars = array(
    );

    public function initialize()
    {

        // override base uri
        if ($this->base_uri !== null) {
            $this->getUrlObject()->setBaseUri($this->base_uri);
        }

        // override static base uri
        if ($this->static_base_uri !== null) {
            $this->getUrlObject()->setStaticBaseUri($this->static_base_uri);
        }

        // use http
        if ($this->use_https !== null) {
            $this->getUrlObject()->setBaseUri('https://' . $this->base_uri);
        }

        // Chek client HTTP_ACCPT header to negotiate respond_to
        $this->negotiateResponseType($this->getDispatcher()->getParam('format'));

        // Chek client HTTP_ACCPT_LANGUAGE header to negotiate I18n tranlsation
        $this->negotiateLanguage();
    }

    /**
     * Resturns user session
     * 
     * @return type
     */
    public function getUser()
    {
        return $this->getDi()->get('auth')->getIdentity();
    }

    /**
     * Get URL object
     * 
     * @return type
     */
    public function getUrlObject()
    {
        return $this->getDi()->getShared('url');
    }

    /**
     * Get URL object
     * 
     * @return type
     */
    public function getI18n()
    {
        return $this->getDi()->getShared('i18n');
    }

    /**
     * Get flash object
     * 
     * @return type
     */
    public function getSession()
    {
        return $this->getDi()->getShared('session');
    }

    /**
     * Get flash object
     * 
     * @return type
     */
    public function getSecurity()
    {
        return $this->getDi()->getShared('security');
    }


    /**
     * Returns ACL object
     * 
     * @return type
     */
    public function getAcl()
    {
        return $this->getDi()->getShared('acl');
    }

    /**
     * Get dispatcher from Di
     * 
     * @return type
     */
    public function getDispatcher()
    {
        return $this->getDi()->getShared('dispatcher');
    }

    /**
     * Returns view
     * 
     * @return type
     */
    public function getView()
    {
        return $this->getDi()->getShared('view');
    }

    /**
     * Sets layout
     * 
     * @param type $layout
     */
    public function setLayout($layout = 'default')
    {
        $this->getView()->setLayout($layout);
    }

    /**
     * Set template
     * 
     * @param type $template
     */
    public function setTemplate($template = 'default')
    {
        $this->getView()->setTemplateBefore($template);
    }

    /**
     * Set main view
     * 
     * @param string $template
     */
    public function setMainView($template = 'default')
    {
        $this->getView()->setMainView($template);
    }

    /**
     * Forward action to another controller/action
     * 
     * @param array $params
     */
    public function forward($params)
    {
        $this->getDispatcher()->forward($params);
    }


    /**
     * Check that given user has access to controller/action
     * 
     * @param \App\Library\User\Auth\UserInterface $User
     * @param type $controllerName
     * @param type $actionName
     * @return type
     */
    public function hasAccess($User, $controllerName = null, $actionName = null)
    {
        if (null === $controllerName) {
            $this->getDi()->get('dispatcher')->getControllerName();
        }
        if (null === $actionName) {
            $this->getDi()->get('dispatcher')->getActionName();
        }
        return $this->getAcl()->isAllowed($User instanceof UserInterface ? $User->getRoles() : FALSE, $controllerName, $actionName);
    }

    /**
     * Before execure route check ACL's
     * 
     * @param \Phalcon\Mvc\Dispatcher $dispatcher
     * @return boolean
     */
    public function beforeExecuteRoute(Dispatcher $dispatcher)
    {
        $controllerName = $dispatcher->getControllerName();
        $actionName = $dispatcher->getActionName();
        $User = $this->getUser();

        // Check if the user have permission to the current option
        if (!$this->hasAccess($User, $controllerName, $actionName)) {

            $this->flash->notice('You don\'t have access to this module: ' . $controllerName . ':' . $actionName);

            // Check access to [controller]:indexAction action
            if ($this->hasAccess($User, $controllerName, 'index')) {
                $dispatcher->forward(array(
                    'controller' => $controllerName,
                    'action' => 'index'
                ));
            } else {
                // no access
                $dispatcher->forward(array(
                    'controller' => 'error_controller',
                    'action' => 'error403'
                ));
            }

            return false;
        }
    }

}
