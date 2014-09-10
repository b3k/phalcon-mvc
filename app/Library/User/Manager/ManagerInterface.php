<?php

namespace App\Library\User\Manager;

interface ManagerInterface {
    
    public function findBy($field, $value);
    
    public function findOneBy($field, $value);
    
    public function find($id);
    
    public function create($data = null);
    
}