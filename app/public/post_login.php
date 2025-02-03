<?php
$errors = [];

if (isset($_POST['login'])) {
    $login = $_POST['login'];
} else {
    $errors['login'] = 'Заполните поле login';
}

if (isset($_POST['password'])) {
    $password = $_POST['password'];
} else {
    $errors['password'] = 'Заполните поле password';
}

if (empty($errors)) {
    $pdo = new PDO("pgsql:host=db;port=5432;dbname=postgres;", 'arsik', '0000');
    $statement = $pdo->prepare("SELECT * FROM users WHERE email = :login");
    $statement->execute(['login' => $login]);
    $data = $statement->fetch();

    if ($data === false) {
        $errors['login'] = 'Логин или пароль указаны неверно';
    } else {
        $passwordFromDb = $data['password'];
        if (password_verify($password, $passwordFromDb)) {
            setcookie('user_id', $data['id']);
//            session_start();
//            $_SESSION['user_id'] = $data['id'];
            header("Location: /main.php");
        } else {
            $errors['login'] = 'Логин или пароль указаны неверно';
        }
    }
}
require_once 'get_login.php';