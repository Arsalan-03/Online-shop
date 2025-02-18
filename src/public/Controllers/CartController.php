<?php
require_once './Models/UserProduct.php';
require_once './Models/Product.php';
class CartController
{
    private $modelProduct;
    private $modelUserProduct;
    public function __construct()
    {
        $this->modelProduct = new Product();
        $this->modelUserProduct = new UserProduct();
    }
    public function getCartForm(): void
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
        }

        $userId = $_SESSION['user_id'];

        $userProducts = $this->modelUserProduct->getByUserId($userId); //Достаем идентификаторы продукта, который добавил текущий пользователь

        $cartProducts = [];

        foreach ($userProducts as $userProduct) {
            $productId = $userProduct['product_id'];

            $product = $this->modelProduct->getOneById($productId); //Достаем данные продукта, который добавил текущий польлзователь

            $cartProducts[] = $product;
        }

        require_once './Views/cart.php';
    }

}