<?php
namespace Infrastructure\Persistence;

use Domain\Repository\UserRepositoryInterface;
use Domain\Entity\User;
use PDO;

class MySQLUserRepository implements UserRepositoryInterface
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        // ← Aquí se inyecta la conexión concreta a la base de datos
        $this->connection = $connection;
    }

    public function save(User $user): void
    {
        $stmt = $this->connection->prepare(
            'INSERT INTO users (name, email, created_at) VALUES (:name, :email, :created_at)'
        );
        $stmt->execute([
            ':name' => $user->getName(),
            ':email' => $user->getEmail(),
            ':created_at' => $user->getCreatedAt()->format('Y-m-d H:i:s')
        ]);

        // si quieres, actualizar id en la entidad (opcional)
        // $id = (int)$this->connection->lastInsertId();
    }

    public function findAll(): array
    {
        $stmt = $this->connection->query('SELECT id, name, email, created_at FROM users ORDER BY id DESC');
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $users = [];
        foreach ($rows as $r) {
            $users[] = new User($r['name'], $r['email'], (int)$r['id'], new \DateTimeImmutable($r['created_at']));
        }
        return $users;
    }

    public function findById(int $id): ?User
    {
        $stmt = $this->connection->prepare('SELECT id, name, email, created_at FROM users WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $r = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$r) return null;
        return new User($r['name'], $r['email'], (int)$r['id'], new \DateTimeImmutable($r['created_at']));
    }
}
