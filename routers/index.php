<?php 

use Bramus\Router\Router;

// Create Router instance
$router = new Router();

require 'admin.php';
require 'client.php';
require 'auth.php';

// Run it!
$router->run();