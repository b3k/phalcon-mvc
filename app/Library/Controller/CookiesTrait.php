<?php

namespace App\Library\Controller;

trait CookiesTrait
{

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

}
