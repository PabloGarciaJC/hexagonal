<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Ecommerce Hexagon - Home</title>
    <link rel="stylesheet" href="/public/assets/css/ecommerce.css">
</head>
<body>
    <?php include __DIR__ . '/header.php'; ?>
    <main style="max-width:1200px;margin:2rem auto;">
        <section style="display:flex;align-items:center;justify-content:space-between;">
            <div>
                <h1 style="font-size:2.5rem;color:#232f3e;">Bienvenido a Ecommerce Hexagon</h1>
                <p style="font-size:1.2rem;color:#555;">Tu tienda online con miles de productos, envío rápido y la mejor experiencia.</p>
            </div>
            <img src="/public/assets/img/ecommerce-hero.png" alt="Ecommerce style" style="height:180px;">
        </section>
        <section style="margin-top:3rem;">
            <h2 style="color:#232f3e;">Categorías populares</h2>
            <div style="display:flex;gap:2rem;flex-wrap:wrap;">
                <div style="background:#fff;border-radius:8px;padding:1rem 2rem;box-shadow:0 2px 8px rgba(0,0,0,0.04);font-size:1.1rem;">Electrónica</div>
                <div style="background:#fff;border-radius:8px;padding:1rem 2rem;box-shadow:0 2px 8px rgba(0,0,0,0.04);font-size:1.1rem;">Libros</div>
                <div style="background:#fff;border-radius:8px;padding:1rem 2rem;box-shadow:0 2px 8px rgba(0,0,0,0.04);font-size:1.1rem;">Hogar</div>
                <div style="background:#fff;border-radius:8px;padding:1rem 2rem;box-shadow:0 2px 8px rgba(0,0,0,0.04);font-size:1.1rem;">Moda</div>
                <div style="background:#fff;border-radius:8px;padding:1rem 2rem;box-shadow:0 2px 8px rgba(0,0,0,0.04);font-size:1.1rem;">Deportes</div>
            </div>
        </section>
        <section style="margin-top:3rem;">
            <h2 style="color:#232f3e;">Productos destacados</h2>
            <?php include __DIR__ . '/products_catalog.php'; ?>
        </section>
    </main>
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
