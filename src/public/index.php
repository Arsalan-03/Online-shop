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

$app->get('/registration',  UserController::class, 'getRegistrationForm');
$app->get('/login',  UserController::class, 'getLoginForm');
$app->get('/main', ProductController::class, 'getCatalog');
$app->get('/my_profile', UserController::class, 'myProfile');
$app->get('/edit_profile',UserController::class, 'getEditProfileForm');
$app->get('/cart', CartController::class, 'getCartForm');
$app->get('/order', OrderController::class, 'getOrderForm');
$app->get('/myOrders', OrderController::class, 'getAllOrders');

$app->post('/reviews', ProductController::class, 'addReviews');
$app->post('/open-product', ProductController::class, 'getOneProductForm');
$app->post('/userOrders',OrderController::class, 'getUserOrders');
$app->post('/registration', UserController::class, 'registrate');
$app->post('/login', UserController::class, 'login');
$app->post('/edit_profile', UserController::class, 'editProfile');
$app->post('/addProduct', ProductController::class, 'addProduct');
$app->post('/deleteProduct', ProductController::class, 'deleteProduct');
$app->post('/logout', UserController::class, 'logout');
$app->post('/order',OrderController::class, 'order');

$app->run();