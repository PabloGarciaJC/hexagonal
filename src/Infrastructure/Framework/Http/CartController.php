<?php

namespace Infrastructure\Framework\Http;

use Infrastructure\Framework\Helper\FlashMessage;

class CartController
{
    public function view(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $cart = $_SESSION['cart'] ?? [];
        include __DIR__ . '/../View/cart.php';
    }

    public function add(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $productId = (int)($_POST['product_id'] ?? 0);
        $quantity = (int)($_POST['quantity'] ?? 1);

        if ($productId <= 0 || $quantity <= 0) {
            FlashMessage::setError('Producto o cantidad inválida');
            header('Location: /?shop=catalog');
            exit;
        }

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Check if product already in cart
        $found = false;
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['product_id'] === $productId) {
                $item['quantity'] += $quantity;
                $found = true;
                break;
            }
        }

        if (!$found) {
            $_SESSION['cart'][] = ['product_id' => $productId, 'quantity' => $quantity];
        }

        FlashMessage::setSuccess('Producto agregado al carrito');
        header('Location: /?cart=view');
        exit;
    }

    public function remove(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $productId = (int)($_POST['product_id'] ?? 0);

        if (isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array_filter($_SESSION['cart'], fn($item) => $item['product_id'] !== $productId);
        }

        FlashMessage::setSuccess('Producto eliminado del carrito');
        header('Location: /?cart=view');
        exit;
    }

    public function clear(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        unset($_SESSION['cart']);
        header('Location: /?shop=catalog');
        exit;
    }
}
