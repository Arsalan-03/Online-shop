<?php
namespace Controllers;
use Models\Product;
use Models\UserProduct;
use Service\AuthService;

class CartController
{
    private Product $modelProduct;
    private UserProduct $modelUserProduct;
    private AuthService $authService;

    public function __construct()
    {
        $this->modelProduct = new Product();
        $this->modelUserProduct = new UserProduct();
        $this->authService = new AuthService();
    }

    public function getCartForm(): void
    {
        if (!$this->authService->check()) {
            header("Location: /login");
        }

        $user = $this->authService->getCurrentUser();
        $userId = $user->getId();

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
