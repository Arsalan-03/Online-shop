<?php
namespace Models;

class Order extends Model
{
    private int $id;
    private int $userId;
    private string $email;
    private string $phone;
    private string $name;
    private string $address;
    private string $city;
    private string $country;
    private int $postal;


    public function create(int $userId, string $email, string $name, string $phone, string $address, string $city, string $country, int $postal)
    {
        $statement = $this->getPdo()->prepare(
            "INSERT INTO orders (user_id, email, phone, name, address, city, country, postal) 
                    VALUES (:user_id, :email, :phone, :name, :address, :city, :country, :postal) RETURNING id"
        );
        $statement->execute([
            'user_id' => $userId,
            'email' => $email,
            'phone' => $phone,
            'name' => $name,
            'address' => $address,
            'city' => $city,
            'country' => $country,
            'postal' => $postal
        ]);

       $data = $statement->fetch();
       return $data['id'];
    }

    public function getAllByUserId(int $userId): array
    {
        $statement = $this->getPdo()->prepare(
            "SELECT * FROM orders WHERE user_id = :user_id");
        $statement->execute(['user_id' => $userId]);
        $results = $statement->fetchAll();

        $allOrders = [];
        foreach ($results as $result) {
            $allOrders[] = $this->hydrate($result);
        }

        return $allOrders;
    }

    public function getByIdAndUserId(int $orderId, int $userId): Order|false
    {
        $statement = $this->getPdo()->prepare("SELECT * FROM orders WHERE id = :orderId AND user_id = :userId");
        $statement->execute(['orderId' => $orderId, 'userId' => $userId]);
        $result = $statement->fetch();

        if (!$result) {
            return false;
        }
        return $this->hydrate($result);
    }

    private function hydrate(array $data): self|null
    {
        if (!$data)
        {
            return null;
        }
        $obj = new self();
        $obj->id = $data['id'];
        $obj->userId = $data['user_id'];
        $obj->email = $data['email'];
        $obj->name = $data['name'];
        $obj->phone = $data['phone'];
        $obj->address = $data['address'];
        $obj->city = $data['city'];
        $obj->country = $data['country'];
        $obj->postal = $data['postal'];
        return $obj;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
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