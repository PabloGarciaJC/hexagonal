<?php

namespace Infrastructure\Persistence;

use Domain\Repository\OrderRepositoryInterface;
use Domain\Entity\Order;
use Domain\Entity\OrderItem;
use PDO;

class MySQLOrderRepository implements OrderRepositoryInterface
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function save(Order $order): Order
    {
        $stmt = $this->connection->prepare(
            'INSERT INTO orders (customer_id, status, total, currency, created_at, paid_at) 
             VALUES (:customer_id, :status, :total, :currency, :created_at, :paid_at)'
        );
        $stmt->execute([
            ':customer_id' => $order->getCustomerId(),
            ':status' => $order->getStatus(),
            ':total' => $order->getTotal(),
            ':currency' => $order->getCurrency(),
            ':created_at' => $order->getCreatedAt()->format('Y-m-d H:i:s'),
            ':paid_at' => $order->getPaidAt()?->format('Y-m-d H:i:s') ?? null,
        ]);

        $orderId = (int)$this->connection->lastInsertId();
        $order->setId($orderId);

        // Save order items
        foreach ($order->getItems() as $item) {
            $this->saveOrderItem($orderId, $item);
        }

        return $order;
    }

    public function findById(int $id): ?Order
    {
        $stmt = $this->connection->prepare(
            'SELECT id, customer_id, status, total, currency, created_at, paid_at FROM orders WHERE id = :id'
        );
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        // Load items
        $items = $this->getOrderItems($id);

        return $this->hydrateOrder($row, $items);
    }

    public function findByCustomerId(int $customerId): array
    {
        $stmt = $this->connection->prepare(
            'SELECT id, customer_id, status, total, currency, created_at, paid_at FROM orders WHERE customer_id = :customer_id ORDER BY created_at DESC'
        );
        $stmt->execute([':customer_id' => $customerId]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $orders = [];
        foreach ($rows as $row) {
            $items = $this->getOrderItems((int)$row['id']);
            $orders[] = $this->hydrateOrder($row, $items);
        }

        return $orders;
    }

    public function update(Order $order): void
    {
        $stmt = $this->connection->prepare(
            'UPDATE orders SET customer_id = :customer_id, status = :status, total = :total, currency = :currency, paid_at = :paid_at WHERE id = :id'
        );
        $stmt->execute([
            ':customer_id' => $order->getCustomerId(),
            ':status' => $order->getStatus(),
            ':total' => $order->getTotal(),
            ':currency' => $order->getCurrency(),
            ':paid_at' => $order->getPaidAt()?->format('Y-m-d H:i:s') ?? null,
            ':id' => $order->getId(),
        ]);
    }

    private function saveOrderItem(int $orderId, OrderItem $item): void
    {
        $stmt = $this->connection->prepare(
            'INSERT INTO order_items (order_id, product_id, product_name, quantity, price, currency) 
             VALUES (:order_id, :product_id, :product_name, :quantity, :price, :currency)'
        );
        $stmt->execute([
            ':order_id' => $orderId,
            ':product_id' => $item->getProductId(),
            ':product_name' => $item->getProductName(),
            ':quantity' => $item->getQuantity(),
            ':price' => $item->getPrice(),
            ':currency' => $item->getCurrency(),
        ]);

        $itemId = (int)$this->connection->lastInsertId();
        // Optional: update item id if needed for future queries
    }

    private function getOrderItems(int $orderId): array
    {
        $stmt = $this->connection->prepare(
            'SELECT id, order_id, product_id, product_name, quantity, price, currency FROM order_items WHERE order_id = :order_id'
        );
        $stmt->execute([':order_id' => $orderId]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $items = [];
        foreach ($rows as $row) {
            $items[] = new OrderItem(
                (int)$row['product_id'],
                $row['product_name'],
                (int)$row['quantity'],
                (float)$row['price'],
                $row['currency'],
                (int)$row['order_id'],
                (int)$row['id']
            );
        }

        return $items;
    }

    private function hydrateOrder(array $row, array $items): Order
    {
        $paidAt = !empty($row['paid_at']) ? new \DateTimeImmutable($row['paid_at']) : null;

        $order = new Order(
            (int)$row['customer_id'],
            (float)$row['total'],
            $row['currency'],
            $row['status'],
            (int)$row['id'],
            new \DateTimeImmutable($row['created_at']),
            $paidAt,
            $items
        );

        return $order;
    }
}
