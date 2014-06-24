<?php

// define Controller -> Action -> Allowed roles
return array(
    'default' => \Phalcon\Acl::DENY,
    'default_role' => 'guest',
    'roles' => array('guest', 'user', 'moderator', 'admin'),
    'list' => array(
        'index' => array(
            'index' => '*',
        ),
        'user' => array(
            'logout' => array('user', 'admin')
        ),
        'error' => array(
            'error403' => '*',
            'error404' => '*',
            'error500' => '*'
        )
    )
);
