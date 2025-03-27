<?php

namespace Request;

use Models\User;

class RegistrationRequest extends Request
{
    private $modelUser;

    public function __construct(array $body)
    {
        parent::__construct($body);
        $this->modelUser = new User();
    }

    public function getName(): string
    {
        return $this->body['name'];
    }

    public function getEmail(): string
    {
        return $this->body['email'];
    }

    public function getPassword(): string
    {
        return $this->body['password'];
    }

    public function validate(): array
    {
        $errors = [];

        //валидация имени
        if (isset($this->body['name'])) {
            $name = $this->body['name'];
            if (strlen($name) < 2 || strlen($name) > 50) {
                $errors['name'] = "Недопустимое количество букв в поле Name";
            }
        } else {
            $errors['name'] = 'Заполните поле Name';
        }

        //Валидация почты
        if (isset($this->body['email'])) {
            $email = $this->body['email'];
            if (strlen($email) < 3 || strlen($email) > 50) {
                $errors['email'] = 'Недопустимое количество букв в поле email';
            } else {
                $pos = strrpos($email, '@');
                if ($pos === false) {
                    $errors['email'] = 'Некоректно ведён поле email';
                } elseif (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $user = $this->modelUser->getByEmail($email); //ищем пользователя по email
                    if ($user) {
                        $errors['email'] = 'email уже существует';
                    }
                }
            }
        } else {
            $errors['email'] = 'Заполните поле email';
        }

        //Проверка на совпадение пароля
        if (isset($this->body['password'])) {
            $password = $this->body['password'];
            if (strlen($password) < 6 || strlen($password) > 20) {
                $errors['password'] = 'Недопустимое количество букв в поле password';
            }

            $pswRepeat = $this->body['psw-repeat'];
            if ($password !== $pswRepeat) {
                $errors['psw-repeat'] = 'Пароли не совпадают';
            }
        } else {
            $errors['password'] = 'Заполните поле Password';
        }
        return $errors;
    }
}