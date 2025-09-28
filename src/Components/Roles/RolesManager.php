<?php
class RolesManager implements RoleInterface{
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
    public function create(string $role): void{
        $sql = "INSERT INTO roles(role) values(:role)";
        $this->mysql->ejecutar($sql, [':role' => $role]);
    }

    /**
     * Select all the roles in the system to see
     */
    public function readAll(): array{
        $sql = "SELECT * FROM roles";
        return $this->mysql->consultar($sql);
    }

    /**
     * Select a role in the system
     * @param array $params Params for sql consult, [id =>, role=>]
     */
    public function read(array $params): array{
        $sql = "
            SELECT * FROM roles 
            WHERE (:roleId IS NULL OR id = :roleId)
                AND (:role IS NULL OR role = :role)";
        return $this->mysql->consultar($sql, [
            ':roleId' => $params['id'] ?? NULL,
            ':role'   => $params['role'] ?? NULL
        ]);
    }

    /** 
     * Update a role in the system
     * By id only updates the specific role
     * By role updates all the entries with that role
     * @param
     * @return
    */
    public function update(array $params): void{
        $sql = "
            UPDATE roles SET role = :newRole
            WHERE (:oldRole IS NULL OR role = :oldRole)
            AND   (:roleId IS NULL OR id = :roleId)";
        $this->mysql->ejecutar($sql, [
            ':roleId'  => $params['id'] ?? NULL,
            ':oldRole' => $params['oldRole'] ?? NULL,
            ':newRole' => $params['newRole'] ?? NULL,
        ]);
    }

    /**
     * Delete a role from the system
     * By id deletes the specific role
     * By role deletes all the entries with that role
     * @param array $params Params of the sql consult, by name
     */
    public function delete(array $params): void{
        $sql = "
            DELETE FROM roles WHERE 
            (:roleId IS NULL OR id = :roleId)
            AND (:role IS NULL OR role = :role)";
        $this->mysql->ejecutar($sql, [
            ':roleId' => $params['id'] ?? NULL,
            ':role'   => $params['role'] ?? NULL
        ]);
    }
}
