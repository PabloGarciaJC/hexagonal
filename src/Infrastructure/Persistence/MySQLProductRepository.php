<?php

namespace Infrastructure\Persistence;

use Domain\Repository\ProductRepositoryInterface;
use Domain\Entity\Product;
use PDO;

class MySQLProductRepository implements ProductRepositoryInterface
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function save(Product $product): Product
    {
        $stmt = $this->connection->prepare(
            'INSERT INTO products (sku, name, description, price, currency, stock, active, created_at) 
             VALUES (:sku, :name, :description, :price, :currency, :stock, :active, :created_at)'
        );
        $stmt->execute([
            ':sku' => $product->getSku(),
            ':name' => $product->getName(),
            ':description' => $product->getDescription(),
            ':price' => $product->getPrice(),
            ':currency' => $product->getCurrency(),
            ':stock' => $product->getStock(),
            ':active' => $product->isActive() ? 1 : 0,
            ':created_at' => $product->getCreatedAt()->format('Y-m-d H:i:s'),
        ]);

        $id = (int)$this->connection->lastInsertId();
        $product->setId($id);
        return $product;
    }

    public function findById(int $id): ?Product
    {
        $stmt = $this->connection->prepare(
            'SELECT id, sku, name, description, price, currency, stock, active, created_at FROM products WHERE id = :id'
        );
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        return $this->hydrateProduct($row);
    }

    public function findAll(): array
    {
        $stmt = $this->connection->query(
            'SELECT id, sku, name, description, price, currency, stock, active, created_at FROM products ORDER BY created_at DESC'
        );
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map(fn($row) => $this->hydrateProduct($row), $rows);
    }

    public function findActive(): array
    {
        $stmt = $this->connection->query(
            'SELECT id, sku, name, description, price, currency, stock, active, created_at FROM products WHERE active = 1 AND stock > 0 ORDER BY created_at DESC'
        );
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map(fn($row) => $this->hydrateProduct($row), $rows);
    }

    public function update(Product $product): void
    {
        $stmt = $this->connection->prepare(
            'UPDATE products SET sku = :sku, name = :name, description = :description, price = :price, currency = :currency, stock = :stock, active = :active WHERE id = :id'
        );
        $stmt->execute([
            ':sku' => $product->getSku(),
            ':name' => $product->getName(),
            ':description' => $product->getDescription(),
            ':price' => $product->getPrice(),
            ':currency' => $product->getCurrency(),
            ':stock' => $product->getStock(),
            ':active' => $product->isActive() ? 1 : 0,
            ':id' => $product->getId(),
        ]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->connection->prepare('DELETE FROM products WHERE id = :id');
        $stmt->execute([':id' => $id]);
    }

    private function hydrateProduct(array $row): Product
    {
        return new Product(
            $row['sku'],
            $row['name'],
            $row['description'],
            (float)$row['price'],
            $row['currency'],
            (int)$row['stock'],
            (bool)$row['active'],
            (int)$row['id'],
            new \DateTimeImmutable($row['created_at'])
        );
    }
}
