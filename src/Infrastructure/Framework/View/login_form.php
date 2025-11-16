<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Login</title>
    <link rel="stylesheet" href="/public/assets/css/users.css">
</head>

<body class="users">
    <?php include __DIR__ . '/header.php'; ?>

    <main class="users__main">
        <h1 class="users__title">Iniciar sesión</h1>

        <?php if (!empty($error)): ?>
            <div class="users__message users__message--error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form class="users__form" action="/?login=do" method="POST">
            <div class="users__field">
                <label class="users__label">Email
                    <input class="users__input" type="email" name="email">
                </label>
            </div>

            <div class="users__field">
                <label class="users__label">Contraseña
                    <input class="users__input" type="password" name="password">
                </label>
            </div>

            <button class="users__button users__button--primary" type="submit">Entrar</button>
        </form>

        <p class="users__help"><a class="users__link" href="/?register=form">Crear cuenta</a></p>
    </main>
</body>

</html>
