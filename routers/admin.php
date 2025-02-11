<?php

use App\Controllers\Admin\DashboardController;
use App\Controllers\Admin\UserController;

$router->mount('/admin', function() use ($router) {

    $router->get('/' , DashboardController::class . '@index');

    $router->get('/user', UserController::class . '@index');
    $router->post('/user/testUploadFile', UserController::class . '@testUploadFile');
});