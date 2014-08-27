<?php

namespace App\Library\Controller\Behaviour;

trait RequestBehaviour
{

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

    public function getPost($name = null, $default = null, $filter = null)
    {
        return $this->getRequest()->getPost($name, $filter, $default);
    }

    public function getPut($name = null, $default = null, $filter = null)
    {
        return $this->getRequest()->getPut($name, $filter, $default);
    }

    public function getQuery($name = null, $default = null, $filter = null)
    {
        return $this->getRequest()->getQuery($name, $filter, $default);
    }

    public function getRequestHeaders()
    {
        return $this->getRequest()->getHeaders();
    }

    public function getBestAccept()
    {
        return $this->getRequest()->getBestAccept();
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

    public function negotiateResponseType($format_param = null)
    {
        if (null !== $format_param && in_array($format_param, $this->respond_to)) {
            $this->setActiveRespondWith($format_param);
            return $format_param;
        }
        foreach ($this->getRequest()->getAcceptableContent() as $Accept) {
            if (strpos($Accept['accept'], '/') !== FALSE) {
                $userBestAccept = substr($Accept['accept'], strpos($Accept['accept'], '/') + 1);
                if (in_array($userBestAccept, $this->respond_to)) {
                    $this->setActiveRespondWith($userBestAccept);
                    return $this->getActiveRespondWith();
                }
            }
        }
    }

    public function negotiateLanguage()
    {
        foreach ($this->getRequest()->getLanguages() as $lang) {
            if ($this->getI18n()->hasSupport($lang['language'])) {
                $this->getI18n()->setLanguage($lang['language']);
                break;
            }
        }
        return $this->getI18n()->getLanguage();
    }

    public function setActiveRespondWith($type)
    {
        $this->response_with = $type;
    }

    public function getActiveRespondWith()
    {
        return $this->response_with;
    }

}
