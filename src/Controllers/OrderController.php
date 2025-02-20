<?php

class OrderController
{
    private Product $modelProduct;
    private UserProduct $modelUserProduct;
    private Order $modelOrder;

    public function __construct()
    {
        $this->modelProduct = new Product();
        $this->modelUserProduct = new UserProduct();
        $this->modelOrder = new Order();
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

        $userProducts = $this->modelUserProduct->getByUserId($userId); //Достаем идентификаторы продукта, который добавил текущий пользователь

        $cartProducts = [];

        foreach ($userProducts as $userProduct) {
            $productId = $userProduct['product_id'];

            $product = $this->modelProduct->getOneById($productId); //Достаем данные продукта, который добавил текущий польлзователь
            $product['quantity'] = $userProduct['quantity'];
            $product['product_id'] = $userProduct['product_id'];

            $cartProducts[] = $product;
        }

        require_once './../Views/order.php';
    }

    public function order()
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

            $this->modelOrder->create($email, $phone, $fullName, $address, $city, $country, $postalCode);

//           $userProduct = $this->modelUserProduct->getByUserId($userId);
//           $userID['user_id'] = $userProduct['user_id'];
//           $productId['product_id'] = $userProduct['product_id'];
//            ДОКОНЧИТЬ

            $this->modelProduct->deleteProductByUserId($userId);
            header("Location: /order");
        }
         $this->getOrderForm();
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