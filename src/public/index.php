<?php

use Controllers\CartController;
use Controllers\OrderController;
use Controllers\ProductController;
use Controllers\TestController;
use Controllers\UserController;
use Core\App;
use Core\Autoloader;

require_once './../Core/Autoloader.php';

$path = dirname(__DIR__);
Autoloader::register($path);

$app = new App();

$app->addRoute('/registration', 'GET', UserController::class, 'getRegistrationForm');
$app->addRoute('/login', 'GET', UserController::class, 'getLoginForm');
$app->addRoute('/main', 'GET', ProductController::class, 'getCatalog');
$app->addRoute('/my_profile', 'GET', UserController::class, 'myProfile');
$app->addRoute('/edit_profile', 'GET', UserController::class, 'getEditProfileForm');
$app->addRoute('/cart', 'GET', CartController::class, 'getCartForm');
$app->addRoute('/order', 'GET', OrderController::class, 'getOrderForm');
$app->addRoute('/myOrders', 'GET', OrderController::class, 'getAllOrders');

$app->addRoute('/userOrders', 'POST', OrderController::class, 'getUserOrders');
$app->addRoute('/registration', 'POST', UserController::class, 'registrate');
$app->addRoute('/login', 'POST', UserController::class, 'login');
$app->addRoute('/edit_profile', 'POST', UserController::class, 'editProfile');
$app->addRoute('/addProduct', 'POST', ProductController::class, 'addProduct');
$app->addRoute('/deleteProduct', 'POST', ProductController::class, 'deleteProduct');
$app->addRoute('/logout', 'POST', UserController::class, 'logout');
$app->addRoute('/order', 'POST', OrderController::class, 'order');

$app->run();