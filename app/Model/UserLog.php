<?php

namespace App\Model;

use App\Model\Base\UserLog as BaseUserLog;

class UserLog
        extends BaseUserLog
{

    public function setAction($name)
    {
        return $this->setUserLogAction($name);
    }

    public function getAction()
    {
        return $this->getUserLogAction();
    }

    public function setParams($params)
    {
        return $this->setParams($params);
    }

    public function setIp($ip)
    {
        return $this->setUserLogIp($ip);
    }

    public function getIp()
    {
        return $this->getUserLogIp();
    }

    public function setUserAgent($ua)
    {
        return $this->setUserLogHttpUserAgent($ua);
    }

    public function getUserLogHttpUserAgent()
    {
        return $this->getUserLogHttpUserAgent();
    }

}
