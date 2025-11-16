<?php

namespace Infrastructure\Framework\Http;

use Application\UseCase\CreateOrder;

class OrderController
{
    private CreateOrder $createOrder;

    public function __construct(CreateOrder $createOrder)
    {
        $this->createOrder = $createOrder;
    }

    public function checkout(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (empty($_SESSION['user_id'])) {
            $_SESSION['flash_error'] = 'Debes iniciar sesión para comprar';
            header('Location: /?login=form');
            exit;
        }

        // Get cart from session
        $cart = $_SESSION['cart'] ?? [];

        if (empty($cart)) {
            $_SESSION['flash_error'] = 'Tu carrito está vacío';
            header('Location: /?cart=view');
            exit;
        }

        try {
            $order = $this->createOrder->execute($_SESSION['user_id'], $cart);
            $_SESSION['order_id'] = $order->getId();
            unset($_SESSION['cart']);
            $_SESSION['flash_success'] = '¡Pedido creado exitosamente!';
            header('Location: /?order=success&id=' . $order->getId());
            exit;
        } catch (\InvalidArgumentException $e) {
            $_SESSION['flash_error'] = 'Error: ' . $e->getMessage();
            header('Location: /?cart=view');
            exit;
        } catch (\Exception $e) {
            $_SESSION['flash_error'] = 'Error al procesar el pedido. Por favor intenta de nuevo.';
            header('Location: /?cart=view');
            exit;
        }
    }

    public function viewOrder(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $orderId = (int)($_GET['id'] ?? 0);
        $error = null;

        include __DIR__ . '/../View/order_success.php';
    }
}
