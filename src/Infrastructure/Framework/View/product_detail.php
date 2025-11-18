<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title><?= htmlspecialchars($product->getName()) ?></title>
    <link rel="stylesheet" href="/public/assets/css/ecommerce.css">
</head>

<body class="users">

    <?php include __DIR__ . '/header.php'; ?>

    <div class="product-detail-container">

        <div class="product-detail-gallery">
            <img class="main-img"
                src="/public/assets/img/product-<?= $product->getId() ?>.jpg"
                alt="<?= htmlspecialchars($product->getName()) ?>">

            <div class="product-detail-thumbs">
                <img src="/public/assets/img/product-<?= $product->getId() ?>.jpg">
                <img src="/public/assets/img/product-<?= $product->getId() ?>.jpg">
            </div>
        </div>

        <div class="product-detail-info">

            <div class="product-detail-title"><?= htmlspecialchars($product->getName()) ?></div>

            <div class="product-detail-price">$<?= number_format($product->getPrice(), 2) ?></div>

            <div class="product-detail-rating">
                <?php $avg = $averageRating ?? 5; ?>
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <span><?= $i <= $avg ? '★' : '☆' ?></span>
                <?php endfor; ?>
                <span>(<?= number_format($avg, 1) ?>)</span>
            </div>

            <div class="product-detail-desc"><?= nl2br(htmlspecialchars($product->getDescription())) ?></div>

            <div class="product-detail-buy">

                <form action="/?cart=add" method="POST">
                    <input type="hidden" name="product_id" value="<?= $product->getId() ?>">
                    <button type="submit" class="btn-primary">Añadir al carrito</button>
                </form>

                <form action="/?favorite=add" method="POST">
                    <input type="hidden" name="product_id" value="<?= $product->getId() ?>">
                    <button type="submit" class="btn-favorite">❤ Añadir a favoritos</button>
                </form>

            </div>

            <div class="reviews-section">

                <h3>Opiniones de clientes</h3>

                <?php if (empty($reviews)): ?>
                    <p>No hay opiniones aún.</p>
                <?php else: ?>
                    <?php foreach ($reviews as $review): ?>
                        <div class="review-card">
                            <div class="review-rating">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <span><?= $i <= $review->getRating() ? '★' : '☆' ?></span>
                                <?php endfor; ?>
                            </div>
                            <span class="review-user">Usuario #<?= $review->getUserId() ?></span>
                            <span class="review-date"> - <?= $review->getCreatedAt()->format('d/m/Y') ?></span>
                            <div class="review-comment"><?= nl2br(htmlspecialchars($review->getComment())) ?></div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>


                <?php if (!empty($_SESSION['user_id'])): ?>
                    <form class="review-form" action="/?review=add" method="POST">
                        <input type="hidden" name="product_id" value="<?= $product->getId() ?>">
                        <label for="rating">Tu valoración:</label>
                        <select name="rating" id="rating" required>
                            <option value="5">★★★★★</option>
                            <option value="4">★★★★</option>
                            <option value="3">★★★</option>
                            <option value="2">★★</option>
                            <option value="1">★</option>
                        </select>

                        <label for="comment">Comentario:</label>
                        <textarea name="comment" id="comment" rows="3" required></textarea>

                        <button type="submit">Enviar opinión</button>
                    </form>
                <?php endif; ?>

            </div>

        </div>

    </div>

    <footer class="footer">
        <div class="footer__links">
            <a href="#">Condiciones</a>
            <a href="#">Privacidad</a>
            <a href="#">Ayuda</a>
            <a href="#">Contacto</a>
        </div>
        <div class="footer__copy">&copy; 2025 Ecommerce Hexagon. Proyecto demo.</div>
    </footer>

</body>

</html>