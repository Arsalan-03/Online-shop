<?php

namespace Request;

class EditProfileRequest extends Request
{

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
            if (strlen($name) < 2 || strlen($name) > 200) {
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
                }
            }
        } else {
            $errors['email'] = 'Заполните поле email';
        }

//Валидация пароля
        if (isset($this->body['password'])) {
            $password = $this->body['password'];
            if (strlen($password) < 6 || strlen($password) > 20) {
                $errors['password'] = 'Недопустимое количество букв в поле password';
            }
        } else {
            $errors['password'] = 'Заполните поле Password';
        }
        return $errors;
    }
}