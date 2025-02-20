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
        ],
        '/logout' => [
            'POST' => [
                'class' => 'UserController',
                'method' => 'logout'
            ],
        ],
        '/order' => [
            'GET' => [
                'class' => 'OrderController',
                'method' => 'getOrderForm'
            ],
            'POST' => [
                'class' => 'OrderController',
                'method' => 'Order'
            ],
        ],
    ];

    public function run(): void
    {
        $requestUri = $_SERVER['REQUEST_URI'];
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        if (isset($this->routes[$requestUri])) {
            $routeMethods = $this->routes[$requestUri];
            if (isset($routeMethods[$requestMethod])) {
                $handler = $routeMethods[$requestMethod];

                $class = $handler['class'];
                $method = $handler['method'];

                $controller = new $class();
                $controller->$method();
            } else {
                echo "$requestMethod не поддерживается адресом $requestUri";
            }
        } else {
            http_response_code(404);
            require_once './../Views/404.php';
            exit();
        }
    }
}