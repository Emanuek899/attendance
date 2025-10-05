<?php
require_once __DIR__ . '/../../Core/interfaces/Repo_interfaces/RolePermissions.php';
class RolePermissionsRepository implements RolePermissionsInterface{
    private MySQLdatabase $mysql;
    private string $table = 'role_permissions';

    public function __construct(MySQLdatabase $mysql){
        $this->mysql = $mysql;
    }

    public function select(array $conditions = [], array $cols = ['*']): array{
        return $this->mysql->find($this->table, $cols, $conditions);
    }    

    public function insert(array $data): bool{
        return $this->mysql->insert($this->table, $data);
    }

    public function update(array $data, array $cond): bool{
        return $this->mysql->update($this->table, $data, $cond);
    }

    public function delete(array $cond = []): bool{
        return $this->mysql->delete($this->table ,$cond);
    }
}