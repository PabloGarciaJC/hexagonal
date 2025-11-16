<?php

namespace Infrastructure\Framework\Http;

use Application\UseCase\CreateUser;
use Application\UseCase\ListUsers;

class UserController
{
    private CreateUser $createUser;
    private ListUsers $listUsers;

    public function __construct(CreateUser $createUser, ListUsers $listUsers)
    {
        $this->createUser = $createUser;
        $this->listUsers = $listUsers;
    }

    public function form(): void
    {
        // Mostrar formulario de registro (no protegido)
        include __DIR__ . '/../View/user_form.php';
    }

    public function store(array $request): void
    {
        $name = $request['name'] ?? '';
        $email = $request['email'] ?? '';
        $password = $request['password'] ?? '';
        $user = $this->createUser->execute($name, $email, $password);
        include __DIR__ . '/../View/user_created.php';
    }

    public function index(): void
    {
        // Proteger ruta: requiere sesión
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (empty($_SESSION['user_id'])) {
            header('Location: /?login=form');
            exit;
        }

        $users = $this->listUsers->execute();
        include __DIR__ . '/../View/user_list.php';
    }
}
