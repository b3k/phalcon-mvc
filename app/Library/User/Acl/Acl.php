<?php

namespace App\Library\User\Acl;

use Phalcon\Mvc\User\Component;

class Acl extends Component
{

    const CACHE_KEY = 'application_acl_data';
    const CACHE_TTL = 29600;

    /**
     * ACL Object
     *
     * @var \Phalcon\Acl\Adapter\Memory
     */
    private $acl;

    public function getCacheKey()
    {
        return APP_ENV . '_' . self::CACHE_KEY;
    }

    /**
     * Get cache service
     * 
     * @return \Phalcon\Cache\Backend
     */
    public function getCache()
    {
        return $this->getDI()->getShared('cache');
    }

    /**
     * @TODO Refactor code - stylistical etc
     * @param  array $list
     * @return \Phalcon\Acl\Adapter\Memory
     */
    public function buildFromArray($list)
    {
        $this->acl = new \Phalcon\Acl\Adapter\Memory();
        $this->acl->setDefaultAction(isset($list['default_action']) ? $list['default_action'] : \Phalcon\Acl::DENY);

        if (isset($list['roles'])) {
            foreach ($list['roles'] as $role) {
                $this->acl->addRole(new \Phalcon\Acl\Role($role));
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
            $this->acl->addResource(new \Phalcon\Acl\Resource(strtolower($controller)), $actions);
        }

        foreach ($list['list'] as $controller => $actions) {
            $controller = strtolower($controller);
            if (is_array($actions)) {
                foreach ($actions as $action => $roles) {
                    $action = strtolower($action);
                    // If we got wildmask '*' then allow all defined roles
                    if (!is_array($roles) && trim($roles) === '*') {
                        $roles = $list['roles'];
                    }
                    if (is_array($roles)) {
                        foreach ($roles as $role) {
                            $this->acl->allow(strtolower(trim($role)), $controller, $action);
                        }
                    } else {
                        $this->acl->allow(strtolower(trim($role)), $controller, $action);
                    }
                }
            }
        }

        $this->getCache()->save($this->getCacheKey(), $this->acl, self::CACHE_TTL);

        return $this->acl;
    }

    /**
     * Checks if the current profile is allowed to access a resource
     *
     * @param  array  $roles
     * @param  string  $controller
     * @param  string  $action
     * @return boolean
     */
    public function isAllowed($roles, $controller, $action)
    {
        if (!$roles || empty($roles)) {
            $roles = array($this->config->acl->default_role);
        }

        $access = $this->getAcl()->getDefaultAction();
        foreach ($roles as $role) {
            $access = $this->getAcl()->isAllowed($role, $controller, $action);
            if ($access) {
                break;
            }
        }
        return $access;
    }

    /**
     * Returns the ACL list
     *
     * @TODO Refactor this to use backend cache from config
     * @return Phalcon\Acl\Adapter\Memory
     */
    public function getAcl()
    {
        // Check current instance for existing ACL object
        if (is_object($this->acl)) {
            return $this->acl;
        }

        // try to get from Cache
        if ($cached_acl = $this->getCache()->get($this->getCacheKey())) {
            if (is_object($cached_acl)) {
                $this->acl = $cached_acl;
                return $this->acl;
            }
        }

        // Generate ACL list
        $AclList = \App\Library\Utilities\ArrayUtils::array_merge_recursive_distinct(
                        $this->app->getBaseAclList(), $this->config->acl->toArray()
        );
        $this->buildFromArray($AclList);

        return $this->acl;
    }

}
