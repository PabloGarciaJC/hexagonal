<?php
require __DIR__ . '/vendor/autoload.php';

use Infrastructure\Persistence\Database;
use Infrastructure\Persistence\MySQLUserRepository;
use Infrastructure\Persistence\MySQLProductRepository;
use Infrastructure\Persistence\MySQLOrderRepository;
use Application\UseCase\CreateUser;
use Application\UseCase\ListUsers;
use Application\UseCase\UpdateUser;
use Application\UseCase\DeleteUser;
use Application\UseCase\ListProducts;
use Application\UseCase\ShowProduct;
use Application\UseCase\CreateProduct;
use Application\UseCase\CreateOrder;
use Infrastructure\Framework\Http\UserController;
use Infrastructure\Framework\Http\AuthController;
use Infrastructure\Framework\Http\ProductController;
use Infrastructure\Framework\Http\CartController;
use Infrastructure\Framework\Http\OrderController;

try {
    // Iniciar sesión (para auth)
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Crear conexión (devuelve un PDO)
    $pdo = Database::connect();

    // Instanciar repositorios (inyectamos el PDO)
    $userRepository = new MySQLUserRepository($pdo);
    $productRepository = new MySQLProductRepository($pdo);
    $orderRepository = new MySQLOrderRepository($pdo);

    // Crear casos de uso - Users
    $createUser = new CreateUser($userRepository);
    $listUsers  = new ListUsers($userRepository);
    $updateUser = new UpdateUser($userRepository);
    $deleteUser = new DeleteUser($userRepository);

    // Crear casos de uso - Products
    $listProducts = new ListProducts($productRepository);
    $showProduct = new ShowProduct($productRepository);
    $createProduct = new CreateProduct($productRepository);

    // Crear casos de uso - Orders
    $createOrder = new CreateOrder($orderRepository, $productRepository);

    // Controladores - Users
    $userController = new UserController($createUser, $listUsers, $updateUser, $deleteUser);
    $authController = new AuthController($userRepository);

    // Controladores - eCommerce
    $productController = new ProductController($listProducts, $showProduct, $createProduct);
    $cartController = new CartController();
    $orderController = new OrderController($createOrder);

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

    } elseif (isset($_GET['user'])) {
        // user actions: edit (GET), update (POST to ?user=update), delete (POST to ?user=delete)
        $action = $_GET['user'] ?? '';
        if ($action === 'edit') {
            $userController->edit($_GET);
        } elseif ($action === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $userController->update($_POST);
        } elseif ($action === 'delete' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $userController->delete($_POST);
        } else {
            header('Location: /?list=listar');
        }

    } else {
        // raíz -> catálogo de productos por defecto
        if (isset($_GET['shop'])) {
            $action = $_GET['shop'] ?? '';
            if ($action === 'catalog') {
                $productController->index();
            } elseif ($action === 'product') {
                $productController->show();
            } elseif ($action === 'create' && $_SERVER['REQUEST_METHOD'] === 'GET') {
                $productController->create();
            } elseif ($action === 'store' && $_SERVER['REQUEST_METHOD'] === 'POST') {
                $productController->store();
            } else {
                $productController->index();
            }
        } elseif (isset($_GET['cart'])) {
            $action = $_GET['cart'] ?? '';
            if ($action === 'view') {
                $cartController->view();
            } elseif ($action === 'add' && $_SERVER['REQUEST_METHOD'] === 'POST') {
                $cartController->add();
            } elseif ($action === 'remove' && $_SERVER['REQUEST_METHOD'] === 'POST') {
                $cartController->remove();
            } elseif ($action === 'clear') {
                $cartController->clear();
            } else {
                $cartController->view();
            }
        } elseif (isset($_GET['order'])) {
            $action = $_GET['order'] ?? '';
            if ($action === 'checkout' && $_SERVER['REQUEST_METHOD'] === 'POST') {
                $orderController->checkout();
            } elseif ($action === 'success') {
                $orderController->viewOrder();
            } else {
                $productController->index();
            }
        } else {
            // Default: show catalog
            $productController->index();
        }
    }

} catch (Throwable $e) {
    echo "<h3>Error:</h3>";
    echo "<pre>" . $e->getMessage() . "</pre>";
}
