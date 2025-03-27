<?php

namespace Service;

use DTO\ProductCreateDTO;
use Models\UserProduct;

class ProductService
{
    public function addProduct(ProductCreateDTO $data): bool
    {
        $result = UserProduct::getOneByUserIdByProductId($data->getUser()->getId(), $data->getProductId()); // Проверяем продукт по userId и ProductId

        if ($result === false) {
            UserProduct::add($data->getUser()->getId(), $data->getProductId(), $data->getQuantity()); // Добавляем новый товар в корзину
        } else {
            UserProduct::updateQuantityPlus($data->getProductId(), $data->getQuantity(), $data->getUser()->getId()); // Обновляем количество товара
            return true;
        }
        return false;
    }

    public function deleteProduct(ProductCreateDTO $data): bool
    {
        $result = UserProduct::getOneByUserIdByProductId($data->getUser()->getId(), $data->getProductId()); // Проверяем продукт по userId и ProductId

        if ($result === false) {
            return false;
        } else {
            UserProduct::updateQuantityMinus($data->getProductId(), $data->getQuantity(), $data->getUser()->getId());
            return true;
        }
    }
}