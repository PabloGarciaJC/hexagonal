<!doctype html>
<html>
<head><meta charset="utf-8"><title>Lista Usuarios</title></head>
<body>
<h1>Usuarios</h1>
<table>
<tr><th>ID</th><th>Nombre</th><th>Email</th><th>Creado</th></tr>
<?php foreach ($users as $u): ?>
    <tr>
        <td><?= htmlspecialchars($u->getId()) ?></td>
        <td><?= htmlspecialchars($u->getName()) ?></td>
        <td><?= htmlspecialchars($u->getEmail()) ?></td>
        <td><?= htmlspecialchars($u->getCreatedAt()->format('Y-m-d H:i')) ?></td>
    </tr>
<?php endforeach; ?>
</table>
<p><a href="/users/new">Crear usuario</a></p>
</body>
</html>
