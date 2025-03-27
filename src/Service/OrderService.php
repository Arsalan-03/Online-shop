<?php

namespace Service;

use DTO\OrderCreateDTO;
use Models\Order;
use Models\OrderProduct;
use Models\UserProduct;
use Service\Auth\AuthInterface;
use Service\Auth\AuthSessionService;

class OrderService
{
    private AuthInterface $authInterface;
    private LoggerService $loggerService;

    public function __construct()
    {
        $this->authInterface = new AuthSessionService();
        $this->loggerService = new LoggerService();
    }
    public function order(OrderCreateDTO $data): void
    {
        $user = $this->authInterface->getCurrentUser();

        $userProducts = UserProduct::getAllByUserId($user->getId());
        try {
            $orderId = Order::create(
                $data->getEmail(),
                $data->getPhone(),
                $data->getName(),
                $data->getAddress(),
                $data->getCity(),
                $data->getCountry(),
                $data->getPostal(),
                $user->getId(),
            );

            foreach ($userProducts as $userProduct) {
                $productId = $userProduct->getProductId();
                $quantity = $userProduct->getQuantity();
                OrderProduct::create($orderId, $productId, $quantity);
            }

            UserProduct::deleteByUserId($user->getId());
        } catch (\Throwable $exception) {
            $this->loggerService->errors($exception);
        }

    }
}