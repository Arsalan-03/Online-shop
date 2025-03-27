<?php
namespace Controllers;
use DTO\OrderCreateDTO;
use Models\Order;
use Models\OrderProduct;
use Models\Product;
use Models\UserProduct;
use Request\OrderRequest;
use Service\OrderService;

class OrderController extends BaseController
{
    private UserProduct $modelUserProduct;
    private Order $modelOrder;
    private OrderProduct $modelOrderProduct;
    private OrderService $orderService;

    public function __construct()
    {
        parent::__construct();
        $this->modelUserProduct = new UserProduct();
        $this->modelOrder = new Order();
        $this->modelOrderProduct = new OrderProduct();
        $this->orderService = new OrderService();
    }
    public function getOrderForm(): void
    {
        if ($this->authInterface->check()) {
            $user = $this->authInterface->getCurrentUser();
            $userId = $user->getId();

            $newOrderProducts = $this->modelUserProduct->getAllByUserId($userId);
            if (empty($newOrderProducts)) {
                header("Location: /main");
                exit();
            }
            require_once './../Views/order.php';
        } else {
            header("Location: /login");
            exit();
        }
    }

    public function getUserOrders(): void
    {
        if (!$this->authInterface->check()) {
            header("Location: /login");
            exit();
        }
        $user = $this->authInterface->getCurrentUser();
        $userId = $user->getId();
        $orderId = $_POST['id'];

        $userOrders = $this->modelOrder->getByIdAndUserId($orderId, $userId);

        $newOrderProducts = $this->modelOrderProduct->getAllByOrderId($orderId);


        if (empty($newOrderProducts)) {
            header("Location: /login");
            exit();
        }

        require_once './../Views/userOrders.php';
    }

    public function getAllOrders(): void
    {
        if (!$this->authInterface->check()) {
            header("Location: /login");
            exit();
        }

        $user = $this->authInterface->getCurrentUser();
        $userId = $user->getId();

        $userOrders = $this->modelOrder->getAllByUserId($userId);
        require_once './../Views/myOrders.php';
    }


    public function order(OrderRequest $request): void
    {
        $errors = $request->validate();

        if (empty($errors)) {
                $dto = new OrderCreateDTO(
                    $request->getEmail(),
                    $request->getPhone(),
                    $request->getName(),
                    $request->getAddress(),
                    $request->getCity(),
                    $request->getCountry(),
                    $request->getPostal());

                $this->orderService->order($dto);
                $this->getOrderForm();
        }
         $this->getOrderForm();
    }
}