<?php
namespace Controllers;

use Models\Product;
use Models\Review;
use Models\UserProduct;
use Service\AuthService;
use Service\ProductService;

class ProductController
{
    private Product $modelProduct;
    private UserProduct $modelUserProduct;
    private Review $modelReview;
    private AuthService $authService;
    private ProductService $productService;

    public function __construct()
    {
        $this->modelProduct = new Product();
        $this->modelUserProduct = new UserProduct();
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

    public function addProduct(): void
    {
        $errors = $this->addProductValidate($_POST);
        if (empty($errors)) {

            $user = $this->authService->getCurrentUser();
            $userId = $user->getId();
            $productId = $_POST['product_id'];
            $quantity = $_POST['quantity'];

            $result = $this->productService->addProduct($userId, $productId, $quantity);
            if ($result === true)
            {
                header("Location: /order");
                exit();
            }
        }
        header("Location: /main");
    }

    public function deleteProduct(): void
    {
        $errors = $this->addProductValidate($_POST);
        if (empty($errors)) {
            $user = $this->authService->getCurrentUser();
            $userId = $user->getId();
            $productId = $_POST['product_id'];
            $quantity = $_POST['quantity'];

            $result = $this->productService->deleteProduct($userId, $productId, $quantity);
            if ($result === false) {
                $errors[] = 'Добавьте товар в корзину';
            } else {
                header("Location: /order");
                exit();
            }
        }
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

    public function addReviews(): void
    {
        $errors = $this->reviewValidate($_POST);
        if (empty($errors)) {
            $user = $this->authService->getCurrentUser();
            $userId = $user->getId();
            $productId = $_POST['product_id'];
            $rating = $_POST['rating'];
            $author = $_POST['author'];
            $reviewText = $_POST['review-text'];

            $this->modelReview->add($userId, $productId, $rating, $author, $reviewText);
        }

        $this->getOneProductForm();
        require_once './../Views/product.php';
    }

    private function reviewValidate(array $data): array
    {
        $errors = [];
        //Валидация Оценки
        if (isset($data['rating'])) {
            $rating = (int)$data['rating'];

            if ($rating < 0 || $rating > 5) {
                $errors['rating'] = 'Отзыв не может быть меньше 0 и больше 5';
            }
        } else{
            $errors['rating'] = 'Заполните поле Оценка';
        }

        //Валидация автора
        if (isset($data['author'])) {
            $author = $data['author'];
            if (strlen($author) < 2 || strlen($author) > 50) {
                $errors['name'] = "Недопустимое количество букв в поле Name";
            }
        } else {
            $errors['author'] = 'Заполните поле Автор';
        }

        //Валидация Отзыва-текст
        if (isset($data['review-text'])) {
            $reviewText = $data['review-text'];
            if (strlen($reviewText) < 2 || strlen($reviewText) > 255) {
                $errors['review-text'] = 'Недопустимое количество букв в поле Ваш Отзыв';
            }
        } else {
            $errors['review-text'] = 'Заполните поле Ваш Отзыв';
        }
        return $errors;
    }

    private function addProductValidate(array $data): array
    {
        $errors = [];
        //Валидация товара
        if (isset($data['product_id'])) {
            $productId = (int)$data['product_id'];

            $result = $this->modelProduct->getOneById($productId);

            if ($result === false) {
                $errors['product_id'] = 'Товар не существует';
            }
        } else {
            $errors['product_id'] = 'Заполните поле product_ID';
        }

        //Валидация количества
        if (isset($data['quantity'])) {
            $quantity = (int)$data['quantity'];

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
