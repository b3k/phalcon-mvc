<?php

// define Controller -> Action -> Allowed roles
return array(
    'default' => \Phalcon\Acl::DENY,
    'roles' => array('guest', 'user', 'moderator', 'admin'),
    'list' => array(
        'index' => array(
            'index' => '*',
        ),
        'user' => array(
            'logout' => array('user', 'admin')
        ),
        'error' => array(
            'error404' => '*',
            'error500' => '*'
        )
    )
);
