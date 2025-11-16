<?php

namespace Domain\Repository;

use Domain\Entity\User;

interface UserRepositoryInterface
{
    public function save(User $user): void;
    public function findAll(): array; // devuelve array<User>
    public function findById(int $id): ?User;
    public function findByEmail(string $email): ?User;
}
