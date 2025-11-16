<?php

namespace Infrastructure\Persistence;

use Dotenv\Dotenv;
use PDO;
use PDOException;

class Database
{
    private static ?PDO $instance = null;
    private const MAX_RETRIES = 10;
    private const RETRY_DELAY = 1; // segundos

    public static function connect(): PDO
    {
        if (self::$instance !== null) {
            return self::$instance;
        }

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

        $attempt = 0;
        $lastException = null;

        while ($attempt < self::MAX_RETRIES) {
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

                self::$instance = $pdo;
                return $pdo;

            } catch (PDOException $e) {
                $lastException = $e;
                $attempt++;

                if ($attempt < self::MAX_RETRIES) {
                    // Espera antes de reintentar
                    sleep(self::RETRY_DELAY);
                }
            }
        }

        // Si llegamos aquí, todas las conexiones fallaron
        throw new \RuntimeException(
            "Error de conexión a la base de datos después de " . self::MAX_RETRIES . " intentos: " .
            $lastException->getMessage()
        );
    }
}
