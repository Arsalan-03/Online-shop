<?php
namespace Models;
class User extends Model
{
    public int $id;
    public string $name;
    public string $email;
    public string $password;

    protected function getTableName(): string
    {
        return 'users';
    }

    public function create($name, $email, $password): void
    {
        $statement = $this->getPdo()->prepare(
            "INSERT INTO {$this->getTableName()}(name, email, password) VALUES(:name, :email, :password)"
        );
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $statement->execute([
            'name' => $name,
            'email' => $email,
            'password' => $hashedPassword,
        ]);
    }

    public function getByEmail(string $email): self|false
    {
        $stmt = $this->getPdo()->prepare("SELECT * FROM {$this->getTableName()} WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();
        if ($user){
            return $this->hydrate($user);
        }
        return false;
    }

    public function getById(int $userId): self|null
    {
        $statement = $this->getPdo()->prepare("SELECT * FROM {$this->getTableName()} WHERE id = :user_id");
        $statement->execute(['user_id' => $userId]);
        $user = $statement->fetch();

        return $this->hydrate($user);
    }

    public function update($name, $email, $password, $userId): void
    {
        $stmt = $this->getPdo()->prepare(
            "UPDATE {$this->getTableName()} SET name = :name, email = :email, password = :password WHERE id = :user_id"
        );
        $hashPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt->execute([
            'name' => $name,
            'email' => $email,
            'password' => $hashPassword,
            'user_id' => $userId
        ]);
    }

    private function hydrate(array $user): self|null
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