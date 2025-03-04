<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Мои заказы</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<header>
    <h1>Мои заказы</h1>
</header>
<main>
    <section class="order-list">
        <h2>Список заказов</h2>
        <ul>
            <?php if (isset($userOrders)) {
            foreach ($userOrders as $userOrder): ?>
            <li>
                <form action="/userOrders" method="post">
                <div class="order-item">
<!--                  <input name="id" type="hidden"> <a href="/userOrders"> <span>Заказ --><?php //echo '#' . $userOrder->getId(); ?><!--</span></a>-->
                    <input type="hidden" name="id" value="<?php echo $userOrder->getId(); ?>">
                    <button>Заказ <?php echo '#' . $userOrder->getId(); ?></button>
                    <span class="status">Выполнен</span>
                </div>
                </form>
            </li>
            <?php endforeach; } ?>
        </ul>
    </section>
</main>
<footer>
    <p>&copy; 2023 Моя компания</p>
</footer>
</body>
</html>

<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f4;
        color: #333;
    }

    header {
        background-color: #4CAF50;
        color: white;
        padding: 20px;
        text-align: center;
    }

    main {
        padding: 20px;
    }

    .order-list {
        background-color: white;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .order-list h2 {
        margin-top: 0;
    }

    ul {
        list-style-type: none;
        padding: 0;
    }

    .order-item {
        display: flex;
        justify-content: space-between;
        padding: 10px;
        border-bottom: 1px solid #ddd;
    }

    .order-item:last-child {
        border-bottom: none;
    }

    .status {
        font-weight: bold;
    }

    .status:nth-child(2) {
        color: orange; /* В процессе */
    }

    .status:nth-child(3) {
        color: red; /* Отменен */
    }

    footer {
        text-align: center;
        padding: 10px;
        background-color: #4CAF50;
        color: white;
        position: fixed;
        bottom: 0;
        width: 100%;
    }

</style>
