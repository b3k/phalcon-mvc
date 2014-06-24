<?php

namespace App\Controllers;

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Dispatcher;
use App\Library\User\Auth\UserInterface;

class ControllerBase extends Controller
{

    public function getUser()
    {
        return $this->auth->getIdentity();
    }

    public function getAcl()
    {
        return $this->acl;
    }

    public function hasAccess($User, $controllerName, $actionName)
    {
        return $this->getAcl()->isAllowed($User instanceof UserInterface ? $User->getRoles() : FALSE, $controllerName, $actionName);
    }

    public function beforeExecuteRoute(Dispatcher $dispatcher)
    {
        $controllerName = $dispatcher->getControllerName();
        $actionName = $dispatcher->getActionName();
        $User = $this->getUser();

        // Check if the user have permission to the current option
        if (!$this->hasAccess($User, $controllerName, $actionName)) {

            $this->flash->notice('You don\'t have access to this module: ' . $controllerName . ':' . $actionName);

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
