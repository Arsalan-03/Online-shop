<?php

namespace DTO;

use Models\User;

class OrderCreateDTO
{
    public function __construct(
        private string        $email,
        private string        $phone,
        private string        $name,
        private string        $address,
        private string        $city,
        private string        $country,
        private int           $postal,
    ){
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function getPostal(): int
    {
        return $this->postal;
    }
}