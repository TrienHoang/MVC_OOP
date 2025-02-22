<?php

use App\Controllers\Client\ProductController;
use App\Controllers\Client\AboutController;
use App\Controllers\Client\HomeController;

$router->get('/', HomeController::class . '@index');
$router->get('/about', AboutController::class . '@index');
$router->get('/allproducts', ProductController::class . '@allProduct');
$router->get('/detail/{slug}', ProductController::class . '@detailProduct');