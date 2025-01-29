<?php

function Validate():array
{
    $errors = [];
//валидация имени
    if (isset($_GET['name'])) {
        $name = $_GET['name'];
        if (strlen($name) < 2 || strlen($name) > 50) {
            $errors['name'] = "Недопустимое количество букв в поле Name";
        } elseif (preg_match("/^[a-zA-Z0-9]+$/", $name)) {
            $errors['name'] = 'Некорректно ведён поле Name';
        }
    } else {
        $errors['name'] = 'Заполните поле Name';
    }

//Валидация почты
    if (isset($_GET['email'])) {
        $email = $_GET['email'];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Некоректно ведён поле email';
        } elseif (strlen($email) < 3 || strlen($email) > 50) {
            $errors['email'] = 'Недопустимое количество букв в поле email';
        }
    } else {
        $errors['email'] = 'Заполните поле email ';
    }

//валидация пароля
    if (isset($_GET['password'])) {
        $password = $_GET['password'];
        if (strlen($password) < 6 || strlen($password) > 20) {
            $errors['password'] = 'Недопустимое количество букв в поле password';
        }
    } else {
        $errors['password'] = 'Заполните поле password';
    }

//валидация повторнго пароля
    if (isset($_GET['psw-repeat'])) {
        $pswRepeat = $_GET['psw-repeat'];
        if ($password !== $pswRepeat) {
            $errors['psw-repeat'] = 'Пароли не совпадают';
        }
    } else {
        $errors['psw-repeat'] = 'Заполните поле Password Repeat';
    }
    return $errors;
}

$errors = Validate();

if (empty($errors)) {
    $name = $_GET['name'];
    $email = $_GET['email'];
    $password = $_GET['password'];

    $pdo = new PDO("pgsql:host=db;port=5432;dbname=postgres;", 'arsik', '0000');
    $statement = $pdo->prepare("INSERT INTO users(name, email, password) VALUES(:name, :email, :password)");
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $statement->execute(['name' => $name, 'email' => $email, 'password' => $hashedPassword]);
} else {
    require_once 'get_registration.php';
}




