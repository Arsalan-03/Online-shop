<?php
namespace Models;

class UserProduct extends Model
{
    public int $id;
    public int $userId;
    public int $productId;
    public int $quantity;
    public Product $product;
    protected static function getTableName(): string
    {
        return 'user_products';
    }

    public static function getOneByUserIdByProductId($userId, $productId): UserProduct|false
    {
        $tableName = self::getTableName();
        $stmt = static::getPdo()->prepare(
            "SELECT * FROM $tableName WHERE user_id = :user_id AND product_id = :product_id"
        );
        $stmt->execute([
            'user_id' => $userId,
            'product_id' => $productId
        ]);

        $result = $stmt->fetch();

        if ($result) {
            return static::hydrate($result);
        }
        return false;
    }

    public static function updateQuantityPlus($productId, $quantity, $userId): void
    {
        $tableName = self::getTableName();
        $stmt = static::getPdo()->prepare(
            "UPDATE $tableName SET quantity = quantity + :quantity 
                    WHERE product_id = :product_id AND user_id = :user_id"
        );
        $stmt->execute([
            'quantity' => $quantity,
            'product_id' => $productId,
            'user_id' => $userId
        ]);
    }

    public static function updateQuantityMinus($productId, $quantity, $userId): void
    {
        $tableName = self::getTableName();
        $stmt = static::getPdo()->prepare(
            "UPDATE $tableName quantity = quantity - :quantity 
                    WHERE product_id = :product_id AND user_id = :user_id"
        );
        $stmt->execute([
            'quantity' => $quantity,
            'product_id' => $productId,
            'user_id' => $userId
        ]);
    }

    public static function add($userId, $productId, $quantity): void
    {
        $tableName = self::getTableName();
        $stmt = static::getPdo()->prepare(
            "INSERT INTO $tableName (user_id, product_id, quantity) 
                    VALUES (:user_id, :product_id, :quantity)"
        );
        $stmt->execute([
            'user_id' => $userId,
            'product_id' => $productId,
            'quantity' => $quantity]
        );
    }

    public static function getAllByUserId($userId): array
    {
        $tableName = self::getTableName();
        $statement = static::getPdo()->prepare(
            "SELECT up.id AS id, up.user_id, up.quantity, p.id AS product_id, p.image, p.name, p.description, p.price FROM $tableName up 
                    inner JOIN products p on up.product_id = p.id 
                    WHERE user_id = :user_id"
        );
        $statement->execute(['user_id' => $userId]);
        $results = $statement->fetchAll();

        $entries = [];
        foreach ($results as $result) {
            $entries[] = static::hydrateWithProduct($result);
        }
        return $entries;
    }

    public static function deleteByUserId($userId): void
    {
        $tableName = self::getTableName();
        $stmt = static::getPdo()->prepare("DELETE FROM $tableName WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $userId]);
    }

    private static function hydrateWithProduct(array $data): self|false
    {
        if (!$data) {
            return false;
        }

        $obj = static::hydrate($data);

        $product = Product::hydrate($data);
        $obj->setProduct($product);
        return $obj;
    }

    private static function hydrate(array $data): self|false
    {
        if (!$data) {
            return false;
        }

        $obj = new self();
        $obj->id = $data['id'];
        $obj->userId = $data['user_id'];
        $obj->productId = $data['product_id'];
        $obj->quantity = $data['quantity'];

        return $obj;
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

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): void
    {
        $this->product = $product;
    }
}