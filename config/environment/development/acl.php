<?php
// define Controller -> Action -> Allowed roles
return array(
    'index' => array(
        'index' => '*',
        'logout' => array('user', 'moderator', 'admin')
    ),
    'error' => array(
        'error404' => '*',
        'error500' => '*'
    )
);
