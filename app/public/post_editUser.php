<?php
function Validate(array $data): array
{
    $errors = [];
    //валидация имени
    if (isset($data['name'])) {
        $name = $data['name'];
        if (strlen($name) < 2 || strlen($name) > 50) {
            $errors['name'] = "Недопустимое количество букв в поле Name";
        }
    } else {
        $errors['name'] = 'Заполните поле Name';
    }

//Валидация почты
    if (isset($data['email'])) {
        $email = $data['email'];
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

//Валидация пароля
    if (isset($data['password'])) {
        $password = $data['password'];
        if (strlen($password) < 6 || strlen($password) > 20) {
            $errors['password'] = 'Недопустимое количество букв в поле password';
        }
    } else {
        $errors['password'] = 'Заполните поле Password';
    }
    return $errors;
}

$errors = Validate($_POST);

if (empty($errors)) {
    session_start();
    $userId = $_SESSION['user_id'];

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $pdo = new PDO("pgsql:host=db;port=5432;dbname=postgres;", 'arsik', '0000');
    $stmt = $pdo->prepare("UPDATE users SET name = :name, email = :email, password = :password WHERE id = :user_id");
    $hashPassword = password_hash($password, PASSWORD_DEFAULT);
    $stmt->execute(['name' => $name, 'email' => $email, 'password' => $hashPassword, 'user_id' => $userId]);

    header("Location: /handle_profile.php");
}