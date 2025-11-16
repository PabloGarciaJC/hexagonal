<?php

namespace Infrastructure\Framework\Http;

use Domain\Repository\UserRepositoryInterface;

class AuthController
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function showLoginForm(): void
    {
        include __DIR__ . '/../View/login_form.php';
    }

    public function login(array $request): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $email = $request['email'] ?? '';
        $password = $request['password'] ?? '';

        $user = $this->userRepository->findByEmail($email);
        if (!$user) {
            // login fallido
            $error = 'Usuario o contraseña incorrectos';
            include __DIR__ . '/../View/login_form.php';
            return;
        }

        if (!password_verify($password, $user->getPasswordHash() ?? '')) {
            $error = 'Usuario o contraseña incorrectos';
            include __DIR__ . '/../View/login_form.php';
            return;
        }

        // autenticar
        $_SESSION['user_id'] = $user->getId();
        // almacenar nombre para mostrar en el header
        $_SESSION['user_name'] = $user->getName();
        header('Location: /?list=listar');
        exit;
    }

    public function logout(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        // eliminar datos de sesión
        unset($_SESSION['user_id']);
        unset($_SESSION['user_name']);
        session_unset();
        session_destroy();
        header('Location: /');
        exit;
    }
}
