<?php
require_once __DIR__ . '/../../Core/interfaces/Repo_interfaces/MySQLRepositorieInterface.php';

class MySQLRepositorie implements MySQLRepositorieInterface{
    private MySQLdatabase $mysql;

    public function __construct(MySQLdatabase $mysql){
        $this->mysql = $mysql;
    }

    public function insert(string $table, array $data): array{
        return $this->mysql->table($table)->vals($data)->insert();
    }

    public function select(string $table,array $conditions = [], array $cols = ['*']): array{
        return $this->mysql->table($table)->columns($cols)->where($conditions)->find();
    }

    public function update(string $table, array $data, array $conditions): array{
        return $this->mysql->table($table)->where($conditions)->vals($data)->update();
    }

    public function delete(string $table, array $conditions = []): array{
        return $this->mysql->delete($table, $conditions);
    }
}