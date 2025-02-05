<?php
$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestUri === '/registrate') {
    if ($requestMethod === 'GET') {
        require_once 'get_registration.php';
    } elseif ($requestMethod === 'POST') {
        require_once 'post_registration.php';
    } else {
        echo "$requestMethod не поддерживается адресом $requestUri";
    }
} if ($requestUri === '/login') {
    if ($requestMethod === 'GET') {
        require_once 'get_login.php';
    } elseif ($requestMethod === 'POST') {
        require_once 'post_login.php';
    }
    else {
        echo "$requestMethod не поддерживается адресом $requestUri";
    }
} if ($requestUri === '/main') {
    if ($requestMethod === 'GET') {
        require_once 'test.php';
    } else {
        echo "$requestMethod не поддерживается адресом $requestUri";
    }
} else {
    require_once '404.php';
}