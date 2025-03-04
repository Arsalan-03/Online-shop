<?php
namespace Models;
class Product extends Model
{
    public int $id;
    public string $image;
    public string $name;
    public string $description;
    public int $price;

    public function getAll(): array
    {
        $statement = $this->getPdo()->query(
            "SELECT * FROM products"
        );
        $products = $statement->fetchAll();

        $newProducts = [];
        foreach ($products as $product) {
            $newProducts[] = $this->hydrate($product);
        }

        return $newProducts;
    }

    public function getOneById(int $productId): self|null
    {
        $stmt = $this->getPdo()->prepare("
            SELECT * FROM products WHERE id = :product_id"
        );
        $stmt->execute(['product_id' => $productId]);
        $products = $stmt->fetch();

        return $this->hydrate($products);
    }

    public function deleteProductByUserId(int $userId): void
    {
        $stmt = $this->getPdo()->prepare(
            "DELETE FROM products WHERE id = :user_id"
        );
        $stmt->execute(['user_id' => $userId]);
    }

    private function hydrate(array $products): self|null
    {
        if (!$products)
        {
            return null;
        }

        $obj = new self();
        $obj->id = $products['id'];
        $obj->image = $products['image'];
        $obj->name = $products['name'];
        $obj->description = $products['description'];
        $obj->price = $products['price'];

        return $obj;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

}