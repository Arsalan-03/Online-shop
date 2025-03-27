<?php
namespace Core;

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
                try {
                    if ($requestClass !== null) {
                        $request = new $requestClass($_POST);
                        $controller->$method($request);
                    } else {
                        $controller->$method();
                    }
                } catch (\Throwable $exception) {
                    $errorMessage = sprintf(
                        "[%s] Ошибка: %s в %s на строке %d. Код: %d\n",
                        date('Y-m-d H:i:s'), // Дата и время
                        $exception->getMessage(), // Сообщение об ошибке
                        $exception->getFile(), // Файл, где произошла ошибка
                        $exception->getLine(), // Строка, где произошла ошибка
                        $exception->getCode() // Код ошибки
                    );

                    file_put_contents('./../Storage/Log/errors.txt', $errorMessage, FILE_APPEND);
                    require_once './../Views/505.php';
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