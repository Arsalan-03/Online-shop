<?php
namespace Controllers;
use Models\Product;
use Models\UserProduct;

class CartController
{
    private Product $modelProduct;
    private UserProduct $modelUserProduct;

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

        $userProducts = $this->modelUserProduct->getAllByUserId($userId); //Достаем идентификаторы продукта, который добавил текущий пользователь

        $cartProducts = [];
        if (empty($userProducts)) {
            header("Location: /main");
            exit();
        }

        $cartProducts = $this->newCartProducts($userProducts);
        require_once './../Views/cart.php';
    }

    private function newCartProducts(array $userProducts): array
    {
        $newCartProducts = [];

        foreach ($userProducts as $userProduct) {
            $product = $this->modelProduct->getOneById($userProduct->getProductId());
            $userProduct->setProduct($product);
            $newCartProducts[] = $userProduct;
        }
        return $newCartProducts;
    }

}
