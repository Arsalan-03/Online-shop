<?php

namespace Service\Auth;

use Models\User;

class AuthCookieService implements AuthInterface
{
    private User $modelUser;
    public function __construct()
    {
        $this->modelUser = new User();
    }

    public function check(): bool
    {
        return isset($_COOKIE['user_id']);
    }

    public function getCurrentUser(): ?User
    {
        if ($this->check()) {
            $userId = $_COOKIE['user_id'];

            return $this->modelUser->getById($userId);
        } else {
            return null;
        }
    }

    public function auth(string $email, string $password): bool
    {
        $user = $this->modelUser->getByEmail($email); //проверяем пользователя по email

        if ($user) {
            $passwordFromDb = $user->getPassword();
            if (password_verify($password, $passwordFromDb)) {
                setcookie("user_id", $user->getId(), time() + (86400 * 30), "/");
                $_COOKIE['user_id'] = $user->getId();
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function logout(): void
    {
        setcookie('user_id', "", time() - (86400 * 30), "/");
        unset($_COOKIE['user_id']);
    }
}