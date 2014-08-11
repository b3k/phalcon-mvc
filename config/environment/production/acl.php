<?php

return array(
    'default_action' => \Phalcon\Acl::DENY,
    'roles' => array('guest', 'user', 'moderator', 'admin'),
    'default_role' => 'guest',
    'list' => array(
        'index' => array(
            'index' => '*',
        ),
        'user' => array(
            'logout' => array('user', 'admin'),
        ),
        'session' => array(
            'signup' => array('guest')
        ),
        'error' => array(
            'error403' => '*',
            'error404' => '*',
            'error500' => '*'
        )
    )
);
