<?php

namespace Service\Auth;

use Models\User;

interface AuthInterface
{
    public function check(): bool;

    public function getCurrentUser(): ?User;

    public function auth(string $email, string $password): bool;

    public function logout(): void;
}