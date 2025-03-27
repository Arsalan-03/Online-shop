<?php

namespace Request;

class LoginRequest extends Request
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

        if (!isset($this->body['email'])) {
            $errors['email'] = 'Заполните поле login';
        }

        if (!isset($this->body['password'])) {
            $errors['email'] = 'Заполните поле password';
        }

        return $errors;
    }
}