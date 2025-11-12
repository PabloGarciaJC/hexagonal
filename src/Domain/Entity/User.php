<?php
namespace Domain\Entity;

class User
{
    private ?int $id;
    private string $name;
    private string $email;
    private \DateTimeImmutable $createdAt;

    public function __construct(string $name, string $email, ?int $id = null, ?\DateTimeImmutable $createdAt = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->createdAt = $createdAt ?? new \DateTimeImmutable();
    }

    public function getId(): ?int { return $this->id; }
    public function getName(): string { return $this->name; }
    public function getEmail(): string { return $this->email; }
    public function getCreatedAt(): \DateTimeImmutable { return $this->createdAt; }
}
