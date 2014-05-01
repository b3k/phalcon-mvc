<?php

namespace App\Library\User\Acl;

use Phalcon\Mvc\User\Component;
use Phalcon\Acl\Adapter\Memory as AclMemory;
use Phalcon\Acl\Role as AclRole;
use Phalcon\Acl\Resource as AclResource;

class Acl extends Component {

    const CACHE_KEY = 'application_acl_data';

    private $acl;

    public function buildFromArray($list) {
        $acl = new AclMemory();

        $acl->setDefaultAction(isset($list['default']) ? $list['default'] : Phalcon\Acl::DENY);

        if (isset($list['roles'])) {
            foreach ($list['roles'] as $role) {
                $acl->addRole(new AclRole($role));
            }
        }

        foreach ($list['list'] as $controller => $action) {
            $Ref = new \ReflectionClass('\App\Controllers\\' . ucfirst(strtolower($controller)) . 'Controller');
            $methods = $Ref->getMethods(\ReflectionMethod::IS_PUBLIC);
            $actions = array();
            foreach ($methods as $method) {
                if (substr(strtolower($method->getName()), -6, 6) == 'action') {
                    $actions[] = substr(strtolower($method->getName()), 0, -6);
                }
            }
            $acl->addResource(new AclResource(strtolower($controller)), $actions);
        }

        foreach ($list['list'] as $controller => $actions) {
            $controller = strtolower($controller);
            if (is_array($actions)) {
                foreach ($actions as $action => $roles) {
                    $action = strtolower($action);
                    if (is_array($roles)) {
                        foreach ($roles as $role) {
                            $acl->allow(strtolower($role), $controller, $action);
                        }
                    } else {
                        $acl->allow(strtolower($roles), $controller, $action);
                    }
                }
            }
        }

        file_put_contents(APP_TMP_DIR . DS . self::CACHE_KEY, serialize($acl));

        if (function_exists('apc_store')) {
            apc_store(APP_ENV . '_' . self::CACHE_KEY, $acl);
        }

        $this->acl = $acl;

        return $this->acl;
    }

    /**
     * Checks if the current profile is allowed to access a resource
     *
     * @param string $profile
     * @param string $controller
     * @param string $action
     * @return boolean
     */
    public function isAllowed($profile, $controller, $action) {
        return $this->getAcl()->isAllowed($profile, $controller, $action);
    }
    
    public function isPrivate() {
        return TRUE;
    }

    /**
     * Returns the ACL list
     *
     * @return Phalcon\Acl\Adapter\Memory
     */
    public function getAcl() {
        if (is_object($this->acl)) {
            return $this->acl;
        }

        if (function_exists('apc_fetch')) {
            $acl = apc_fetch(APP_ENV . '_' . self::CACHE_KEY);
            if (is_object($acl)) {
                $this->acl = $acl;
                return $acl;
            }
        }

        if (file_exists(APP_TMP_DIR . DS . self::CACHE_KEY)) {
            $data = file_get_contents(APP_TMP_DIR . DS . self::CACHE_KEY);
            $this->acl = unserialize($data);
            if (function_exists('apc_store')) {
                apc_store(APP_ENV . '_' . self::CACHE_KEY, $this->acl);
            }
        } else {
            $AclList = \App\Library\Utilities\Utilities::array_merge_recursive_distinct(
                            $this->app->getBaseAclList(), (file_exists(APP_CONFIG_DIR . '/environment/' . APP_ENV . '/acl.php') ? require_once(APP_CONFIG_DIR . '/environment/' . APP_ENV . '/acl.php') : array())
            );
            $this->buildFromArray($AclList);
        }

        return $this->acl;
    }

}
