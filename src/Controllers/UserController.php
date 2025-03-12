<?php

namespace Controllers;

use Models\User;
use Request\EditProfileRequest;
use Request\LoginRequest;
use Request\RegistrationRequest;
use Service\AuthService;

class UserController
{
    private User $modelUser;
    private AuthService $authService;

    public function __construct()
    {
        $this->modelUser = new User();
        $this->authService = new AuthService();
    }

    public function getRegistrationForm(): void
    {
        require_once '../Views/registration.php';
    }

    public function getLoginForm(): void
    {
        require_once '../Views/login.php';
    }

    public function myProfileForm(): void
    {
        if (!$this->authService->check()) {
            header("Location: /login");
            exit();
        }
        $user = $this->authService->getCurrentUser(); //проверяем пользователя по ID
        require_once '../Views/my_profile.php';
    }

    public function getEditProfileForm(): void
    {

        if (!$this->authService->check()) {
            header("Location: /login");
            exit();
        }
        require_once '../Views/edit_profile.php';
    }

    public function registrate(RegistrationRequest $request): void
    {
        $errors = $request->validate();

        if (empty($errors)) {
            $this->modelUser->create($request->getName(), $request->getEmail(), $request->getPassword()); //Добавляем пользователя

            header("Location: /login");
            exit();
        } else {
            require_once '../Views/registration.php';
        }
    }

    public function login(LoginRequest $request): void
    {
        $errors = $request->validate();

        if (empty($errors)) {
            $result = $this->authService->auth($request->getEmail(), $request->getPassword());

            if ($result === true) {
                header("Location: /main");
                exit();
            } else {
                $errors['email'] = 'Логин или пароль указаны неверно';
            }
        }
        // Отображение формы логина с ошибками
        require_once '../Views/login.php';
    }

    public function editProfile(EditProfileRequest $request): void
    {
        $errors = $request->validate();

        if (empty($errors)) {
            $user = $this->authService->getCurrentUser();
            $userId = $user->getId();

            $result = $this->modelUser->getByEmail($request->getEmail()); // Проверяем пользователя по email

            if (!$result) {
                $this->modelUser->update($request->getName(), $request->getEmail(), $request->getPassword(), $userId); // Редактируем существующего пользователя
                header("Location: /edit_profile");
            }
        }
        require_once '../Views/edit_profile.php';
    }

    public function logout(): void
    {
        $this->authService->logout();
        header("Location: /login");
        exit();
    }
}
