<?php

class Order extends Model
{

    public function create(string $email, string $name, string $phone, string $address, string $city, string $country, int $postal)
    {
        $statement = $this->getPdo()->prepare("INSERT INTO orders (email, phone, name, address, city, country, postal) 
                                                VALUES (:email, :phone, :name, :address, :city, :country, :postal)");
        $statement->execute(['email' => $email, 'phone' => $phone, 'name' => $name, 'address' => $address, 'city' => $city, 'country' => $country, 'postal' => $postal]);
    }
}