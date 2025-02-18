<?php

require_once './Models/Product.php';
require_once './Models/UserProduct.php';

class ProductController
{
    public function getCatalog(): void
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
        }

        $modelProduct = new Product();
        $products = $modelProduct->getAll();

        require_once './Views/catalog.php';
        exit();
    }

    public function addProduct(): void
    {
        $errors = $this->addProductValidate($_POST);
        if (empty($errors)) {

            session_start();
            $userId = $_SESSION['user_id'];
            $productId = $_POST['product_id'];
            $quantity = $_POST['quantity'];


            // Проверяем, есть ли продукт в таблице
            $modelUserProduct = new UserProduct();
            $result = $modelUserProduct->getOneByUserIdByProductId($userId, $productId); // Проверяем продукт по userId и ProductId

            if ($result === false) {
                $modelUserProduct->add($userId, $productId, $quantity); // Добавляем новый товар в корзину
            } else {
                $modelUserProduct->updateQuantity($productId, $quantity, $userId); // Обновляем количество товара

            }
        }
        header("Location: /main");
    }

    private function addProductValidate(array $date): array
    {
        $errors = [];
        //Валидация товара
        if (isset($date['product_id'])) {
            $productId = (int) $date['product_id'];

            $modelProduct = new Product();
            $result = $modelProduct->getOneById($productId);

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