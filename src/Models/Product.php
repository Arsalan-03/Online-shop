<?php
namespace Models;
class Product extends Model
{
    public int $id;
    public string $image;
    public string $name;
    public string $description;
    public int $price;
    public Review $review;

    protected static function getTableName(): string
    {
        return 'products';
    }

    public static function getAll(): array
    {
        $tableName = self::getTableName();
        $statement = static::getPdo()->query(
            "SELECT * FROM $tableName"
        );
        $products = $statement->fetchAll();

        $newProducts = [];
        foreach ($products as $product) {
            $newProducts[] = static::hydrate($product);
        }

        return $newProducts;
    }

    public static function getOneById(int $productId): self|null
    {
        $tableName = self::getTableName();
        $stmt = static::getPdo()->prepare("
            SELECT * FROM $tableName WHERE id = :product_id"
        );
        $stmt->execute(['product_id' => $productId]);
        $products = $stmt->fetch();

        return static::hydrate($products);
    }

    public static function deleteProductByUserId(int $userId): void
    {
        $tableName = self::getTableName();
        $stmt = static::getPdo()->prepare(
            "DELETE FROM $tableName WHERE id = :user_id"
        );
        $stmt->execute(['user_id' => $userId]);
    }

    public static function hydrate(array $products): self|null
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

    public function getReview(): Review
    {
        return $this->review;
    }

    public function setReview(Review $review): void
    {
        $this->review = $review;
    }

}