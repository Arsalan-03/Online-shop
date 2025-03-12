<?php

namespace Service;

use DTO\OrderCreateDTO;
use Models\Order;
use Models\OrderProduct;
use Models\UserProduct;

class OrderService
{
    private UserProduct $modelUserProduct;
    private OrderProduct $modelOrderProduct;
    private Order $modelOrder;

    public function __construct()
    {
        $this->modelUserProduct = new UserProduct();
        $this->modelOrderProduct = new OrderProduct();
        $this->modelOrder = new Order();
    }
    public function order(OrderCreateDTO $data): void
    {
        $userProducts = $this->modelUserProduct->getAllByUserId($data->getUser()->getId());
        $orderId = $this->modelOrder->create(
            $data->getEmail(),
            $data->getPhone(),
            $data->getName(),
            $data->getAddress(),
            $data->getCity(),
            $data->getCountry(),
            $data->getPostal(),
            $data->getUser()->getId(),
        );

        foreach ($userProducts as $userProduct) {
            $productId = $userProduct->getProductId();
            $quantity = $userProduct->getQuantity();
            $this->modelOrderProduct->create($orderId, $productId, $quantity);
        }

        $this->modelUserProduct->deleteByUserId($data->getUser()->getId());
    }
}