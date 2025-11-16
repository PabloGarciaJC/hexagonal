<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Checkout</title>
    <link rel="stylesheet" href="/public/assets/css/users.css">
    <style>
        .checkout-container { max-width: 800px; margin: 20px auto; padding: 20px; }
        .checkout-section { margin: 20px 0; padding: 15px; border: 1px solid #ddd; border-radius: 5px; }
        .checkout-summary { background-color: #f9f9f9; }
        .summary-item { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #eee; }
        .summary-total { font-size: 1.3em; font-weight: bold; color: #27ae60; text-align: right; margin-top: 10px; }
        .btn { padding: 10px 15px; background-color: #27ae60; color: white; border: none; border-radius: 3px; cursor: pointer; font-size: 1em; }
        .btn:hover { background-color: #229954; }
        .btn-secondary { background-color: #3498db; }
        .btn-secondary:hover { background-color: #2980b9; }
        .alert { padding: 10px; margin-bottom: 15px; border-radius: 3px; }
        .alert-error { background-color: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; }
    </style>
</head>
<body class="users">
    <?php include __DIR__ . '/header.php'; ?>

    <div class="checkout-container">
        <h1>Resumen del Pedido</h1>

        <?php if (!empty($error)): ?>
            <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <div class="checkout-section checkout-summary">
            <h2>Artículos del Pedido</h2>
            <?php if (!empty($cart)): ?>
                <?php foreach ($cart as $item): ?>
                    <div class="summary-item">
                        <span>Producto ID: <?= $item['product_id'] ?> × <?= $item['quantity'] ?></span>
                        <span>Cantidad: <?= $item['quantity'] ?></span>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Tu carrito está vacío.</p>
            <?php endif; ?>
        </div>

        <div class="checkout-section">
            <h2>Información de Entrega</h2>
            <p>La entrega será a la dirección registrada en tu perfil.</p>
            <p><strong>Nota:</strong> Este es un pago simulado. En producción integrarías Stripe/PayPal aquí.</p>
        </div>

        <div class="checkout-section">
            <form method="POST" action="/?order=checkout">
                <div style="margin: 20px 0;">
                    <button type="submit" class="btn">Confirmar Pedido</button>
                    <a class="btn btn-secondary" href="/?cart=view">Volver al Carrito</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
