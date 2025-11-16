<header class="app-header">
    <div class="app-header__inner">
        <div class="app-header__brand">
            <a class="app-header__logo" href="/?list=listar">Dashboard</a>
        </div>
        <nav class="app-header__nav">
            <?php if (session_status() === PHP_SESSION_NONE) { session_start(); } ?>
            <?php if (!empty($_SESSION['user_id'])): ?>
                <span class="app-header__user">Hola, <?= htmlspecialchars($_SESSION['user_name'] ?? 'Usuario') ?></span>
                <a class="app-header__link" href="/?logout=yes">Salir</a>
            <?php else: ?>
                <a class="app-header__link" href="/?login=form">Entrar</a>
                <a class="app-header__link" href="/?register=form">Registro</a>
            <?php endif; ?>
        </nav>
    </div>
</header>
