<?php
require __DIR__ . '/vendor/autoload.php';

use Infrastructure\Persistence\Database;
use Infrastructure\Persistence\MySQLUserRepository;
use Application\UseCase\CreateUser;
use Application\UseCase\ListUsers;
use Infrastructure\Framework\Http\UserController;
use Infrastructure\Framework\Http\AuthController;

try {
    // Iniciar sesión (para auth)
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Crear conexión (devuelve un PDO)
    $pdo = Database::connect();

    // Instanciar repositorio (inyectamos el PDO)
    $userRepository = new MySQLUserRepository($pdo);

    // Crear caso de uso
    $createUser = new CreateUser($userRepository);
    $listUsers  = new ListUsers($userRepository);

    // Controladores
    $userController = new UserController($createUser, $listUsers);
    $authController = new AuthController($userRepository);

    // Routing muy básico
    if (isset($_GET['login'])) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' || $_GET['login'] === 'do') {
            $authController->login($_POST);
        } else {
            $authController->showLoginForm();
        }

    } elseif (isset($_GET['logout'])) {
        $authController->logout();

    } elseif (isset($_GET['register'])) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userController->store($_POST);
        } else {
            // mostrar formulario de registro
            $userController->form();
        }

    } elseif (isset($_GET['list'])) {
        $userController->index();

    } else {
        // raíz -> formulario de registro por defecto
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userController->store($_POST);
        } else {
            $userController->form();
        }
    }

} catch (Throwable $e) {
    echo "<h3>Error:</h3>";
    echo "<pre>" . $e->getMessage() . "</pre>";
}
