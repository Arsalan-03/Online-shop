<?php
namespace Controllers;
use Models\Order;
use Models\OrderProduct;
use Models\Product;
use Models\UserProduct;

class OrderController
{
    private Product $modelProduct;
    private UserProduct $modelUserProduct;
    private Order $modelOrder;
    private OrderProduct $modelOrderProduct;

    public function __construct()
    {
        $this->modelProduct = new Product();
        $this->modelUserProduct = new UserProduct();
        $this->modelOrder = new Order();
        $this->modelOrderProduct = new OrderProduct();
    }
    public function getOrderForm(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit();
        }

        $userId = $_SESSION['user_id'];
        $userProducts = $this->modelUserProduct->getAllByUserId($userId); //Достаем идентификаторы продукта, который добавил текущий пользователь
        if (empty($userProducts)) {
            header("Location: /main");
            exit();
        }
        $newOrderProducts = $this->newOrderProducts($userProducts);
        require_once './../Views/order.php';
    }

    private function newOrderProducts(array $userProducts): array
    {
        $newOrderProducts = [];

        foreach ($userProducts as $userProduct) {
            $product = $this->modelProduct->getOneById($userProduct->getProductId());
            $userProduct->setProduct($product);
            $newOrderProducts[] = $userProduct;
        }
        return $newOrderProducts;
    }

    public function order(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit();
        }

        $errors = $this->orderValidate($_POST);

        if (empty($errors)) {
            $userId = $_SESSION['user_id'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $fullName = $_POST['name'];
            $address = $_POST['address'];
            $city = $_POST['city'];
            $country = $_POST['country'];
            $postalCode = $_POST['postalCode'];

            $orderId = $this->modelOrder->create($userId, $email, $phone, $fullName, $address, $city, $country, $postalCode);

            $userProducts = $this->modelUserProduct->getAllByUserId($userId);

            foreach ($userProducts as $userProduct) {
                $productId = $userProduct->getProductId();
                $quantity = $userProduct->getQuantity();
                $this->modelOrderProduct->create($orderId, $productId, $quantity);
            }

            $this->modelUserProduct->deleteByUserId($userId);
            $this->getOrderForm();
        }
         $this->getOrderForm();
    }

    public function getAllOrders(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit();
        }

        $userId = $_SESSION['user_id'];

        $userOrders = $this->modelOrder->getAllByUserId($userId);
        require_once './../Views/myOrders.php';
    }

    public function getUserOrders(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit();
        }
        $userId = $_SESSION['user_id'];
        $orderId = $_POST['id'];

        $newUserOrders = $this->modelOrder->getByIdAndUserId($orderId, $userId);
        //доделать

        require_once './../Views/userOrders.php';
    }

    public function orderValidate(array $data): array
    {
        $errors = [];

        // Валидация email
        if (isset($data['email'])) {
            $email = $data['email'];
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Неправильный формат email.';
        } else {
            $errors['email'] = 'Email является обязательным полем.';

        }

        // Валидация телефона
        if (isset($data['phone'])) {
            $phone = $data['phone'];
        } elseif (!preg_match('/^\+?[0-9]{10,15}$/', $data['phone'])) {
            $errors['phone'] = 'Неправильный формат телефона. Убедитесь, что номер состоит из 10-15 цифр, возможно, с начальным знаком "плюс".';
        } else {
            $errors['phone'] = 'Телефон является обязательным полем.';
        }

        // Валидация полного имени
        if (isset($data['name'])) {
            $fullName = $data['name'];
        } elseif (strlen($data['name']) < 3) {
            $errors['name'] = 'Полное имя должно содержать как минимум 3 символа.';
        } else {
            $errors['name'] = 'Полное имя является обязательным полем.';
        }

        // Валидация адреса
        if (isset($data['address'])) {
            $address = $data['address'];
        } else {
            $errors['address'] = 'Адрес является обязательным полем.';
        }

        // Валидация города
        if (isset($data['city'])) {
            $city = $data['city'];
        } else {
            $errors['city'] = 'Город является обязательным полем.';
        }

        // Валидация страны
        if (isset($data['country'])) {
            $country = $data['country'];
        } else {
            $errors['country'] = 'Страна является обязательным полем.';
        }

        // Валидация почтового индекса
        if (isset($data['postalCode'])) {
            $postalCode = $data['postalCode'];
        } elseif (!preg_match('/^[0-9]{5,10}$/', $data['postalCode'])) {
            $errors['postalCode'] = 'Неправильный формат почтового индекса. Убедитесь, что он состоит из 5-10 цифр.';
        } else {
            $errors['postalCode'] = 'Почтовый индекс является обязательным полем.';
        }

        return $errors;
    }
}