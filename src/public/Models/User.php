<?php


class User
{
    public function create($name, $email, $password): void
    {
        $pdo = new PDO("pgsql:host=db;port=5432;dbname=postgres;", 'arsik', '0000');
        $statement = $pdo->prepare("INSERT INTO users(name, email, password) VALUES(:name, :email, :password)");
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $statement->execute(['name' => $name, 'email' => $email, 'password' => $hashedPassword]);
    }

    public function getByEmail($email): array|false
    {
        $pdo = new PDO("pgsql:host=db;port=5432;dbname=postgres;", 'arsik', '0000');
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);

        return $stmt->fetch();
    }

    public function getById(int $user): array|false
    {
        $pdo = new PDO("pgsql:host=db;port=5432;dbname=postgres;", 'arsik', '0000');
        $statement = $pdo->prepare("SELECT * FROM users WHERE id = :user_id");
        $statement->execute(['user_id' => $user]);

        return $statement->fetchAll();
    }

    public function update($name, $email, $password, $userId): void
    {
        $pdo = new PDO("pgsql:host=db;port=5432;dbname=postgres;", 'arsik', '0000');
        $stmt = $pdo->prepare("UPDATE users SET name = :name, email = :email, password = :password WHERE id = :user_id");
        $hashPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt->execute(['name' => $name, 'email' => $email, 'password' => $hashPassword, 'user_id' => $userId]);
    }

}