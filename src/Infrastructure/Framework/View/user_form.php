<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Crear Usuario</title>
    <link rel="stylesheet" href="/public/assets/css/users.css">
</head>

<body class="users">
    <?php include __DIR__ . '/header.php'; ?>

    <main class="users__main">
        <h1 class="users__title">Crear Usuario</h1>

        <form class="users__form" action="/" method="POST">
            <div class="users__field">
                <label class="users__label">Nombre
                    <input class="users__input" type="text" name="name">
                </label>
            </div>

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

            <button class="users__button users__button--primary" type="submit">Crear</button>
        </form>

        <!-- <p class="users__help"><a class="users__link" href="http://localhost:8081/?list=listar">Ver usuarios</a></p> -->
    </main>
</body>

</html>