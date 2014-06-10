<?php

namespace App\Library\User\Auth;

/**
 * Description of UserInterface
 *
 * @author b3k
 */
interface UserInterface
{
    public function getId();
    public function getValue($column);
}
