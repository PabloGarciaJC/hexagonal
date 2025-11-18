<!DOCTYPE html>
<html>
<?php include __DIR__ . '/head.php'; ?>
<body>
    <?php
    include __DIR__ . '/header.php';
    require_once __DIR__ . '/../Helper/FlashMessage.php';
    $success = \Infrastructure\Framework\Helper\FlashMessage::getSuccess();
    $error = \Infrastructure\Framework\Helper\FlashMessage::getError();
    ?>

    <div class="catalog-container">
        <?php include __DIR__ . '/catalog_sidebar.php'; ?>
        <div style="flex:1;">
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
                <div class="catalog-grid">
                    <?php foreach ($products as $product): ?>
                        <div class="product-card">
                            <img class="product-card__img"
                                src="/public/assets/img/product-<?= $product->getId() ?>.jpg"
                                alt="<?= htmlspecialchars($product->getName()) ?>">

                            <div class="product-card__title">
                                <?= htmlspecialchars($product->getName()) ?>
                            </div>

                            <div class="product-card__price">
                                $<?= number_format($product->getPrice(), 2) ?>
                            </div>

                            <div class="product-card__rating">★★★★★</div>

                            <div class="product-card__stock">
                                Stock: <?= $product->getStock() ?>
                            </div>

                            <a class="product-card__btn"
                                href="/?shop=product&id=<?= $product->getId() ?>">
                                Ver Detalles
                            </a>

                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="pagination">
                    <a href="#">&laquo; Anterior</a>
                    <span>1</span>
                    <a href="#">Siguiente &raquo;</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>