<?php
namespace Models;
class User extends Model
{
    public int $id;
    public string $name;
    public string $email;
    public string $password;

    protected static function getTableName(): string
    {
        return 'users';
    }

    public static function create($name, $email, $password): void
    {
        $tableName = static::getTableName();
        $statement = static::getPdo()->prepare(
            "INSERT INTO $tableName (name, email, password) VALUES(:name, :email, :password)"
        );
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $statement->execute([
            'name' => $name,
            'email' => $email,
            'password' => $hashedPassword,
        ]);
    }

    public static function getByEmail(string $email): self|false
    {
        $tableName = static::getTableName();
        $stmt = static::getPdo()->prepare("SELECT * FROM $tableName WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();
        if ($user){
            return static::hydrate($user);
        }
        return false;
    }

    public static function getById(int $userId): self|null
    {
        $tableName = static::getTableName();
        $statement = static::getPdo()->prepare("SELECT * FROM $tableName WHERE id = :user_id");
        $statement->execute(['user_id' => $userId]);
        $user = $statement->fetch();

        return static::hydrate($user);
    }

    public static function update($name, $email, $password, $userId): void
    {
        $tableName = static::getTableName();
        $stmt = static::getPdo()->prepare(
            "UPDATE $tableName SET name = :name, email = :email, password = :password WHERE id = :user_id"
        );
        $hashPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt->execute([
            'name' => $name,
            'email' => $email,
            'password' => $hashPassword,
            'user_id' => $userId
        ]);
    }

    private static function hydrate(array $user): self|null
    {
        if (!$user)
        {
            return null;
        }

        $obj = new self();
        $obj->id = $user['id'];
        $obj->name = $user['name'];
        $obj->email = $user['email'];
        $obj->password = $user['password'];

        return $obj;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

}