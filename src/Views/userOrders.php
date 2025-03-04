<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Мои заказы</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <h1 class="title">Мои заказы</h1>

<!--    --><?php //if (isset($newUserOrders)) {
//    foreach ($newUserOrders as $newUserOrder): ?>
    <div class="customer-info">
        <h2>Информация о покупателе</h2>
        <p><strong>Email:</strong> <span id="email"><?php echo $newUserOrders->getEmail(); ?></span></p>
        <p><strong>Телефон:</strong> <span id="phone">+1 (234) 567-8901</span></p>
        <p><strong>Имя:</strong> <span id="name">Иван Петров</span></p>
        <p><strong>Адрес:</strong> <span id="address">Улица пример, 12</span></p>
        <p><strong>Город:</strong> <span id="city">Москва</span></p>
        <p><strong>Страна:</strong> <span id="country">Россия</span></p>
        <p><strong>Почтовый индекс:</strong> <span id="postal">123456</span></p>
    </div>
<!--    --><?php //endforeach; } ?>

    <div class="orders">
        <h2>Ваши заказы</h2>
        <div class="order">
            <img src="product1.jpg" alt="Название продукта" class="product-image">
            <div class="product-info">
                <h3 class="product-name">Название продукта 1</h3>
                <p class="product-description">Описание продукта 1. Это очень интересный товар.</p>
                <p class="product-price">Цена: <span>$29.99</span></p>
            </div>
        </div>

        <div class="order">
            <img src="product2.jpg" alt="Название продукта" class="product-image">
            <div class="product-info">
                <h3 class="product-name">Название продукта 2</h3>
                <p class="product-description">Описание продукта 2. Это тоже отличный выбор!</p>
                <p class="product-price">Цена: <span>$49.99</span></p>
            </div>
        </div>

        <!-- Добавьте больше заказов, если нужно -->
    </div>
</div>
</body>
</html>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
    }

    .container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
        background-color: #fff;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
    }

    .title {
        text-align: center;
        color: #333;
    }

    .customer-info {
        margin-bottom: 20px;
        border-bottom: 1px solid #ddd;
        padding-bottom: 20px;
    }

    .customer-info h2 {
        color: #333;
        margin-bottom: 10px;
    }

    .orders {
        margin-top: 20px;
    }

    .order {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
        border: 1px solid #ddd;
        padding: 10px;
        border-radius: 8px;
        background-color: #f9f9f9;
    }

    .product-image {
        width: 100px;
        height: auto;
        border-radius: 4px;
        margin-right: 15px;
    }

    .product-info {
        flex-grow: 1;
    }

    .product-name {
        font-size: 18px;
        margin: 0;
        color: #2c3e50;
    }

    .product-description {
        color: #7f8c8d;
    }

    .product-price {
        font-weight: bold;
        color: #e67e22;
    }
</style>
