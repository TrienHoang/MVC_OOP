<?php

use App\Controllers\Admin\UserController;

$router->mount('/admin', function() use ($router) {

    $router->get('/' , function(){
        echo "Đây là dashboard";
    });

    $router->get('/user', UserController::class . '@testBaseModel');
});