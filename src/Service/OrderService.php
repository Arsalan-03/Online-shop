<?php

namespace Service;

use Models\OrderProduct;
use Models\UserProduct;

class OrderService
{
    private UserProduct $modelUserProduct;
    private OrderProduct $modelOrderProduct;

    public function __construct()
    {
        $this->modelUserProduct = new UserProduct();
        $this->modelOrderProduct = new OrderProduct();
    }
    public function order(int $userId, int $orderId): void
    {
        $userProducts = $this->modelUserProduct->getAllByUserId($userId);

        foreach ($userProducts as $userProduct) {
            $productId = $userProduct->getProductId();
            $quantity = $userProduct->getQuantity();
            $this->modelOrderProduct->create($orderId, $productId, $quantity);
        }

        $this->modelUserProduct->deleteByUserId($userId);
    }
}