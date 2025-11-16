<?php

require __DIR__ . '/vendor/autoload.php';

use Domain\Entity\Product;
use Domain\Entity\Order;
use Domain\Entity\OrderItem;

echo "=== Test de Dominio: Validación de Entidades ===\n\n";

// Test 1: Crear un Producto
echo "1. Test Product Entity:\n";
$product = new Product(
    'TEST-001',
    'Test Product',
    'A test product',
    29.99,
    'USD',
    10
);
echo "   ✓ Producto creado: " . $product->getName() . " ($" . $product->getPrice() . ")\n";
echo "   ✓ Stock: " . $product->getStock() . "\n";

// Test 2: Validar stock suficiente
echo "\n2. Test Stock Validation:\n";
if ($product->hasEnoughStock(5)) {
    echo "   ✓ Stock suficiente para 5 unidades\n";
}
if (!$product->hasEnoughStock(20)) {
    echo "   ✓ Correctamente detecta insuficiencia (20 unidades no disponibles)\n";
}

// Test 3: Decrementar stock
echo "\n3. Test Stock Decrease:\n";
$product->decreaseStock(3);
echo "   ✓ Stock después de decrementar 3: " . $product->getStock() . "\n";

// Test 4: Crear OrderItem
echo "\n4. Test OrderItem:\n";
$item = new OrderItem(
    1,
    'Test Product',
    2,
    29.99,
    'USD'
);
echo "   ✓ Item creado: " . $item->getProductName() . " x " . $item->getQuantity() . "\n";
echo "   ✓ Subtotal: $" . number_format($item->getSubtotal(), 2) . "\n";

// Test 5: Crear Order
echo "\n5. Test Order:\n";
$order = new Order(1, 59.98, 'USD');
$order->addItem($item);
echo "   ✓ Orden creada para cliente: " . $order->getCustomerId() . "\n";
echo "   ✓ Estado inicial: " . $order->getStatus() . "\n";
echo "   ✓ Total: $" . number_format($order->getTotal(), 2) . "\n";
echo "   ✓ Items en orden: " . count($order->getItems()) . "\n";

// Test 6: Marcar como pagada
echo "\n6. Test Payment Status:\n";
$order->markAsPaid();
echo "   ✓ Orden marcada como pagada\n";
echo "   ✓ Nuevo estado: " . $order->getStatus() . "\n";
echo "   ✓ Fecha de pago: " . ($order->getPaidAt() ? $order->getPaidAt()->format('Y-m-d H:i:s') : 'N/A') . "\n";

// Test 7: Validar estados de orden
echo "\n7. Test Order Status Validation:\n";
$invalidStatus = 'invalid_status';
try {
    $order->setStatus($invalidStatus);
    echo "   ✗ FALLÓ: Debería rechazar estado inválido\n";
} catch (\InvalidArgumentException $e) {
    echo "   ✓ Correctamente rechaza estado inválido: " . $e->getMessage() . "\n";
}

echo "\n=== ✓ Todos los tests de dominio pasaron ===\n";
