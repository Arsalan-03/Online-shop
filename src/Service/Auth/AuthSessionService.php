<?php

namespace Service\Auth;

use Models\User;

class AuthSessionService implements AuthInterface
{
    protected User $modelUser;

    public function __construct()
    {
        $this->modelUser = new User();
    }

    public function check(): bool
    {
        $this->startSession();
        return isset($_SESSION['user_id']);
    }

    public function getCurrentUser(): ?User
    {
        $this->startSession();

        if ($this->check()) {
            $userId = $_SESSION['user_id'];

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
                $this->startSession();
                $_SESSION['user_id'] = $user->getId();
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
        $this->startSession();
        session_destroy();
    }

    private function startSession(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }
}