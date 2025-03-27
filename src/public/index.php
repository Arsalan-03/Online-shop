<?php

use Controllers\CartController;
use Controllers\OrderController;
use Controllers\ProductController;
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
$app->get('/my_profile', UserController::class, 'myProfileForm');
$app->get('/edit_profile',UserController::class, 'getEditProfileForm');
$app->get('/cart', CartController::class, 'getCartForm');
$app->get('/order', OrderController::class, 'getOrderForm');
$app->get('/myOrders', OrderController::class, 'getAllOrders');

$app->post('/reviews', ProductController::class, 'addReviews', \Request\ReviewRequest::class);
$app->post('/open-product', ProductController::class, 'getOneProductForm');
$app->post('/userOrders',OrderController::class, 'getUserOrders');
$app->post('/registration', UserController::class, 'registrate', \Request\RegistrationRequest::class);
$app->post('/login', UserController::class, 'login', \Request\LoginRequest::class);
$app->post('/edit_profile', UserController::class, 'editProfile', \Request\EditProfileRequest::class);
$app->post('/addProduct', ProductController::class, 'addProduct', \Request\AddProductRequest::class);
$app->post('/deleteProduct', ProductController::class, 'deleteProduct', \Request\DeleteProductRequest::class);
$app->post('/logout', UserController::class, 'logout');
$app->post('/order',OrderController::class, 'order', \Request\OrderRequest::class);

$app->run();