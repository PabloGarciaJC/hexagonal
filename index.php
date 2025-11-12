<?php
require __DIR__ . '/vendor/autoload.php';

use Infrastructure\Persistence\Database;
use Infrastructure\Persistence\MySQLUserRepository;
use Application\UseCase\CreateUser;
use Infrastructure\Framework\Http\UserController;
use Application\UseCase\ListUsers;

try {
    // Crear conexión (devuelve un PDO)
    $pdo = Database::connect();

    // Instanciar repositorio (inyectamos el PDO)
    $userRepository = new MySQLUserRepository($pdo);

    // Crear caso de uso
    $createUser = new CreateUser($userRepository);
    $listUsers  = new ListUsers($userRepository);

    // Controlador HTTP
    $userController = new UserController($createUser, $listUsers);

    // Routing muy básico
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $userController->store($_POST);
    } else {
        $userController->form();
    }

} catch (Throwable $e) {
    echo "<h3>Error:</h3>";
    echo "<pre>" . $e->getMessage() . "</pre>";
}
