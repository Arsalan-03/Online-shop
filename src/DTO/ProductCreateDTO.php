<?php

namespace DTO;

use Models\User;

class ProductCreateDTO
{
    public function __construct(
        private int $productId,
        private User $user,
        private int $quantity,
    ){
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }


}