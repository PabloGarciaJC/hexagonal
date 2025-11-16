<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= htmlspecialchars($product->getName()) ?></title>
    <link rel="stylesheet" href="/public/assets/css/users.css">
    <style>
        .product-detail { max-width: 800px; margin: 20px auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px; }
        .product-detail h1 { margin-top: 0; }
        .product-price { font-size: 2em; color: #27ae60; font-weight: bold; margin: 15px 0; }
        .product-description { line-height: 1.6; color: #333; margin: 15px 0; }
        .product-stock { font-size: 1.1em; margin: 10px 0; }
        .btn { padding: 10px 15px; background-color: #27ae60; color: white; text-decoration: none; border-radius: 3px; display: inline-block; border: none; cursor: pointer; font-size: 1em; }
        .btn:hover { background-color: #229954; }
        .btn-secondary { background-color: #3498db; }
        .btn-secondary:hover { background-color: #2980b9; }
        .quantity-input { width: 60px; padding: 5px; }
    </style>
</head>
<body class="users">
    <?php include __DIR__ . '/header.php'; ?>

    <div class="product-detail">
        <a class="btn btn-secondary" href="/?shop=catalog">← Volver al Catálogo</a>

        <h1><?= htmlspecialchars($product->getName()) ?></h1>
        <p><strong>SKU:</strong> <?= htmlspecialchars($product->getSku()) ?></p>
        
        <div class="product-price">$<?= number_format($product->getPrice(), 2) ?> <?= htmlspecialchars($product->getCurrency()) ?></div>
        
        <div class="product-description">
            <?= htmlspecialchars($product->getDescription()) ?>
        </div>

        <div class="product-stock">
            <strong>Stock disponible:</strong> <?= $product->getStock() ?> unidades
        </div>

        <?php if ($product->getStock() > 0): ?>
            <form method="POST" action="/?cart=add" style="margin-top: 20px;">
                <input type="hidden" name="product_id" value="<?= $product->getId() ?>">
                <label>
                    Cantidad:
                    <input type="number" name="quantity" value="1" min="1" max="<?= $product->getStock() ?>" class="quantity-input">
                </label>
                <button class="btn" type="submit">Añadir al Carrito</button>
            </form>
        <?php else: ?>
            <p style="color: red; font-weight: bold; margin-top: 20px;">Producto sin stock</p>
        <?php endif; ?>

        <div style="margin-top: 30px;">
            <a class="btn btn-secondary" href="/?cart=view">🛒 Ver Carrito</a>
        </div>
    </div>
</body>
</html>
