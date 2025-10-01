<?php
require_once __DIR__ . '/../../Core/interfaces/Roles.php';
class RolesRepository implements RoleInterface{
    private MySQLdatabase $mysql;

    /**
     * Crea una instancia de RolesManager
     * @param
     * @return
     */
    public function __construct(MySQLdatabase $mysql){
        $this->mysql = $mysql;
    }

    /**
     * Creates a new role in the system
     * @param
     * @return 
     */
    public function post(string $role): bool{
        return $this->mysql->insert('roles', ['role' => $role]);
    }

    /**
     * select sql query of roles in the system
     * @param   array $cols columns of the table [col1, col2]
     * @param   array $conditions Conditions of query [col1 => condVal]
     */
    public function select(array $conditions = [], array $cols = ['*']): array{
        return $this->mysql->find('roles', $cols, $conditions);
    }

    /** 
     * Update a role in the system
     * By id only updates the specific role
     * By role updates all the entries with that role
     * @param
     * @return
    */
    public function update(array $data, array $conditions): bool{
        return $this->mysql->update('roles', $data, $conditions);
    }

    /**
     * Delete a role from the system
     * By id deletes the specific role
     * By role deletes all the entries with that role
     * @param array $params Params of the sql consult, by name
     */
    public function delete(array $conditions = []): bool{
        return $this->mysql->delete('roles', $conditions);
    }
}
