<?php

namespace App\Model;

use App\Model\Base\User as BaseUser;
use Propel\Runtime\Map\TableMap;
use App\Library\User\Auth\UserInterface;

class User extends BaseUser implements UserInterface
{

    public function getPassword()
    {
        return $this->getUserPassword();
    }

    public function getId()
    {
        return $this->getIdUser();
    }

    public function getActive()
    {
        return $this->getUserActive();
    }

    public function getRememberToken()
    {
        return $this->getUserRememberToken();
    }

    public function setRememberToken($v)
    {
        return $this->getUserRememberToken($v);
    }

    public function getRememberTokenValidity()
    {
        return $this->getUserRememberTokenValidity();
    }

    public function setRememberTokenValidity($v)
    {
        return $this->getUserRememberTokenValidity($v);
    }

    public function getExpired()
    {
        return ($this->getUserExpired() || $this->getUserExpireAt() <= (new \DateTime('now')));
    }

    public function getValue($column)
    {
        return $this->getByName($column, TableMap::TYPE_RAW_COLNAME);
    }

    public function createLog()
    {
        $UserLog = new UserLog();
        $UserLog->setUserId($this->getId());
        return $UserLog;
    }

}
