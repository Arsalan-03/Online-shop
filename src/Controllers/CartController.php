<?php
namespace Controllers;
use Models\Product;
use Models\UserProduct;
use Service\Auth\AuthSessionService;

class CartController extends BaseController
{
    public function getCartForm(): void
    {
        if (!$this->authInterface->check()) {
            header("Location: /login");
        }

        $user = $this->authInterface->getCurrentUser();
        $userId = $user->getId();

        $cartProducts = UserProduct::getAllByUserId($userId);

        if (empty($cartProducts)) {
            header("Location: /main");
            exit();
        }

        require_once './../Views/cart.php';
    }

}
