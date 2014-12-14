<?php

namespace App\Library\PropelConnector\User;

use App\Library\User\Manager\ManagerInterface as UserManagerInterface;
use App\Model\UserQuery;
use App\Model\User;
use Propel\Runtime\Map\TableMap;

class Manager implements UserManagerInterface
{

    private $QueryObject;

    public function getQuery($clear = true)
    {
        if (!$this->QueryObject instanceof UserQuery) {
            $this->QueryObject = new UserQuery();
        }
        if ($clear) {
            $this->QueryObject->clear();
        }
        return $this->QueryObject;
    }

    public function findBy($field, $value)
    {
        $this->getQuery()->findBy($field, $value);
    }

    public function findOneBy($field, $value)
    {
        $this->getQuery->findBy($field, $value);
    }

    public function find($id)
    {
        $this->getQuery()->find($id);
    }

    public function create($data = null)
    {
        return (new User())->fromArray($data, TableMap::TYPE_PHPNAME);
    }

}
