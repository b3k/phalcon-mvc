<?php

namespace App\Controllers;

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Dispatcher;
use App\Library\User\Auth\UserInterface;

class ControllerBase extends Controller
{

    protected $layout = 'default';
    protected $template = 'default';
    protected $base_uri = null;
    protected $use_https = null;
    protected $static_base_uri = null;
    protected $vars = array(
    );

    public function initialize()
    {
        $this->setLayout($this->layout);
        $this->setTemplate($this->template);
        // override base uri
        if ($this->base_uri !== null) {
            $this->getUrlObject()->setBaseUri($this->base_uri);
        }
        // override static base uri
        if ($this->static_base_uri !== null) {
            $this->getUrlObject()->setStaticBaseUri($this->static_base_uri);
        }
        
        if ($this->use_https !== null) {
            $this->getUrlObject()->setBaseUri('https://'.$this->static_base_uri);
        }
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

    public function getUrlObject()
    {
        return $this->getDi()->get('url');
    }

    /**
     * Returns ACL object
     * 
     * @return type
     */
    public function getAcl()
    {
        return $this->getDi()->get('acl');
    }

    /**
     * Returns view
     * 
     * @return type
     */
    public function getView()
    {
        return $this->getDi()->get('view');
    }

    public function setLayout($layout = 'default')
    {
        $this->getView()->setLayout($layout);
    }

    public function setTemplate($template = 'default')
    {
        $this->getView()->setTemplateAfter($template);
    }

    public function forward($params)
    {
        $this->getDispatcher()->forward($params);
    }

    public function redirect($param)
    {
        return $this->getResponse()->redirect($param);
    }

    public function isPost()
    {
        return $this->getRequest()->isPost();
    }

    public function isGet()
    {
        return $this->getRequest()->isGet();
    }

    public function isPut()
    {
        return $this->getRequest()->isPut();
    }

    public function isPatch()
    {
        return $this->getRequest()->isPatch();
    }

    public function isHead()
    {
        return $this->getRequest()->isHead();
    }

    public function isDelete()
    {
        return $this->getRequest()->isDelete();
    }

    public function isOptions()
    {
        return $this->getRequest()->isOptions();
    }

    public function isAjax()
    {
        return $this->getRequest()->isAjax();
    }

    public function isSoap()
    {
        return $this->getRequest()->isSoapRequested();
    }

    public function isSecure()
    {
        return $this->getRequest()->isSecureRequest();
    }

    public function getUri()
    {
        return $this->getRequest()->getURI();
    }

    public function getMethod()
    {
        return $this->getRequest()->getMethod();
    }

    public function getScheme()
    {
        return $this->getRequest()->getScheme();
    }

    public function getReferer()
    {
        return $this->getRequest()->getHTTPReferer();
    }

    public function getRequestIp($trustForwarded = FALSE)
    {
        return $this->getRequest()->getClientAddress($trustForwarded);
    }

    public function getRequestFingerprint($only_client = TRUE)
    {
        return sha1($this->getRequestIp() . $this->getMethod() . $this->getRequest()->getUserAgent() . ($only_client ? '' : $this->getURI()));
    }

    public function getPost($name, $default = null, $filter = null)
    {
        return $this->getRequest()->getPost($name, $filter, $default);
    }

    public function getPut($name, $default = null, $filter = null)
    {
        return $this->getRequest()->getPut($name, $filter, $default);
    }

    public function getQuery($name, $default = null, $filter = null)
    {
        return $this->getRequest()->getQuery($name, $filter, $default);
    }

    public function getHeaders()
    {
        return $this->getRequest()->getHeaders();
    }

    public function getUploadedFiles()
    {
        return $this->getRequest()->getUploadedFiles();
    }

    public function hasFiles()
    {
        return $this->getRequest()->hasFiles();
    }

    public function hasPost($name)
    {
        return $this->getRequest()->hasPost($name);
    }

    public function hasPut($name)
    {
        return $this->getRequest()->hasPut($name);
    }

    public function hasQuery($name)
    {
        return $this->getRequest()->hasQuery($name);
    }

    public function getRequest()
    {
        return $this->getDi()->get('request');
    }

    /**
     * Get response object
     * 
     * @return Response
     */
    public function getResponse()
    {
        return $this->getDi()->get('response');
    }

    public function isResponseSent()
    {
        return $this->getResponse()->isSent();
    }

    public function sendResponse()
    {
        return $this->getResponse()->send();
    }

    public function getCookiesBag()
    {
        return $this->getRequest()->getCookies();
    }

    public function setCookie($name, $value, $expire = null, $path = '/', $secure = null, $domain = null, $httpOnly = false)
    {
        return $this->getCookiesBag()->set($name, $value, $expire, $path, $secure, $domain, $httpOnly);
    }

    public function getCookie($name)
    {
        return $this->getCookiesBag()->get($name);
    }

    public function hasCookie($name)
    {
        return $this->getCookiesBag()->has($name);
    }

    public function setStatusCode($code, $msg = null)
    {
        return $this->getResponse()->setStatusCode($code, $msg);
    }

    public function setHeader($name, $value = '')
    {
        return $this->getResponse()->setHeader($name, $value);
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
