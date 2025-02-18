<?php

require_once 'Models/Database.php';

class User extends Database
{
    public int $id;
    public string $name;
    public string $email;
    public string $password;

    public function create($name, $email, $password): void
    {
        $statement = $this->getPdo()->prepare("INSERT INTO users(name, email, password) VALUES(:name, :email, :password)");
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $statement->execute(['name' => $name, 'email' => $email, 'password' => $hashedPassword]);
    }

    public function getByEmail($email): array|false
    {
        $stmt = $this->getPdo()->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);

        return $stmt->fetch();
    }

    public function getById(int $user): array|false
    {
        $statement = $this->getPdo()->prepare("SELECT * FROM users WHERE id = :user_id");
        $statement->execute(['user_id' => $user]);

        return $statement->fetchAll();
    }

    public function update($name, $email, $password, $userId): void
    {
        $stmt = $this->getPdo()->prepare("UPDATE users SET name = :name, email = :email, password = :password WHERE id = :user_id");
        $hashPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt->execute(['name' => $name, 'email' => $email, 'password' => $hashPassword, 'user_id' => $userId]);
    }

}