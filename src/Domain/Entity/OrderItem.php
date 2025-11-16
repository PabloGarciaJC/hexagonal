<?php

namespace Domain\Entity;

class OrderItem
{
    private ?int $id;
    private int $orderId;
    private int $productId;
    private string $productName;
    private int $quantity;
    private float $price;
    private string $currency;

    public function __construct(
        int $productId,
        string $productName,
        int $quantity,
        float $price,
        string $currency,
        int $orderId = 0,
        ?int $id = null
    ) {
        $this->id = $id;
        $this->orderId = $orderId;
        $this->productId = $productId;
        $this->productName = $productName;
        $this->quantity = $quantity;
        $this->price = $price;
        $this->currency = $currency;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrderId(): int
    {
        return $this->orderId;
    }

    public function setOrderId(int $orderId): void
    {
        $this->orderId = $orderId;
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function getProductName(): string
    {
        return $this->productName;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getSubtotal(): float
    {
        return $this->price * $this->quantity;
    }
}
