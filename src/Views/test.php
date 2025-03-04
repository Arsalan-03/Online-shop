<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Мои Заказы</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <h1>Мои Заказы</h1>
    <table>
        <thead>
        <tr>
            <th>Заказ №</th>
            <th>ФИО покупателя</th>
            <th>Номер телефона</th>
            <th>Адрес</th>
            <th>Наименование продукта</th>
            <th>Количество</th>
            <th>Цена</th>
            <th>Сумма</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td rowspan="3">001</td>
            <td rowspan="3">Иванов Иван Иванович</td>
            <td rowspan="3">+7 (999) 123-45-67</td>
            <td rowspan="3">г. Москва, ул. Ленина, д. 1</td>
            <td>Хлеб</td>
            <td>2</td>
            <td>50 Р.</td>
            <td>100 Р.</td>
        </tr>
        <tr>
            <td>Молоко</td>
            <td>1</td>
            <td>70 Р.</td>
            <td>70 Р.</td>
        </tr>
        <tr>
            <td>Яблоки</td>
            <td>3</td>
            <td>30 Р.</td>
            <td>90 Р.</td>
        </tr>
        <tr>
            <td colspan="7" class="total">Итоговая сумма:</td>
            <td class="total-value">260 Р.</td>
        </tr>

        <tr>
            <td rowspan="2">002</td>
            <td rowspan="2">Петров Петр Петрович</td>
            <td rowspan="2">+7 (999) 234-56-78</td>
            <td rowspan="2">г. Санкт-Петербург, ул. Пушкина, д. 2</td>
            <td>Кофе</td>
            <td>1</td>
            <td>150 Р.</td>
            <td>150 Р.</td>
        </tr>
        <tr>
            <td>Сахар</td>
            <td>1</td>
            <td>20 Р.</td>
            <td>20 Р.</td>
        </tr>
        <tr>
            <td colspan="7" class="total">Итоговая сумма:</td>
            <td class="total-value">170 Р.</td>
        </tr>
        </tbody>
    </table>
</div>
</body>
</html>

<style>
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        font-family: 'Arial', sans-serif;
        background-color: #f4f4f4;
    }

    .container {
        max-width: 1200px;
        margin: 40px auto;
        background: #fff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    h1 {
        text-align: center;
        margin-bottom: 20px;
        color: #333;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th, td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #007bff;
        color: white;
    }

    tbody tr:hover {
        background-color: #f1f1f1;
    }

    .total {
        font-weight: bold;
        font-size: 1.1em;
    }

    .total-value {
        font-weight: bold;
        color: #d9534f; /* Красный цвет для итоговой суммы */
    }
</style>
