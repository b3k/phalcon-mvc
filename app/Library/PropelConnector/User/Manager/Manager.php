<?php

namespace App\Library\PropelConnector\User\Manager;

use App\Library\User\Manager\ManagerInterface as UserManagerInterface;
use App\Model\UserQuery;
use App\Model\User;

class Manager implements UserManagerInterface
{

    private $_UserQuery;

    protected function _getUserQuery()
    {
        if (!($this->_UserQuery instanceof UserQuery)) {
            $this->_UserQuery = new UserQuery();
        }
        return $this->_UserQuery;
    }

    public function create($data = null)
    {
        return (new App\Model\User($data));
    }

    public function findOneBy($value, $key = 'id')
    {
        return $this->_getUserQuery()->findOneBy($key, $value);
    }

    public function findBy($value, $key = 'id')
    {
        return $this->_getUserQuery()->findBy($key, $value);
    }

    public function find($id)
    {
        return $this->_getUserQuery()->findPK($id);
    }

}
