<?php

namespace Application\UseCase;

use Domain\Repository\ProductRepositoryInterface;
use Domain\Repository\OrderRepositoryInterface;
use Domain\Entity\Order;
use Domain\Entity\OrderItem;

class CreateOrder
{
    private OrderRepositoryInterface $orderRepository;
    private ProductRepositoryInterface $productRepository;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        ProductRepositoryInterface $productRepository
    ) {
        $this->orderRepository = $orderRepository;
        $this->productRepository = $productRepository;
    }

    /**
     * Create an order from cart items.
     * $cartItems is an array of ['product_id' => int, 'quantity' => int]
     * Returns the saved Order with ID assigned.
     */
    public function execute(int $customerId, array $cartItems): Order
    {
        if (empty($cartItems)) {
            throw new \InvalidArgumentException('Cart cannot be empty');
        }

        $order = new Order($customerId, 0, 'USD', Order::STATUS_PENDING);
        $total = 0;

        foreach ($cartItems as $item) {
            $productId = (int)$item['product_id'];
            $quantity = (int)$item['quantity'];

            if ($quantity <= 0) {
                throw new \InvalidArgumentException("Invalid quantity for product {$productId}");
            }

            $product = $this->productRepository->findById($productId);
            if (!$product) {
                throw new \InvalidArgumentException("Product {$productId} not found");
            }

            if (!$product->hasEnoughStock($quantity)) {
                throw new \InvalidArgumentException("Insufficient stock for {$product->getName()}");
            }

            $orderItem = new OrderItem(
                $productId,
                $product->getName(),
                $quantity,
                $product->getPrice(),
                $product->getCurrency()
            );
            $order->addItem($orderItem);
            $total += $orderItem->getSubtotal();
        }

        // Create a new Order with the total (we'll set it in Order constructor)
        $finalOrder = new Order($customerId, $total, 'USD', Order::STATUS_PENDING);
        foreach ($order->getItems() as $item) {
            $finalOrder->addItem($item);
        }

        return $this->orderRepository->save($finalOrder);
    }
}
