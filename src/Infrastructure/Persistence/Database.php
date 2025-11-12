<?php

namespace Infrastructure\Persistence;

use Dotenv\Dotenv;
use PDO;
use PDOException;

class Database
{
    public static function connect(): PDO
    {
        // Cargar variables de entorno si no están disponibles
        if (!getenv('DB_SERVER_NAME')) {
            $dotenv = Dotenv::createImmutable(__DIR__ . '/../../../');
            $dotenv->load();
        }

        // Construir el DSN (cadena de conexión)
        $dsn = sprintf(
            "mysql:host=%s;dbname=%s;port=%s;charset=utf8mb4",
            $_ENV['DB_SERVER_NAME'],
            $_ENV['DB_DATABASE'],
            $_ENV['MYSQL_PORT']
        );

        try {
            $pdo = new PDO(
                $dsn,
                $_ENV['MYSQL_USER'],
                $_ENV['MYSQL_PASSWORD'],
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]
            );

            return $pdo;

        } catch (PDOException $e) {
            throw new \RuntimeException("❌ Error de conexión PDO: " . $e->getMessage());
        }
    }
}
