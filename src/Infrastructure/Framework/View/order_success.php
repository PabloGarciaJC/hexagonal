<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Pedido Completado</title>
    <link rel="stylesheet" href="/public/assets/css/users.css">
    <style>
        .success-container { max-width: 600px; margin: 40px auto; padding: 30px; text-align: center; border: 2px solid #27ae60; border-radius: 5px; background-color: #f0fff4; }
        .success-container h1 { color: #27ae60; }
        .btn { padding: 10px 15px; background-color: #3498db; color: white; text-decoration: none; border-radius: 3px; display: inline-block; border: none; cursor: pointer; margin: 10px 5px; }
        .btn:hover { background-color: #2980b9; }
    </style>
</head>
<body class="users">
    <?php include __DIR__ . '/header.php'; ?>

    <div class="success-container">
        <h1>✓ ¡Pedido Completado!</h1>
        <p>Tu pedido ha sido procesado exitosamente.</p>
        <p><strong>ID de Pedido:</strong> <?= isset($_GET['id']) ? (int)$_GET['id'] : 'N/A' ?></p>
        <p>Te enviaremos un correo de confirmación pronto.</p>
        
        <div>
            <a class="btn" href="/?shop=catalog">Continuar Comprando</a>
            <a class="btn" href="/?list=listar">Ver Mis Pedidos</a>
        </div>
    </div>
</body>
</html>
