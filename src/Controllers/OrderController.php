<?php
namespace Controllers;
use DTO\OrderCreateDTO;
use Models\Order;
use Models\OrderProduct;
use Models\Product;
use Models\UserProduct;
use Request\OrderRequest;
use Service\AuthService;
use Service\OrderService;

class OrderController
{
    private Product $modelProduct;
    private UserProduct $modelUserProduct;
    private Order $modelOrder;
    private OrderProduct $modelOrderProduct;
    private AuthService $authService;
    private OrderService $orderService;

    public function __construct()
    {
        $this->modelProduct = new Product();
        $this->modelUserProduct = new UserProduct();
        $this->modelOrder = new Order();
        $this->modelOrderProduct = new OrderProduct();
        $this->authService = new AuthService();
        $this->orderService = new OrderService();
    }
    public function getOrderForm(): void
    {
        if ($this->authService->check()) {
            $user = $this->authService->getCurrentUser();
            $userId = $user->getId();

            $userProducts = $this->modelUserProduct->getAllByUserId($userId); //Достаем идентификаторы продукта, который добавил текущий пользователь
            if (empty($userProducts)) {
                header("Location: /main");
                exit();
            }
            $newOrderProducts = $this->newOrderProducts($userProducts);
            require_once './../Views/order.php';
        }
        header("Location: /login");
        exit();
    }

    public function getUserOrders(array $data): void
    {
        if (!$this->authService->check()) {
            header("Location: /login");
            exit();
        }
        $user = $this->authService->getCurrentUser();
        $userId = $user->getId();
        $orderId = $data['id'];

        $userOrders = $this->modelOrder->getByIdAndUserId($orderId, $userId);

        $orderProducts = $this->modelOrderProduct->getAllByOrderId($orderId);
        if (empty($orderProducts)) {
            header("Location: /login");
            exit();
        }

        $newOrderProducts = $this->newOrderProducts($orderProducts);

        require_once './../Views/userOrders.php';
    }

    public function getAllOrders(): void
    {
        if (!$this->authService->check()) {
            header("Location: /login");
            exit();
        }

        $user = $this->authService->getCurrentUser();
        $userId = $user->getId();

        $userOrders = $this->modelOrder->getAllByUserId($userId);
        require_once './../Views/myOrders.php';
    }


    public function order(OrderRequest $request): void
    {
        $errors = $request->validate();

        if (empty($errors)) {
            if ($user = $this->authService->getCurrentUser()){
                $dto = new OrderCreateDTO(
                    $request->getEmail(),
                    $request->getPhone(),
                    $request->getName(),
                    $request->getAddress(),
                    $request->getCity(),
                    $request->getCountry(),
                    $request->getPostal(),
                    $user);

                $this->orderService->order($dto);
                $this->getOrderForm();
            } else {
                header("Location: /login");
                exit();
            }
        }
         $this->getOrderForm();
    }

    private function newOrderProducts(array $userProducts): array
    {
        $newOrderProducts = [];

        foreach ($userProducts as $userProduct) {
            $product = $this->modelProduct->getOneById($userProduct->getProductId());
            $userProduct->setProduct($product);
            $newOrderProducts[] = $userProduct;
        }
        return $newOrderProducts;
    }
}