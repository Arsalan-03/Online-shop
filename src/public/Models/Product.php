<?php

class Product
{
    public function getAll(): array
    {
        $pdo = new PDO("pgsql:host=db;port=5432;dbname=postgres;", 'arsik', '0000');
        $statement = $pdo->query("SELECT * FROM products");
        return $statement->fetchAll();
    }

    public function getOneById(int $productId)
    {
        $pdo = new PDO("pgsql:host=db;port=5432;dbname=postgres;", 'arsik', '0000');
        $stmt = $pdo->prepare("SELECT * FROM products WHERE id = :product_id");
        $stmt->execute(['product_id' => $productId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}