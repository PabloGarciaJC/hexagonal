<?php

namespace Domain\Entity;

class Product
{
    private ?int $id;
    private string $sku;
    private string $name;
    private string $description;
    private float $price;
    private string $currency;
    private int $stock;
    private bool $active;
    private \DateTimeImmutable $createdAt;

    public function __construct(
        string $sku,
        string $name,
        string $description,
        float $price,
        string $currency,
        int $stock,
        bool $active = true,
        ?int $id = null,
        ?\DateTimeImmutable $createdAt = null
    ) {
        $this->sku = $sku;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->currency = $currency;
        $this->stock = $stock;
        $this->active = $active;
        $this->id = $id;
        $this->createdAt = $createdAt ?? new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getSku(): string
    {
        return $this->sku;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getStock(): int
    {
        return $this->stock;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function hasEnoughStock(int $quantity): bool
    {
        return $this->stock >= $quantity;
    }

    public function decreaseStock(int $quantity): void
    {
        if (!$this->hasEnoughStock($quantity)) {
            throw new \InvalidArgumentException("Insufficient stock for product {$this->name}");
        }
        $this->stock -= $quantity;
    }

    public function increaseStock(int $quantity): void
    {
        $this->stock += $quantity;
    }
}
