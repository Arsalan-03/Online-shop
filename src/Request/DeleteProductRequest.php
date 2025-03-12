<?php

namespace Request;

use Models\Product;

class DeleteProductRequest extends Request
{
    private Product $productModel;

    public function __construct(array $body)
    {
        parent::__construct($body);
        $this->productModel = new Product();
    }

    public function getProductId(): int
    {
        return $this->body['product_id'];
    }

    public function getQuantity(): int
    {
        return $this->body['quantity'];
    }

    public function validate(): array
    {
        $errors = [];
        //Валидация товара
        if (isset($this->body['product_id'])) {
            $productId = (int)$this->body['product_id'];

            $result = $this->productModel->getOneById($productId);

            if ($result === false) {
                $errors['product_id'] = 'Товар не существует';
            }
        } else {
            $errors['product_id'] = 'Заполните поле product_ID';
        }

        //Валидация количества
        if (isset($this->body['quantity'])) {
            $quantity = (int)$this->body['quantity'];

            // Проверка, является ли quantity числом
            if (!is_numeric($quantity)) {
                $errors['quantity'] = 'Quantity должен быть числом';
            } elseif ($quantity < 1) {
                $errors['quantity'] = 'Некорректно введено quantity. Должно быть больше 0';
            } elseif ($quantity > 100) { // Пример: максимальное значение quantity
                $errors['quantity'] = 'Некорректно введено quantity. Должно быть меньше 100';
            }
        } else {
            $errors['quantity'] = 'Заполните поле Quantity';
        }
        return $errors;
    }
}