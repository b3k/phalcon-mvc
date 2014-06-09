<?php

namespace App\Model;

use App\Model\Base\User as BaseUser;

class User
        extends BaseUser
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

    public function getExpired()
    {
        return ($this->getUserExpired() || $this->getUserExpireAt() <= (new \DateTime('now')));
    }
    
    public function createLog() {
        $UserLog =  new UserLog();
        $UserLog->setUserId($this->getId());
        return $UserLog;
    }

}
