<?php

namespace Domain\Repository;

use Domain\Entity\Order;

interface OrderRepositoryInterface
{
    public function save(Order $order): Order;
    public function findById(int $id): ?Order;
    public function findByCustomerId(int $customerId): array;
    public function update(Order $order): void;
}
