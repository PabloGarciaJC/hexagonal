<?php
namespace Application\UseCase;

use Domain\Repository\UserRepositoryInterface;

class ListUsers
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(): array
    {
        return $this->userRepository->findAll();
    }
}
