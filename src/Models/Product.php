<?php
require_once './../Models/Model.php';

class Product extends Model
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

    public function deleteProductByUserId(int $userId)
    {
        $stmt = $this->getPdo()->prepare("DELETE FROM products WHERE id = :user_id");
        $stmt->execute(['user_id' => $userId]);
    }

}