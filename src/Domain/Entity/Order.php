<?php

namespace Domain\Entity;

class Order
{
    public const STATUS_PENDING = 'pending';
    public const STATUS_PAID = 'paid';
    public const STATUS_FAILED = 'failed';
    public const STATUS_CANCELED = 'canceled';
    public const STATUS_SHIPPED = 'shipped';

    private ?int $id;
    private int $customerId;
    private string $status;
    private float $total;
    private string $currency;
    private \DateTimeImmutable $createdAt;
    private ?\DateTimeImmutable $paidAt;
    /** @var OrderItem[] */
    private array $items = [];

    public function __construct(
        int $customerId,
        float $total,
        string $currency,
        string $status = self::STATUS_PENDING,
        ?int $id = null,
        ?\DateTimeImmutable $createdAt = null,
        ?\DateTimeImmutable $paidAt = null,
        array $items = []
    ) {
        $this->id = $id;
        $this->customerId = $customerId;
        $this->status = $status;
        $this->total = $total;
        $this->currency = $currency;
        $this->createdAt = $createdAt ?? new \DateTimeImmutable();
        $this->paidAt = $paidAt;
        $this->items = $items;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getCustomerId(): int
    {
        return $this->customerId;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        if (!in_array($status, [self::STATUS_PENDING, self::STATUS_PAID, self::STATUS_FAILED, self::STATUS_CANCELED, self::STATUS_SHIPPED])) {
            throw new \InvalidArgumentException("Invalid order status: $status");
        }
        $this->status = $status;
    }

    public function getTotal(): float
    {
        return $this->total;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getPaidAt(): ?\DateTimeImmutable
    {
        return $this->paidAt;
    }

    public function setPaidAt(\DateTimeImmutable $paidAt): void
    {
        $this->paidAt = $paidAt;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function addItem(OrderItem $item): void
    {
        $item->setOrderId($this->id ?? 0);
        $this->items[] = $item;
    }

    public function markAsPaid(): void
    {
        $this->status = self::STATUS_PAID;
        $this->paidAt = new \DateTimeImmutable();
    }

    public function markAsFailed(): void
    {
        $this->status = self::STATUS_FAILED;
    }
}
