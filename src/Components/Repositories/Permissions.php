<?php
require_once __DIR__ . '/../../Core/interfaces/Repo_interfaces/Permissions.php';
class PermissionsRepository implements PermissionsInterface{
    private MySQLdatabase $mysql;

    public function __construct(MySQLdatabase $db){
        $this->mysql = $db;
    }

    /**
     * select sql query
     * @param array $conditions WHERE conditions for clausule.
     *              Example [colName => [op, val]]
     * @param array $cols Columns of the query.
     * @return array Returns an array with data if there is, or an empty array
     *               if there is no data to pull.
     */
    public function select(array $conditions = [], array $cols = ['*']): array{
        return $this->mysql->find('permissions', $cols, $conditions);
    }

    /**
     * insert sql query
     * @param string $permission Permission to insert in the database.
     * @return bool Returns if the operation was succesfull
     */
    public function insert(string $permission): bool{
        return $this->mysql->insert('permissions', ['permission' => $permission]);
    }

    public function update(array $data, array $conditions): bool{
        return $this->mysql->update('permissions', $data, $conditions);
    }

    public function delete(array $conditions): bool{
        return $this->mysql->delete('permissions', $conditions);
    }
}