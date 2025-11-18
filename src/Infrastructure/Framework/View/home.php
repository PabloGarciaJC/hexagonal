<!doctype html>
<html>
    <?php include __DIR__ . '/head.php'; ?>
    <body>
        <?php include __DIR__ . '/header.php'; ?>
        <main class="home">
            <section class="home-hero">
                <div class="home-hero__text">
                    <h1 class="home-title">Bienvenido a Ecommerce Hexagon</h1>
                    <p class="home-subtitle">Tu tienda online con miles de productos, envío rápido y la mejor experiencia.</p>
                </div>
                <img class="home-hero__img"
                    src="/public/assets/img/ecommerce-hero.png"
                    alt="Ecommerce Hexagon">
            </section>
            <section class="home-section">
                <h2 class="section-title">Categorías populares</h2>
                <div class="categories-grid">
                    <div class="category-card">Electrónica</div>
                    <div class="category-card">Libros</div>
                    <div class="category-card">Hogar</div>
                    <div class="category-card">Moda</div>
                    <div class="category-card">Deportes</div>
                </div>
            </section>
            <section class="home-section">
                <h2 class="section-title">Productos destacados</h2>
                <?php include __DIR__ . '/products_catalog.php'; ?>
            </section>
        </main>
        <?php include __DIR__ . '/footer.php'; ?>
    </body>
</html>