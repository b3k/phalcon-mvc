<?php
$this->add('/confirm/{code}/{email}', array(
    'controller' => 'user',
    'action' => 'confirmEmail'
));

$this->add('/reset-password/{code}/{email}', array(
    'controller' => 'user',
    'action' => 'resetPassword'
));

$this->add("/users/:action", array(
    'controller' => 'products',
    'action' => 1,
));