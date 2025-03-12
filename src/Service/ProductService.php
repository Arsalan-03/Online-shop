<?php

namespace Service;

use DTO\ProductCreateDTO;
use Models\User;
use Models\UserProduct;

class ProductService
{
    private UserProduct $modelUserProduct;
    public function __construct()
    {
        $this->modelUserProduct = new UserProduct();
    }

    public function addProduct(ProductCreateDTO $data): bool
    {
        $result = $this->modelUserProduct->getOneByUserIdByProductId($data->getUser()->getId(), $data->getProductId()); // Проверяем продукт по userId и ProductId

        if ($result === false) {
            $this->modelUserProduct->add($data->getUser()->getId(), $data->getProductId(), $data->getQuantity()); // Добавляем новый товар в корзину
        } else {
            $this->modelUserProduct->updateQuantityPlus($data->getProductId(), $data->getQuantity(), $data->getUser()->getId()); // Обновляем количество товара
            return true;
        }
        return false;
    }

    public function deleteProduct(ProductCreateDTO $data): bool
    {
        $result = $this->modelUserProduct->getOneByUserIdByProductId($data->getUser()->getId(), $data->getProductId()); // Проверяем продукт по userId и ProductId

        if ($result === false) {
            return false;
        } else {
            $this->modelUserProduct->updateQuantityMinus($data->getProductId(), $data->getQuantity(), $data->getUser()->getId());
            return true;
        }
    }
}