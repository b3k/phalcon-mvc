<?php

namespace App\Library\Controller;

trait FlashTrait
{

    public function addFlash($message, $type = 'notice')
    {
        switch ($type) {
            case 'success': $this->getFlash()->success($message);
                break;
            case 'warning': $this->getFlash()->warning($message);
                break;
            case 'error': $this->getFlash()->error($message);
                break;
            case 'notice':
            default:
                $this->getFlash()->notice($message);
                break;
        }
    }

    public function addSuccess($message)
    {
        return $this->addFlash($message, 'success');
    }

    public function addWarning($message)
    {
        return $this->addFlash($message, 'warning');
    }

    public function addNotice($message)
    {
        return $this->addFlash($message, 'notice');
    }

    public function addError($message)
    {
        return $this->addFlash($message, 'error');
    }

}
