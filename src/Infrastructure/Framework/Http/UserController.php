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
        include __DIR__ . '/../View/user_form.php';
    }

    public function store(array $request): void
    {
        $name = $request['name'] ?? '';
        $email = $request['email'] ?? '';
        $user = $this->createUser->execute($name, $email);
        include __DIR__ . '/../View/user_created.php';
    }

    public function index(): void
    {
        $users = $this->listUsers->execute();
        include __DIR__ . '/../View/user_list.php';
    }
}
