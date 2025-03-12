<?php
namespace Core;

use Request\Request;

class App
{
    private array $routes = [];

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

                $requestClass = $handler['request'];

                if ($requestClass !== null) {
                    $request = new $requestClass($_POST);
                    $controller->$method($request);
                } else {
                    $controller->$method();
                }
            } else {
                echo "$requestMethod не поддерживается адресом $requestUri";
            }
        } else {
            http_response_code(404);
            require_once './../Views/404.php';
            exit();
        }
    }

    public function get(string $route, string $className, string $method, string $requestClass = null): void
    {
        $this->routes[$route]['GET'] = [
            'class' => $className,
            'method' => $method,
            'request' => $requestClass,
        ];
    }

    public function post(string $route, string $className, string $method, string $requestClass = null): void
    {
        $this->routes[$route]['POST'] = [
            'class' => $className,
            'method' => $method,
            'request' => $requestClass,
        ];
    }

    public function put(string $route, string $className, string $method, string $requestClass = null): void
    {
        $this->routes[$route]['PUT'] = [
            'class' => $className,
            'method' => $method,
            'request' => $requestClass,
        ];
    }

    public function delete(string $route, string $className, string $method, string $requestClass = null): void
    {
        $this->routes[$route]['DELETE'] = [
            'class' => $className,
            'method' => $method,
            'request' => $requestClass,
        ];
    }
}