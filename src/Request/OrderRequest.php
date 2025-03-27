<?php

namespace Request;

class OrderRequest extends Request
{
    public function getEmail(): string
    {
        return $this->body['email'];
    }
    public function getPhone(): string
    {
        return $this->body['phone'];
    }
    public function getName(): string
    {
        return $this->body['name'];
    }
    public function getAddress(): string
    {
        return $this->body['address'];
    }
    public function getCity(): string
    {
        return $this->body['city'];
    }
    public function getCountry(): string
    {
        return $this->body['country'];
    }
    public function getPostal(): int
    {
        return $this->body['postalCode'];
    }
    public function validate(): array
    {
        $errors = [];

        // Валидация email
        if (isset($this->body['email'])) {
        } elseif (!filter_var($this->body['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Неправильный формат email.';
        } else {
            $errors['email'] = 'Email является обязательным полем.';
        }

        // Валидация телефона
        if (isset($this->body['phone'])) {
        } elseif (!preg_match('/^\+?[0-9]{10,15}$/', $this->body['phone'])) {
            $errors['phone'] = 'Неправильный формат телефона. Убедитесь, что номер состоит из 10-15 цифр, возможно, с начальным знаком "плюс".';
        } else {
            $errors['phone'] = 'Телефон является обязательным полем.';
        }

        // Валидация полного имени
        if (isset($this->body['name'])) {
        } elseif (strlen($this->body['name']) < 3) {
            $errors['name'] = 'Полное имя должно содержать как минимум 3 символа.';
        } else {
            $errors['name'] = 'Полное имя является обязательным полем.';
        }

        // Валидация адреса
        if (isset($this->body['address'])) {
        } else {
            $errors['address'] = 'Адрес является обязательным полем.';
        }

        // Валидация города
        if (isset($this->body['city'])) {
        } else {
            $errors['city'] = 'Город является обязательным полем.';
        }

        // Валидация страны
        if (isset($this->body['country'])) {
        } else {
            $errors['country'] = 'Страна является обязательным полем.';
        }

        // Валидация почтового индекса
        if (isset($this->body['postalCode'])) {
        } elseif (!preg_match('/^[0-9]{5,10}$/', $this->body['postalCode'])) {
            $errors['postalCode'] = 'Неправильный формат почтового индекса. Убедитесь, что он состоит из 5-10 цифр.';
        } else {
            $errors['postalCode'] = 'Почтовый индекс является обязательным полем.';
        }

        return $errors;
    }
}