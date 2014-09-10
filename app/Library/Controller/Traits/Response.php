<?php

namespace App\Library\Controller\Traits;

trait Response
{

    /**
     * Get response object
     * 
     * @return Response
     */
    public function getResponse()
    {
        return $this->getDi()->getShared('response');
    }

    public function isResponseSent()
    {
        return $this->getResponse()->isSent();
    }

    public function setResponseContent($content)
    {
        return $this->getResponse()->setContent($content);
    }

    public function sendResponse()
    {
        return $this->getResponse()->send();
    }

    public function setStatusCode($code, $msg = null)
    {
        return $this->getResponse()->setStatusCode($code, $msg);
    }

    public function setHeader($name, $value = '')
    {
        return $this->getResponse()->setHeader($name, $value);
    }

    public function getHeaders()
    {
        return $this->getResponse()->getHeaders();
    }

    public function setHeaders($headers)
    {
        return $this->getResponse()->setHeaders($headers);
    }

    public function setExpires($Datetime)
    {
        return $this->getResponse()->setExpires($Datetime);
    }

    public function setEtag($tag)
    {
        return $this->getResponse()->setEtag($tag);
    }

    public function redirect($param)
    {
        return $this->getResponse()->redirect($param);
    }

}
