<?php

namespace Models;

class OrderProduct extends Model
{
    private int $id;
    private int $orderId;
    private int $productId;
    private int $quantity;
    private Product $product;

   protected static function getTableName(): string
   {
       return 'order_products';
   }

    public static function create(int $orderId, int $productId, int $quantity): void
    {
        $tableName = static::getTableName();
       $stmt = static::getPdo()->prepare(
            "INSERT INTO $tableName (order_id, product_id, quantity) VALUES(:order_id, :product_id, :quantity)"
        );

       $stmt->execute(['order_id' => $orderId, 'product_id' => $productId, 'quantity' => $quantity]);
    }

    public static function getAllByOrderId(int $orderId): array
    {
        $tableName = static::getTableName();
        $stmt = static::getPdo()->prepare("SELECT * FROM $tableName op inner join products p on op.product_id = p.id WHERE order_id = :orderId");
        $stmt->execute(['orderId' => $orderId]);
        $orderProducts = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $newOrderProducts = [];
        foreach ($orderProducts as $orderProduct) {
            $newOrderProducts[] = static::hydrateWithProduct($orderProduct);
        }

        return $newOrderProducts;
    }

    private static function hydrateWithProduct($data): self|false
    {
        if (!$data) {
            return false;
        }

        $obj = static::hydrate($data);
        $product = Product::hydrate($data);
        $obj->setProduct($product);
        return $obj;
    }

    private static function hydrate(array $data): self|null
    {
        if (!$data)
        {
            return null;
        }

        $obj = new self();
        $obj->id = $data['id'];
        $obj->orderId = $data['order_id'];
        $obj->productId = $data['product_id'];
        $obj->quantity = $data['quantity'];

        return $obj;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getOrderId(): int
    {
        return $this->orderId;
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