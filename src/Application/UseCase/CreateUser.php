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

    public function execute(string $name, string $email): User
    {
        // Aquí podrías añadir validaciones del caso de uso
        $user = new User($name, $email);
        $this->userRepository->save($user);
        return $user;
    }
}
