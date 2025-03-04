<?php
namespace Controllers;

use Models\Product;
use Models\UserProduct;
use Service\AuthService;

class ProductController
{
    private Product $modelProduct;
    private UserProduct $modelUserProduct;
    private AuthService $authService;

    public function __construct()
    {
        $this->modelProduct = new Product();
        $this->modelUserProduct = new UserProduct();
        $this->authService = new AuthService();
    }

    public function getCatalog(): void
    {

        if (!$this->authService->check()) {
            header("Location: /login");
        }

        $products = $this->modelProduct->getAll();

        require_once './../Views/catalog.php';
        exit();
    }

    public function addProduct(): void
    {
        $errors = $this->addProductValidate($_POST);
        if (empty($errors)) {

            $user = $this->authService->getCurrentUser();
            $userId = $user->getId();
            $productId = $_POST['product_id'];
            $quantity = $_POST['quantity'];


            // Проверяем, есть ли продукт в таблице
            $result = $this->modelUserProduct->getOneByUserIdByProductId($userId, $productId); // Проверяем продукт по userId и ProductId

            if ($result === false) {
                $this->modelUserProduct->add($userId, $productId, $quantity); // Добавляем новый товар в корзину
            } else {
                $this->modelUserProduct->updateQuantityPlus($productId, $quantity, $userId); // Обновляем количество товара
                header("Location: /order");
                exit();
            }
        }
        header("Location: /main");
    }

    private function addProductValidate(array $date): array
    {
        $errors = [];
        //Валидация товара
        if (isset($date['product_id'])) {
            $productId = (int)$date['product_id'];

            $result = $this->modelProduct->getOneById($productId);

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

    public function deleteProduct(): void
    {
        $errors = $this->addProductValidate($_POST);
        if (empty($errors)) {


            $user = $this->authService->getCurrentUser();
            $userId = $user->getId();
            $productId = $_POST['product_id'];
            $quantity = $_POST['quantity'];

            // Проверяем, есть ли продукт в таблице
            $result = $this->modelUserProduct->getOneByUserIdByProductId($userId, $productId); // Проверяем продукт по userId и ProductId

            if ($result === false) {
                $errors[] = 'Добавьте товар в корзину';
            } else {
                $this->modelUserProduct->updateQuantityMinus($productId, $quantity, $userId);
                header("Location: /order");
                exit();
            }
        }
    }
}
