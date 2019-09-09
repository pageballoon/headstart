<?php

use Headstart\Middleware\Authenticate;

$router = $this->app['router'];
$method = method_exists($router, 'aliasMiddleware') ? 'aliasMiddleware' : 'middleware';

$router->$method('auth', Authenticate::class);

