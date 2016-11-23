<?php

use \Symfony\Component\Routing as Routing;

$routes = new Routing\RouteCollection();

// sign up
$routes->add(
    'sign_up',
    new Routing\Route(
        '/user/registry/',
        [
            '_controller' => 'Application\Controllers\User\Registry',
            '_action' => 'index',
        ]
    )
);

// sign up
$routes->add(
    'sign_up_confirm',
    new Routing\Route(
        '/user/registry/confirm/',
        [
            '_controller' => 'Application\Controllers\User\Registry',
            '_action' => 'confirm',
        ]
    )
);

// login
$routes->add(
    'login',
    new Routing\Route(
        '/login/',
        [
            '_controller' => 'Application\Controllers\Auth\Login',
            '_action' => 'index',
        ]
    )
);

return $routes;