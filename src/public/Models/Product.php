<?php

require_once 'Models/Database.php';

class Product extends Database
{
    public int $id;
    public string $image;
    public string $name;
    public string $description;
    public int $price;

    public function getAll(): array
    {
        $statement = $this->getPdo()->query("SELECT * FROM products");
        return $statement->fetchAll();
    }

    public function getOneById(int $productId)
    {
        $stmt = $this->getPdo()->prepare("SELECT * FROM products WHERE id = :product_id");
        $stmt->execute(['product_id' => $productId]);
        return $stmt->fetch();
    }


}