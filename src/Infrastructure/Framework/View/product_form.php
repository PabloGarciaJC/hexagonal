<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Crear Producto</title>
    <link rel="stylesheet" href="/public/assets/css/users.css">
    <style>
        .form-container { max-width: 500px; margin: 20px auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px; }
        .form-field { margin-bottom: 15px; }
        .form-field label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-field input, .form-field textarea { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 3px; font-size: 1em; }
        .form-field textarea { min-height: 100px; }
        .btn { padding: 10px 15px; background-color: #27ae60; color: white; border: none; border-radius: 3px; cursor: pointer; font-size: 1em; }
        .btn:hover { background-color: #229954; }
        .btn-secondary { background-color: #3498db; }
        .btn-secondary:hover { background-color: #2980b9; }
        .alert { padding: 10px; margin-bottom: 15px; border-radius: 3px; }
        .alert-success { background-color: #d4edda; border: 1px solid #c3e6cb; color: #155724; }
        .alert-error { background-color: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; }
        .checkbox-field { display: flex; align-items: center; }
        .checkbox-field input { width: auto; margin-right: 10px; }
    </style>
</head>
<body class="users">
    <?php 
    require_once __DIR__ . '/../Helper/FlashMessage.php';
    include __DIR__ . '/header.php'; 
    $success = \Infrastructure\Framework\Helper\FlashMessage::getSuccess();
    $error = \Infrastructure\Framework\Helper\FlashMessage::getError();
    ?>

    <div class="form-container">
        <h1>Crear Producto</h1>

        <?php if (!empty($success)): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
            <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" action="/?shop=store">
            <div class="form-field">
                <label for="sku">SKU *</label>
                <input type="text" id="sku" name="sku" required>
            </div>

            <div class="form-field">
                <label for="name">Nombre del Producto *</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div class="form-field">
                <label for="description">Descripción *</label>
                <textarea id="description" name="description" required></textarea>
            </div>

            <div class="form-field">
                <label for="price">Precio (USD) *</label>
                <input type="number" id="price" name="price" step="0.01" min="0" required>
            </div>

            <div class="form-field">
                <label for="stock">Stock Inicial *</label>
                <input type="number" id="stock" name="stock" min="0" required>
            </div>

            <div class="form-field checkbox-field">
                <input type="checkbox" id="active" name="active" checked>
                <label for="active" style="margin: 0;">Producto Activo</label>
            </div>

            <div>
                <button type="submit" class="btn">Crear Producto</button>
                <a class="btn btn-secondary" href="/?shop=catalog">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>
