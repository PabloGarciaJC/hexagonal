<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Catálogo de Productos</title>
    <link rel="stylesheet" href="/public/assets/css/users.css">
    <style>
        .catalog { padding: 20px; }
        .products { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px; margin-top: 20px; }
        .product-card { border: 1px solid #ddd; padding: 15px; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .product-card h3 { margin-top: 0; }
        .product-price { font-size: 1.5em; color: #27ae60; font-weight: bold; margin: 10px 0; }
        .product-stock { font-size: 0.9em; color: #666; }
        .btn { padding: 8px 12px; background-color: #3498db; color: white; text-decoration: none; border-radius: 3px; display: inline-block; border: none; cursor: pointer; }
        .btn:hover { background-color: #2980b9; }
        .btn-success { background-color: #27ae60; }
        .btn-success:hover { background-color: #229954; }
        .header-shop { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .header-shop a { margin-left: 10px; }
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

    <div class="catalog">
        <div class="header-shop">
            <h1>Catálogo de Productos</h1>
            <div>
                <a class="btn" href="/?cart=view">🛒 Ver Carrito</a>
                <a class="btn" href="/">Volver</a>
            </div>
        </div>

        <?php if (!empty($success)): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
            <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <?php if (empty($products)): ?>
            <p>No hay productos disponibles.</p>
        <?php else: ?>
            <div class="products">
                <?php foreach ($products as $product): ?>
                    <div class="product-card">
                        <h3><?= htmlspecialchars($product->getName()) ?></h3>
                        <p><?= htmlspecialchars(substr($product->getDescription(), 0, 100)) ?>...</p>
                        <div class="product-price">$<?= number_format($product->getPrice(), 2) ?></div>
                        <div class="product-stock">Stock: <?= $product->getStock() ?></div>
                        <div style="margin-top: 10px;">
                            <a class="btn" href="/?shop=product&id=<?= $product->getId() ?>">Ver Detalles</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
