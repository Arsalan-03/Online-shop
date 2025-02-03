<?php
function Validate():array
{
    $errors = [];

//валидация имени
    if (isset($_POST['name'])) {
        $name = $_POST['name'];
        if (strlen($name) < 2 || strlen($name) > 50) {
            $errors['name'] = "Недопустимое количество букв в поле Name";
        }
    } else {
        $errors['name'] = 'Заполните поле Name';
    }

//Валидация почты
    if (isset($_POST['email'])) {
        $email = $_POST['email'];
        if (strlen($email) < 3 || strlen($email) > 50) {
            $errors['email'] = 'Недопустимое количество букв в поле email';
        } else {
            $pos = strrpos($email, '@');
            if ($pos === false) {
                $errors['email'] = 'Некоректно ведён поле email';
            } elseif (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $pdo = new PDO("pgsql:host=db;port=5432;dbname=postgres;", 'arsik', '0000');
                $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
                $stmt->execute(['email' => $email]);
                $result = $stmt->fetch();
                if ($result) {
                    $errors['email'] = 'email уже существует';
                }
            }
        }
    } else {
        $errors['email'] = 'Заполните поле email';
    }

//валидация пароля
    if (isset($_POST['password'])) {
        $password = $_POST['password'];
        if (strlen($password) < 6 || strlen($password) > 20) {
            $errors['password'] = 'Недопустимое количество букв в поле password';
        }
    } else {
        $errors['password'] = 'Заполните поле password';
    }

//валидация повторнго пароля
    if (isset($_POST['psw-repeat'])) {
        $pswRepeat = $_POST['psw-repeat'];
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
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $pdo = new PDO("pgsql:host=db;port=5432;dbname=postgres;", 'arsik', '0000');
    $statement = $pdo->prepare("INSERT INTO users(name, email, password) VALUES(:name, :email, :password)");
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $statement->execute(['name' => $name, 'email' => $email, 'password' => $hashedPassword]);
    header("Location: /get_login.php");

} else {
    require_once 'get_registration.php';
}




