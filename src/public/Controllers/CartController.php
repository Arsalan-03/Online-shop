<?php

require_once './Models/UserProduct.php';
require_once './Models/Product.php';
class CartController
{
    public function getCartForm(): void
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
        }

        $userId = $_SESSION['user_id'];

        $modelUserProduct = new UserProduct();
        $userProducts = $modelUserProduct->getByUserId($userId); //Достаем идентификаторы продукта, который добавил текущий пользователь

        $cartProducts = [];
        foreach ($userProducts as $userProduct) {
            $productId = $userProduct['product_id'];

            $modelProduct = new Product();
            $product = $modelProduct->getOneById($productId); //Достаем данные продукта, который добавил текущий польлзователь

            $cartProducts[] = $product;
        }

        $totalPrice = 0;
         foreach ($cartProducts as $cartProduct) {
             foreach ($userProducts as $userProduct) {
                 $totalPrice += $cartProduct['price'] * $userProduct['quantity'];
             }
         }
        require_once './Views/cart.php';
    }

}