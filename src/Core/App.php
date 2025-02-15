<?php
class App
{

    private array $routes = [
        '/registration' => [
            'GET' => [
                'class' => 'UserController',
                'method' => 'getRegistrationForm'
            ],
            'POST' => [
                'class' => 'UserController',
                'method' => 'registrate'
            ],
        ],
        '/login' => [
            'GET' => [
                'class' => 'UserController',
                'method' => 'getLoginForm'
            ],
            'POST' => [
                'class' => 'UserController',
                'method' => 'login'
            ],
        ],
        '/main' => [
            'GET' => [
                'class' => 'ProductController',
                'method' => 'getCatalog'
            ],
        ],
        '/my_profile' => [
            'GET' => [
                'class' => 'UserController',
                'method' => 'myProfile'
            ],
        ],
        '/edit_profile' => [
            'GET' => [
                'class' => 'UserController',
                'method' => 'getEditProfileForm'
            ],
            'POST' => [
                'class' => 'UserController',
                'method' => 'editProfile'
            ],
        ],
        '/addProduct' => [
            'POST' => [
                'class' => 'ProductController',
                'method' => 'addProduct'
            ],
        ],
        '/cart' => [
            'GET' => [
                'class' => 'CartController',
                'method' => 'getCartForm'
            ]
        ]
    ];

    public function run(): void
    {
        $requestUri = $_SERVER['REQUEST_URI'];
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        if (!isset($this->routes[$requestUri])) {
            http_response_code(404);
            require_once './Views/404.php';
            exit();
        }

        $routeMethods = $this->routes[$requestUri]; // в переменную вставляем адрес
        if (!isset($routeMethods[$requestMethod])) {
            http_response_code(405);
            echo "$requestMethod не поддерживается адресом $requestUri";
        }

        $handler = $routeMethods[$requestMethod]; // handler-это обработчик. туда вставляем адрес с методом

        $class = $handler['class'];
        $method = $handler['method'];

        $controller = new $class();
        $controller->$method();
    }

}