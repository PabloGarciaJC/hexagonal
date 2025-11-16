<?php

namespace Domain\Entity;

class User
{
    private ?int $id;
    private string $name;
    private string $email;
    private ?string $passwordHash;
    private \DateTimeImmutable $createdAt;
    
    public function __construct(string $name, string $email, ?int $id = null, ?\DateTimeImmutable $createdAt = null, ?string $passwordHash = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->createdAt = $createdAt ?? new \DateTimeImmutable();
        $this->passwordHash = $passwordHash;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function getName(): string
    {
        return $this->name;
    }
    public function getEmail(): string
    {
        return $this->email;
    }
    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getPasswordHash(): ?string
    {
        return $this->passwordHash;
    }
}
