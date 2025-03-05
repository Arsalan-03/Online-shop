<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Мои заказы</title>
</head>
<body>
<div class="container">
    <h1>Мои заказы</h1>

    <div class="customer-info">
        <h2>Данные покупателя</h2>
        <p><strong>Email:</strong><?php if (isset($userOrders)) echo $userOrders->getEmail(); ?></p>
        <p><strong>Телефон:</strong><?php if (isset($userOrders)) echo $userOrders->getPhone(); ?></p>
        <p><strong>Имя:</strong> <?php if (isset($userOrders)) echo $userOrders->getName(); ?></p>
        <p><strong>Адрес:</strong> <?php if (isset($userOrders)) echo $userOrders->getAddress(); ?></p>
        <p><strong>Город:</strong> <?php if (isset($userOrders)) echo $userOrders->getCity(); ?></p>
        <p><strong>Страна:</strong> <?php if (isset($userOrders)) echo $userOrders->getCountry(); ?></p>
        <p><strong>Почтовый индекс:</strong> <?php if (isset($userOrders)) echo $userOrders->getPostal(); ?></p>
    </div>

    <div class="order-items">
        <h2>Заказанные продукты</h2>
        <table>
            <thead>
            <tr>
                <th>Изображение</th>
                <th>Название</th>
                <th>Цена</th>
                <th>Количество</th>
            </tr>
            </thead>
            <?php if (isset($newOrderProducts)) {
            foreach ($newOrderProducts as $newOrderProduct): ?>
            <tbody>
            <tr>
                <td><img src="<?php if (isset($newOrderProduct)) echo $newOrderProduct->getProduct()->getImage(); ?>" alt="Продукт 1"></td>
                <td><?php if (isset($newOrderProduct)) echo $newOrderProduct->getProduct()->getName(); ?></td>
                <td><?php if (isset($newOrderProduct)) echo '$' . $newOrderProduct->getProduct()->getPrice(); ?></td>
                <td><?php if (isset($newOrderProduct)) echo $newOrderProduct->getQuantity(); ?></td>
            </tr>
            </tbody>
            <?php endforeach; } ?>
        </table>
        <div class="total-price">
            <h3>Общая цена: <?php
                $totalPrice = 0;
                foreach ($newOrderProducts as $newOrderProduct) {
                    $totalPrice += $newOrderProduct->getProduct()->getPrice() * $newOrderProduct->getQuantity();
                }
                echo "$" . $totalPrice;
                ?></h3>
        </div>
    </div>
</div>
</body>
</html>

<style>
    body {
        font-family: Arial, sans-serif;
        line-height: 1.6;
        margin: 0;
        padding: 20px;
        background-color: #f4f4f4;
    }

    .container {
        max-width: 800px;
        margin: 0 auto;
        background: #fff;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    h1 {
        text-align: center;
        color: #333;
    }

    .customer-info {
        margin-bottom: 20px;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        background-color: #f9f9f9;
    }

    .order-items table {
        width: 100%;
        border-collapse: collapse;
    }

    .order-items th, .order-items td {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: left;
    }

    .order-items th {
        background-color: #f2f2f2;
    }

    .order-items img {
        width: 50px;
        height: auto;
    }

    .total-price {
        margin-top: 20px;
        text-align: right; /* Выравнивание общей цены вправо */
        font-weight: bold;
        font-size: 1.2em; /* Увеличение размера шрифта для общей цены */
    }

</style>
