<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Lista Usuarios</title>
    <link rel="stylesheet" href="/public/assets/css/users.css">
</head>

<body>
    <?php include __DIR__ . '/header.php'; ?>

    <div class="users">
        <header class="users__header">
            <h1 class="users__title">Usuarios</h1>
            <a class="users__link" href="/">Volver</a>
        </header>

        <div class="users__container">
            <table class="users__table">
                <thead class="users__thead">
                    <tr class="users__tr">
                        <th class="users__th">ID</th>
                        <th class="users__th">Nombre</th>
                        <th class="users__th">Email</th>
                        <th class="users__th">Creado</th>
                    </tr>
                </thead>
                <tbody class="users__tbody">
                <?php foreach ($users as $u): ?>
                    <tr class="users__row">
                        <td class="users__cell"><?= htmlspecialchars($u->getId()) ?></td>
                        <td class="users__cell"><?= htmlspecialchars($u->getName()) ?></td>
                        <td class="users__cell"><?= htmlspecialchars($u->getEmail()) ?></td>
                        <td class="users__cell"><?= htmlspecialchars($u->getCreatedAt()->format('Y-m-d H:i')) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>