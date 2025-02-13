<?php

require_once './classes/User.php';
require_once './classes/Product.php';

$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestUri === '/registrate') {
    if ($requestMethod === 'GET') {
        $user = new User();
        $user->getRegistrationForm();
    } elseif ($requestMethod === 'POST') {
        $user = new User();
        $user->registrate();
    } else {
        echo "$requestMethod не поддерживается адресом $requestUri";
    }
} if ($requestUri === '/login') {
    if ($requestMethod === 'GET') {
        $user = new User();
        $user->getLoginForm();
    } elseif ($requestMethod === 'POST') {
        $user = new User();
        $user->login();
    } else {
        echo "$requestMethod не поддерживается адресом $requestUri";
    }
} if ($requestUri === '/main') {
    if ($requestMethod === 'GET') {
        $user = new Product();
        $user->getCatalog();
    } else {
        echo "$requestMethod не поддерживается адресом $requestUri";
    }
} if ($requestUri === '/my_profile') {
    if ($requestMethod === 'GET') {
        $user = new User();
        $user->myProfile();
    } else {
        echo "$requestMethod не поддерживается адресом $requestUri";
    }
} if ($requestUri === '/edit_profile') {
    if ($requestMethod === 'GET') {
        $user = new User();
        $user->getEditProfileForm();
    } elseif ($requestMethod === 'POST') {
        $user = new User();
        $user->editProfile();
    } else {
        echo "$requestMethod не поддерживается адресом $requestUri";
    }
} if ($requestUri === '/addProduct') {
    if ($requestMethod === 'GET') {
        $user = new Product();
        $user->getAddProductForm();
    } elseif ($requestMethod === 'POST') {
        $user = new Product();
        $user->addProduct();
    } else {
        echo "$requestMethod не поддерживается адресом $requestUri";
    }
}