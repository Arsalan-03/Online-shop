<?php
namespace Controllers;

use DTO\ProductCreateDTO;
use Models\Product;
use Models\Review;
use Request\AddProductRequest;
use Request\DeleteProductRequest;
use Request\ReviewRequest;
use Service\AuthService;
use Service\ProductService;

class ProductController
{
    private Product $modelProduct;
    private Review $modelReview;
    private AuthService $authService;
    private ProductService $productService;

    public function __construct()
    {
        $this->modelProduct = new Product();
        $this->authService = new AuthService();
        $this->modelReview = new Review();
        $this->productService = new ProductService();
    }

    public function getCatalog(): void
    {

        if (!$this->authService->check()) {
            header("Location: /login");
        }

        $products = $this->modelProduct->getAll();

        require_once './../Views/catalog.php';
        exit();
    }

    public function getOneProductForm(): void
    {
        if (!$this->authService->check()) {
            header("Location: /login");
            exit();
        }

        $productId = $_POST['product_id'];
        $products = $this->modelProduct->getOneById($productId);
        $reviews = $this->modelReview->getById($productId);

        require_once './../Views/product.php';
    }

    public function addProduct(AddProductRequest $request): void
    {
        $errors = $request->validate();
        if (empty($errors)) {
            $user = $this->authService->getCurrentUser();
            $dto = new ProductCreateDTO(
                $request->getProductId(),
                $user,
                $request->getQuantity(),
            );

            $result = $this->productService->addProduct($dto);
            if ($result === true)
            {
                header("Location: /order");
                exit();
            }
        }
        header("Location: /main");
    }

    public function deleteProduct(DeleteProductRequest $request): void
    {
        $errors = $request->validate();
        if (empty($errors)) {
            $user = $this->authService->getCurrentUser();

            $dto = new ProductCreateDTO(
                $request->getProductId(),
                $user,
                $request->getQuantity(),
            );
            $result = $this->productService->deleteProduct($dto);
            if ($result === false) {
                $errors[] = 'Добавьте товар в корзину';
            } else {
                header("Location: /order");
                exit();
            }
        }
    }

    public function addReviews(ReviewRequest $request): void
    {
        $errors = $request->validate();
        if (empty($errors)) {
            $user = $this->authService->getCurrentUser();
            $userId = $user->getId();

            $this->modelReview->add($userId, $request->getProductId(), $request->getRating(), $request->getAuthor(), $request->getReviewText());
        }
        $this->getOneProductForm();
        require_once './../Views/product.php';
    }


    private function newReviews($products): array
    {
        $newProduct = [];
        $productId = $_POST['product_id'];

            $review = $this->modelReview->getById($productId);
            $products->setReview($review);
            $newProduct[] = $products;

        return $newProduct;
    }
}
