<?php

namespace Service;

use Models\UserProduct;

class ProductService
{
    private UserProduct $modelUserProduct;
    public function __construct()
    {
        $this->modelUserProduct = new UserProduct();
    }

    public function addProduct(int $userId, int $productId, int $quantity): bool
    {
        $result = $this->modelUserProduct->getOneByUserIdByProductId($userId, $productId); // Проверяем продукт по userId и ProductId

        if ($result === false) {
            $this->modelUserProduct->add($userId, $productId, $quantity); // Добавляем новый товар в корзину
        } else {
            $this->modelUserProduct->updateQuantityPlus($productId, $quantity, $userId); // Обновляем количество товара
            return true;
        }
        return false;
    }

    public function deleteProduct(int $userId, int $productId, int $quantity): bool
    {
        $result = $this->modelUserProduct->getOneByUserIdByProductId($userId, $productId); // Проверяем продукт по userId и ProductId

        if ($result === false) {
            return false;
        } else {
            $this->modelUserProduct->updateQuantityMinus($productId, $quantity, $userId);
            return true;
        }
    }
}