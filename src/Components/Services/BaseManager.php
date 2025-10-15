<?php
require_once __DIR__ . '/../../utils/status.php';


class BaseManager {
private object $repo;

    public function __construct(object $repo){
        $this->repo = $repo;
    }

    public function create(array $data): array{
        return $this->repo->insert($data);
        
    }

    public function read(array $conditions = [], array $cols = ['*']): array{
        return $this->repo->select($conditions, $cols);
    }

    public function update(array $data, array $conditions): array{
        return $this->repo->update($data, $conditions);
    }

    public function delete(array $cond = []): array{
        return $this->repo->delete($cond);
    }
}