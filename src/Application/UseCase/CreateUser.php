<?php

namespace Application\UseCase;

use Domain\Repository\UserRepositoryInterface;
use Domain\Entity\User;

class CreateUser
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(string $name, string $email, string $password): User
    {
        // Aquí podrías añadir validaciones del caso de uso
        // Hashear la contraseña antes de crear la entidad
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $user = new User($name, $email, null, null, $hash);
        $this->userRepository->save($user);
        return $user;
    }
}
