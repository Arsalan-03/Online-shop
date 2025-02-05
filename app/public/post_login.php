<?php
function Validate(array $data): array
{
    $errors = [];

    if (!isset($data['login'])) {
        $errors['login'] = 'Заполните поле login';
    }

    if (!isset($data['password'])) {
        $errors['password'] = 'Заполните поле password';
    }

    return $errors;
}
 $errors=Validate($_POST);

if (empty($errors)) {
    $login = $_POST['login'];
    $password = $_POST['password'];

    $pdo = new PDO("pgsql:host=db;port=5432;dbname=postgres;", 'arsik', '0000');
    $statement = $pdo->prepare("SELECT * FROM users WHERE email = :login");
    $statement->execute(['login' => $login]);
    $data = $statement->fetch();

    if ($data === false) {
        $errors['login'] = 'Логин или пароль указаны неверно';
    } else {
        $passwordFromDb = $data['password'];
        if (password_verify($password, $passwordFromDb)) {
            session_start();
            $_SESSION['user_id'] = $data['id'];
            header("Location: /product.php");
        } else {
            $errors['login'] = 'Логин или пароль указаны неверно';
        }
    }
}
require_once 'get_login.php';