<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Продукт и Отзывы</title>
</head>
<body>
<div class="container">
    <div class="product">
        <div class="product-details">
            <button class="product-button">
                <img
                        src="<?php if (isset($products)) echo $products->getImage(); ?>"
                        alt="Apple IPhone 14 PRO Max Gold"
                        class="product-image"
                />
            </button>
            <div class="product-info">
                <h1 class="product-title"><?php if (isset($products)) echo $products->getName(); ?></h1>
                <p class="product-description">
                    <?php if (isset($products)) echo $products->getDescription(); ?>
                </p>
                <p class="product-price">Цена: <?php if (isset($products)) echo '$' . $products->getPrice(); ?></p>
            </div>
        </div>
    </div>

    <div class="reviews-section">
        <h2>Отзывы о продукте</h2>
        <div class="review-form">
            <h3>Оставьте отзыв</h3>
            <form action="/reviews" method="post">
                <input type="hidden" name="product_id" value="<?php if (isset($products))echo $products->getId(); ?>">
                <div class="form-group">
                    <?php if (isset($errors['rating'])) echo $errors['rating']; ?>
                    <label for="rating">Оценка (1-5):</label>
                    <input type="number" name="rating" id="rating" min="1" max="5" required>
                </div>
                <div class="form-group">
                    <?php if (isset($errors['author'])) echo $errors['author']; ?>
                    <label for="author">Ваше имя:</label>
                    <input type="text" name="author" id="author" required>
                </div>
                <div class="form-group">
                    <?php if (isset($errors['review-text'])) echo $errors['review-text']; ?>
                    <label for="review-text">Ваш отзыв:</label>
                    <textarea name="review-text" id="review-text" rows="4" required></textarea>
                </div>

                <button type="submit">Отправить отзыв</button>
            </form>
        </div>

        <div class="reviews-list">
            <h3>Все отзывы</h3>
            <?php if (isset($reviews)) {
            foreach ($reviews as $review): ?>
            <div class="review">
                <p class="review-rating">Оценка: <?php if (isset($review)) echo $review->getRating(); ?></p>
                <p class="review-author">Автор: <?php if (isset($review)) echo $review->getAuthor(); ?></p>
                <p class="review-date">Дата: <?php if (isset($review)) echo $review->getDate(); ?></p>
                <p class="review-text"><?php if (isset($review)) echo $review->getReviewText(); ?></p>
            </div>
            <?php endforeach; } ?>

            <!-- Здесь могут быть добавлены другие отзывы -->
        </div>
    </div>
</div>
</body>
</html>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f8f8f8;
        margin: 0;
        padding: 0;
    }

    .container {
        max-width: 800px;
        margin: 20px auto;
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .product {
        margin-bottom: 40px;
    }

    .product-details {
        display: flex;
        align-items: center;
    }

    .product-button {
        background-color: transparent;
        border: none;
        cursor: pointer;
        padding: 0;
        margin-right: 20px;
    }

    .product-image {
        width: 150px;
        height: auto;
        border-radius: 8px;
    }

    .product-info {
        flex-grow: 1;
    }

    .product-title {
        font-size: 1.8em;
        margin: 0;
    }

    .product-description {
        margin: 10px 0;
    }

    .product-price {
        font-size: 1.2em;
        font-weight: bold;
        color: #d9534f;
    }

    .reviews-section {
        border-top: 1px solid #ccc;
        padding-top: 20px;
    }

    .review-form {
        margin-bottom: 20px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    label {
        display: block;
        margin-bottom: 5px;
    }

    input[type="number"],
    input[type="text"],
    textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    button[type="submit"] {
        background-color: #28a745;
        color: white;
        padding: 10px 15px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    button[type="submit"]:hover {
        background-color: #218838;
    }

    .reviews-list {
        margin-top: 20px;
    }

    .review {
        border: 1px solid #e0e0e0;
        border-radius: 5px;
        padding: 10px;
        margin-bottom: 10px;
    }

    .review-rating {
        font-weight: bold;
    }

    .review-author{
        color: black;

    }
    .review-date{
        color: red;
    }
    .review-text {
        margin: 5px 0;
        font-weight: 900;
    }

</style>