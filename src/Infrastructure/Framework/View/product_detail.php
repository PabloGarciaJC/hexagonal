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

    <div class="product-detail-container">
        <div class="product-detail-gallery">
            <img src="/public/assets/img/product-<?= $product->getId() ?>.jpg" alt="<?= htmlspecialchars($product->getName()) ?>">
            <!-- Miniaturas demo -->
            <div style="display:flex;gap:0.5rem;">
                <img src="/public/assets/img/product-<?= $product->getId() ?>.jpg" style="width:48px;height:48px;object-fit:contain;">
                <img src="/public/assets/img/product-<?= $product->getId() ?>.jpg" style="width:48px;height:48px;object-fit:contain;">
            </div>
        </div>
        <div class="product-detail-info">
            <div class="product-detail-title"><?= htmlspecialchars($product->getName()) ?></div>
            <div class="product-detail-price">$<?= number_format($product->getPrice(), 2) ?></div>
            <div class="product-detail-rating">
                <?php $avg = $averageRating ?? 5; for ($i=1; $i<=5; $i++): ?>
                    <span><?= $i <= $avg ? '★' : '☆' ?></span>
                <?php endfor; ?>
                <span style="color:#888;font-size:0.95em;">(<?= number_format($avg,1) ?>)</span>
            </div>
            <div class="product-detail-desc"><?= nl2br(htmlspecialchars($product->getDescription())) ?></div>
            <div class="product-detail-buy">
                <form action="/?cart=add" method="POST" style="display:inline;">
                    <input type="hidden" name="product_id" value="<?= $product->getId() ?>">
                    <button type="submit">Añadir al carrito</button>
                </form>
                <form action="/?favorite=add" method="POST" style="display:inline;">
                    <input type="hidden" name="product_id" value="<?= $product->getId() ?>">
                    <button type="submit" class="favorite-btn">❤ Añadir a favoritos</button>
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
                                <?php for ($i=1; $i<=5; $i++): ?>
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
