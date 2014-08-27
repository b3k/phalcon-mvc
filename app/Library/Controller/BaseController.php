<?php

namespace App\Library\Controller;

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Dispatcher;
use App\Library\User\Auth\UserInterface;

class BaseController extends Controller
{

    /**
     * Use Traits to implement some alias\helpers methods
     * 
     * - ResponseTrait
     * - RequestTrait
     * - CookiesTrait
     * - FlashBehaviour
     */
    use \App\Library\Controller\Behaviour\ResponseBehaviour,
        \App\Library\Controller\Behaviour\RequestBehaviour,
        \App\Library\Controller\Behaviour\FlashBehaviour,
        \App\Library\Controller\Behaviour\CookiesBehaviour;

    protected $main_view = 'layouts/base/html';
    protected $template = 'default';
    protected $layout = null;
    protected $base_uri = null;
    protected $use_https = null;
    protected $static_base_uri = null;
    protected $respond_to = array('html', 'xml', 'json');
    protected $response_with = 'html';
    protected $vars = array(
    );

    public function initialize()
    {
        //$this->getView()->setMainView($this->main_view);

        if ($this->layout) {
            //$this->getView()->setLayout($this->layout);
        }

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
     * Get flash object
     * 
     * @return type
     */
    public function getFlash()
    {
        return $this->getDi()->getShared('flash');
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
     * Get request
     * 
     * @return Request
     */
    public function getRequest()
    {
        return $this->getDi()->getShared('request');
    }

    /**
     * 
     * @return CookiesBag
     */
    public function getCookiesBag()
    {
        return $this->getRequest()->getCookies();
    }

    /**
     * Get response object
     * 
     * @return Response
     */
    public function getResponse()
    {
        return $this->getDi()->getShared('response');
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
