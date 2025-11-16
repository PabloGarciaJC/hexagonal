<?php

namespace Domain\Repository;

use Domain\Entity\Product;

interface ProductRepositoryInterface
{
    public function save(Product $product): Product;
    public function findById(int $id): ?Product;
    public function findAll(): array;
    public function findActive(): array;
    public function update(Product $product): void;
    public function delete(int $id): void;
}
