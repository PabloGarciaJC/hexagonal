<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Usuario creado</title>
    <link rel="stylesheet" href="/public/assets/css/users.css">
</head>

<body class="users">
    <?php include __DIR__ . '/header.php'; ?>

    <main class="users__main">
        <p class="users__message users__message--success">Usuario <?= htmlspecialchars($user->getName()) ?> creado con éxito.</p>
        <p><a class="users__link" href="http://localhost:8081/?list=listar">Volver a la lista</a></p>
    </main>
</body>

</html>