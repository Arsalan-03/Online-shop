<?php

class UserController
{
    private User $modelUser;

    public function __construct()
    {
        $this->modelUser = new User();
    }

    public function getRegistrationForm(): void
    {
        require_once '../Views/registration.php';
    }

    public function registrate(): void
    {
        $errors = $this->RegValidate($_POST);

        if (empty($errors)) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            $this->modelUser->create($name, $email, $password); //Добавляем пользователя

            header("Location: /login");
            exit();
        } else {
            require_once '../Views/registration.php';
        }
    }

    private function regValidate(array $data): array
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

                    $result = $this->modelUser->getByEmail($email); //ищем пользователя по email

                    if ($result) {
                        $errors['email'] = 'email уже существует';
                    }
                }
            }
        } else {
            $errors['email'] = 'Заполните поле email';
        }

        //Проверка на совпадение пароля
        if (isset($data['password'])) {
            $password = $data['password'];
            if (strlen($password) < 6 || strlen($password) > 20) {
                $errors['password'] = 'Недопустимое количество букв в поле password';
            }

            $pswRepeat = $data['psw-repeat'];
            if ($password !== $pswRepeat) {
                $errors['psw-repeat'] = 'Пароли не совпадают';
            }
        } else {
            $errors['password'] = 'Заполните поле Password';
        }
        return $errors;
    }

    public function getLoginForm()
    {
        require_once '../Views/login.php';
    }

    public function login(): void
    {
        $errors = $this->logValidate($_POST);

        if (empty($errors)) {
            $login = $_POST['email'];
            $password = $_POST['password'];

            $data = $this->modelUser->getByEmail($login); //проверяем пользователя по email

            if ($data === false) {
                $errors['email'] = 'Логин или пароль указаны неверно';
            } else {
                $passwordFromDb = $data['password'];
                if (password_verify($password, $passwordFromDb)) {
                    session_start();
                    $_SESSION['user_id'] = $data['id'];

                    header("Location: /main");
                } else {
                    $errors['email'] = 'Логин или пароль указаны неверно';
                }
            }
        }
        require_once '../Views/login.php';
    }

    private function logValidate(array $data): array
    {
        $errors = [];

        if (!isset($data['email'])) {
            $errors['email'] = 'Заполните поле login';
        }

        if (!isset($data['password'])) {
            $errors['email'] = 'Заполните поле password';
        }

        return $errors;
    }

    public function myProfile(): void
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login.php");
        }

        $user = $_SESSION['user_id'];

        $profileUsers = $this->modelUser->getById($user); //проверяем пользователя по ID

        require_once '../Views/my_profile.php';
    }

    public function getEditProfileForm(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit();
        }
        require_once '../Views/edit_profile.php';
    }

    public function editProfile(): void
    {
        $errors = $this->editProfileValidate($_POST);

        if (empty($errors)) {
            session_start();
            $userId = $_SESSION['user_id'];

            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            $result = $this->modelUser->getByEmail($email); // Проверяем пользователя по email

            if (!$result) {

                $this->modelUser->update($name, $email, $password, $userId); // Редактируем существующего пользователя
                header("Location: /edit_profile");
            }
        }

        require_once '../Views/edit_profile.php';
    }

    private function editProfileValidate(array $data): array
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

    public function logout(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();

            session_destroy();
            header("Location: /login");
            exit();
        }
    }
}
