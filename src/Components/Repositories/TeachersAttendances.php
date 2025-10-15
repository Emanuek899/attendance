<?php
require_once __DIR__ . '/../../Core/interfaces/Repo_interfaces/TeachersAttendances.php';

class TeachersAttendancesRepository implements TeachersAttendancesInterface{
    private MySQLdatabase $mysql;
    private const TABLE = 'grades';

    public function __construct(MySQLdatabase $mysql){
        $this->mysql = $mysql;
    }

    public function insert(array $data): bool{
        return $this->mysql->insert(self::TABLE, $data);
    }

    public function select(array $conditions = [], array $cols = ['*']): array{
        return $this->mysql->find(self::TABLE, $cols, $conditions);
    }

    public function update(array $data, array $conditions): bool{
        return $this->mysql->update(self::TABLE, $data, $conditions);
    }

    public function delete(array $conditions = []): bool{
        return $this->mysql->delete(self::TABLE, $conditions);
    }
}