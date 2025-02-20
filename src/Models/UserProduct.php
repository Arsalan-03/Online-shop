<?php

require_once './../Models/Model.php';

class UserProduct extends Model
{
    public int $id;
    public int $userId;
    public int $productId;
    public int $quantity;

    public function getOneByUserIdByProductId($userId, $productId)
    {
        $stmt = $this->getPdo()->prepare("SELECT * FROM user_products WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId]);

        return $stmt->fetch();
    }

    public function updateQuantityPlus($productId, $quantity, $userId): void
    {
        $stmt = $this->getPdo()->prepare("UPDATE user_products SET quantity = quantity + :quantity WHERE product_id = :product_id AND user_id = :user_id");
        $stmt->execute(['quantity' => $quantity, 'product_id' => $productId, 'user_id' => $userId]);
    }

//    public function updateQuantityPlus($productId, $quantity, $userId): void
//    {
//        $stmt = $this->getPdo()->prepare("UPDATE user_products SET quantity = quantity - :quantity WHERE product_id = :product_id AND user_id = :user_id");
//        $stmt->execute(['quantity' => $quantity, 'product_id' => $productId, 'user_id' => $userId]);
//    }

    public function add($userId, $productId, $quantity): void
    {
        $stmt = $this->getPdo()->prepare("INSERT INTO user_products (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)");
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId, 'quantity' => $quantity]);
    }

    public function getByUserId($userId): array|false
    {
        $statement = $this->getPdo()->prepare("SELECT * FROM user_products WHERE user_id = :user_id");
        $statement->execute(['user_id' => $userId]);

        return $statement->fetchAll();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
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