<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Panel de Administración</title>
    <link rel="stylesheet" href="/public/assets/css/Ecommerce.css">
    <style>
        .admin-container { max-width: 1100px; margin: 2rem auto; background: #fff; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.07); padding: 2rem; }
        .admin-title { color: #232f3e; font-size: 2rem; margin-bottom: 1.5rem; }
        .admin-table { width: 100%; border-collapse: collapse; margin-bottom: 2rem; }
        .admin-table th, .admin-table td { border: 1px solid #eee; padding: 0.7rem; text-align: left; }
        .admin-table th { background: #f5f6fa; color: #232f3e; }
        .admin-actions a { margin-right: 0.7rem; color: #232f3e; text-decoration: none; font-weight: bold; }
        .admin-actions a:hover { color: #b12704; }
        .admin-form { margin-top: 2rem; }
        .admin-form input, .admin-form select { padding: 0.5rem; margin-bottom: 1rem; width: 100%; border-radius: 4px; border: 1px solid #ddd; }
        .admin-form button { background: #febd69; color: #232f3e; border: none; border-radius: 4px; padding: 0.7rem 1.5rem; font-size: 1rem; cursor: pointer; font-weight: bold; }
    </style>
</head>
<body>
    <?php include __DIR__ . '/header.php'; ?>
    <div class="admin-container">
        <div class="admin-title">Panel de Administración</div>
        <h2>Productos</h2>
        <table class="admin-table">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Categoría</th>
                <th>Acciones</th>
            </tr>
            <?php foreach ($products as $product): ?>
            <tr>
                <td><?= $product->getId() ?></td>
                <td><?= htmlspecialchars($product->getName()) ?></td>
                <td>$<?= number_format($product->getPrice(), 2) ?></td>
                <td><?= $product->getStock() ?></td>
                <td><?= htmlspecialchars($product->getCategory() ?? 'N/A') ?></td>
                <td class="admin-actions">
                    <a href="/?admin=edit&id=<?= $product->getId() ?>">Editar</a>
                    <a href="/?admin=delete&id=<?= $product->getId() ?>" onclick="return confirm('¿Eliminar producto?');">Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <h2>Agregar Producto</h2>
        <form class="admin-form" action="/?admin=create" method="POST">
            <input type="text" name="name" placeholder="Nombre" required>
            <input type="number" name="price" placeholder="Precio" step="0.01" required>
            <input type="number" name="stock" placeholder="Stock" required>
            <select name="category">
                <option value="electronica">Electrónica</option>
                <option value="libros">Libros</option>
                <option value="hogar">Hogar</option>
                <option value="moda">Moda</option>
                <option value="deportes">Deportes</option>
            </select>
            <button type="submit">Agregar</button>
        </form>
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
