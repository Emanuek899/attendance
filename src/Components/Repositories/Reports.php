<?php
require_once __DIR__ . '/../../Core/interfaces/Repo_interfaces/Reports.php';
class ReportsRepository implements ReportsInterface{
    private MySQLdatabase $mysql;
    private string $table = 'reports';

    public function __construct(MysQLdatabase $mysql){
        $this->mysql = $mysql;
    }

    public function select(array $cond = [], array $cols = ['']): array{
        return $this->mysql->find($this->table, $cols, $cond);
    }

    public function insert(array $data): bool{
        return $this->mysql->insert($this->table, $data);
    }

    public function update(array $data, array $cond): bool{
        return $this->mysql->update($this->table, $data, $cond);
    }
    
    public function delete(array $cond): bool{
        return $this->mysql->delete($this->table, $cond);
    }

}