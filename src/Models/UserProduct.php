<?php
namespace Models;

class UserProduct extends Model
{
    public int $id;
    public int $userId;
    public int $productId;
    public int $quantity;
    public Product $product;
    protected function getTableName(): string
    {
        return 'user_products';
    }

    public function getOneByUserIdByProductId($userId, $productId): UserProduct|false
    {
        $stmt = $this->getPdo()->prepare(
            "SELECT * FROM {$this->getTableName()} WHERE user_id = :user_id AND product_id = :product_id"
        );
        $stmt->execute([
            'user_id' => $userId,
            'product_id' => $productId
        ]);

        $result = $stmt->fetch();

        if ($result) {
            return $this->hydrate($result);
        }
        return false;
    }

    public function updateQuantityPlus($productId, $quantity, $userId): void
    {
        $stmt = $this->getPdo()->prepare(
            "UPDATE {$this->getTableName()} SET quantity = quantity + :quantity 
                    WHERE product_id = :product_id AND user_id = :user_id"
        );
        $stmt->execute([
            'quantity' => $quantity,
            'product_id' => $productId,
            'user_id' => $userId
        ]);
    }

    public function updateQuantityMinus($productId, $quantity, $userId): void
    {
        $stmt = $this->getPdo()->prepare(
            "UPDATE {$this->getTableName()} SET quantity = quantity - :quantity 
                    WHERE product_id = :product_id AND user_id = :user_id"
        );
        $stmt->execute([
            'quantity' => $quantity,
            'product_id' => $productId,
            'user_id' => $userId
        ]);
    }

    public function add($userId, $productId, $quantity): void
    {
        $stmt = $this->getPdo()->prepare(
            "INSERT INTO {$this->getTableName()} (user_id, product_id, quantity) 
                    VALUES (:user_id, :product_id, :quantity)"
        );
        $stmt->execute([
            'user_id' => $userId,
            'product_id' => $productId,
            'quantity' => $quantity]
        );
    }

    public function getAllByUserId($userId): array
    {
        $statement = $this->getPdo()->prepare(
            "SELECT * FROM {$this->getTableName()} WHERE user_id = :user_id"
        );
        $statement->execute(['user_id' => $userId]);
        $results = $statement->fetchAll();

        $entries = [];
        foreach ($results as $result) {
            $entries[] = $this->hydrate($result);
        }
        return $entries;
    }

    public function deleteByUserId($userId): void
    {
        $stmt = $this->getPdo()->prepare("DELETE FROM {$this->getTableName()} WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $userId]);
    }

    private function hydrate(array $data): self|false
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