<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Mi Carrito</title>
    <link rel="stylesheet" href="/public/assets/css/users.css">
    <style>
        .cart-container { max-width: 900px; margin: 20px auto; padding: 20px; }
        .cart-items { margin: 20px 0; }
        .cart-item { display: flex; justify-content: space-between; align-items: center; padding: 15px; border-bottom: 1px solid #ddd; }
        .cart-item-info { flex: 1; }
        .cart-item-price { font-weight: bold; color: #27ae60; font-size: 1.1em; }
        .cart-total { font-size: 1.3em; margin: 20px 0; text-align: right; font-weight: bold; }
        .btn { padding: 10px 15px; background-color: #3498db; color: white; text-decoration: none; border-radius: 3px; display: inline-block; border: none; cursor: pointer; }
        .btn:hover { background-color: #2980b9; }
        .btn-success { background-color: #27ae60; }
        .btn-success:hover { background-color: #229954; }
        .btn-danger { background-color: #e74c3c; }
        .btn-danger:hover { background-color: #c0392b; }
        .checkout-section { text-align: right; margin-top: 30px; }
        .alert { padding: 10px; margin-bottom: 15px; border-radius: 3px; }
        .alert-success { background-color: #d4edda; border: 1px solid #c3e6cb; color: #155724; }
        .alert-error { background-color: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; }
    </style>
</head>
<body class="users">
    <?php 
    require_once __DIR__ . '/../Helper/FlashMessage.php';
    include __DIR__ . '/header.php'; 
    $success = \Infrastructure\Framework\Helper\FlashMessage::getSuccess();
    $error = \Infrastructure\Framework\Helper\FlashMessage::getError();
    ?>

    <div class="cart-container">
        <h1>Carrito de Compras</h1>

        <?php if (!empty($success)): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
            <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <?php if (empty($cart)): ?>
            <p>Tu carrito está vacío.</p>
            <a class="btn" href="/?shop=catalog">Continuar Comprando</a>
        <?php else: ?>
            <div class="cart-items">
                <?php 
                $total = 0;
                foreach ($cart as $item): 
                    $productId = $item['product_id'];
                    $quantity = $item['quantity'];
                ?>
                    <div class="cart-item">
                        <div class="cart-item-info">
                            <p><strong>Producto ID:</strong> <?= $productId ?></p>
                            <p><strong>Cantidad:</strong> <?= $quantity ?></p>
                        </div>
                        <form method="POST" action="/?cart=remove" style="display:inline;">
                            <input type="hidden" name="product_id" value="<?= $productId ?>">
                            <button class="btn btn-danger" type="submit">Eliminar</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="checkout-section">
                <a class="btn" href="/?shop=catalog">Continuar Comprando</a>
                <form method="POST" action="/?order=checkout" style="display:inline;">
                    <button class="btn btn-success" type="submit">Proceder al Pago</button>
                </form>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
