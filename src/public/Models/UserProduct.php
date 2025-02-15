<?php

class UserProduct
{

    public function getOneByUserIdByProductId($userId, $productId)
    {
        $pdo = new PDO("pgsql:host=db;port=5432;dbname=postgres;", 'arsik', '0000');
        $stmt = $pdo->prepare("SELECT * FROM user_products WHERE product_id = :product_id AND user_id = :user_id");
        $stmt->execute(['product_id' => $productId, 'user_id' => $userId]);

        return $stmt->fetch();
    }

    public function updateQuantity($quantity, $productId, $userId): void
    {
        $pdo = new PDO("pgsql:host=db;port=5432;dbname=postgres;", 'arsik', '0000');
        $stmt = $pdo->prepare("UPDATE user_products SET quantity = quantity + :quantity WHERE product_id = :product_id AND user_id = :user_id");
        $stmt->execute(['quantity' => $quantity, 'product_id' => $productId, 'user_id' => $userId]);
    }

    public function add($userId, $productId, $quantity): void
    {
        $pdo = new PDO("pgsql:host=db;port=5432;dbname=postgres;", 'arsik', '0000');
        $stmt = $pdo->prepare("INSERT INTO user_products (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)");
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId, 'quantity' => $quantity]);
    }

    public function getByUserId($userId): array|false
    {
        $pdo = new PDO("pgsql:host=db;port=5432;dbname=postgres;", 'arsik', '0000');
        $statement = $pdo->prepare("SELECT * FROM user_products WHERE user_id = :user_id");
        $statement->execute(['user_id' => $userId]);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

}