<?php

class Product
{
    public function getCatalog(): void
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
        }

        $pdo = new PDO("pgsql:host=db;port=5432;dbname=postgres;", 'arsik', '0000');
        $statement = $pdo->query("SELECT * FROM products");
        $products = $statement->fetchAll();

        require_once './View/get_catalog.php';
    }

    public function getAddProductForm(): void
    {
        require_once './View/get_addProduct.php';
    }

    public function addProduct(): void
    {
        $errors = $this->addProductValidate($_POST);
        if (empty($errors)) {

            $userId = $_SESSION['user_id'];
            $productId = $_POST['product_id'];
            $quantity = $_POST['quantity'];

            $pdo = new PDO("pgsql:host=db;port=5432;dbname=postgres;", 'arsik', '0000');

            // Проверяем, есть ли продукт в таблице
            $stmt = $pdo->prepare("SELECT * FROM user_products WHERE product_id = :product_id AND user_id = :user_id");
            $stmt->execute(['product_id' => $productId, 'user_id' => $userId]);  // Добавлен user_id для фильтрации
            $result = $stmt->fetch();

            if ($result) {
                // Обновляем количество товара
                $stmt = $pdo->prepare("UPDATE user_products SET quantity = quantity + :quantity WHERE product_id = :product_id AND user_id = :user_id");
                $stmt->execute(['quantity' => $quantity, 'product_id' => $productId, 'user_id' => $userId]);
            } else {
                // Добавляем новый товар в корзину
                $stmt = $pdo->prepare("INSERT INTO user_products (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)");
                $stmt->execute(['user_id' => $userId, 'product_id' => $productId, 'quantity' => $quantity]);
            }
        }
        require_once './View/get_addProduct.php';
    }

    private function addProductValidate(array $date): array
    {
        $errors = [];
        //Валидация товара
        if (isset($date['product_id'])) {
            $productId = (int) $date['product_id'];
            $pdo = new PDO("pgsql:host=db;port=5432;dbname=postgres;", 'arsik', '0000');
            $stmt = $pdo->prepare("SELECT * FROM products WHERE id = :product_id");
            $stmt->execute(['product_id' => $productId]);
            $result = $stmt->fetch();

            if ($result === false) {
                $errors['product_id'] = 'Товар не существует';
            }
        } else {
            $errors['product_id'] = 'Заполните поле product_ID';
        }

        //Валидация количества
        if (isset($date['quantity'])) {
            $quantity = $date['quantity'];

            // Проверка, является ли quantity числом
            if (!is_numeric($quantity)) {
                $errors['quantity'] = 'Quantity должен быть числом';
            } elseif ($quantity < 1) {
                $errors['quantity'] = 'Некорректно введено quantity. Должно быть больше 0';
            } elseif ($quantity > 100) { // Пример: максимальное значение quantity
                $errors['quantity'] = 'Некорректно введено quantity. Должно быть меньше 100';
            }
        } else {
            $errors['quantity'] = 'Заполните поле Quantity';
        }
        return $errors;
    }
}