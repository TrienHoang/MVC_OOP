<?php 

use Bramus\Router\Router;

// Create Router instance
$router = new Router();

require 'admin.php';
require 'client.php';

// Run it!
$router->run();