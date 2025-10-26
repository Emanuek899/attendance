<?php
require_once __DIR__ . '/../../utils/status.php';

class BaseManager {
private object $repo;

    public function __construct(MySQLRepositorie $repo){
        $this->repo = $repo;
    }

    public function createQuery(string $table, array $data): array{
        return $this->repo->insert($table, $data);
        
    }

    public function readQuery(string $table, array $conditions = [], array $cols = ['*'], array $joins = []): array{
        return $this->repo->select($table, $conditions, $cols, $joins);
    }

    public function updateQuery(string $table, array $data, array $conditions): array{
        return $this->repo->update($table, $data, $conditions);
    }

    public function deleteQuery(string $table, array $cond = []): array{
        return $this->repo->delete($table, $cond);
    }
}