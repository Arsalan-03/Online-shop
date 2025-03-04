<?php

namespace Models;

class OrderProduct extends Model
{
    private int $id;
    private int $orderId;
    private int $productId;
    private int $quantity;
    private Product $product;

    public function create(int $orderId, int $productId, int $quantity): void
    {
       $stmt = $this->getPdo()->prepare(
            "INSERT INTO order_products(order_id, product_id, quantity) VALUES(:order_id, :product_id, :quantity)"
        );

       $stmt->execute(['order_id' => $orderId, 'product_id' => $productId, 'quantity' => $quantity]);
    }

    private function hydrate(array $data): self|null
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