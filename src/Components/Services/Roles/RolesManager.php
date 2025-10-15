<?php
require_once __DIR__ . '/../BaseManager.php';

class RolesManager extends BaseManager{
    private Validator $val;
    /**
     * Crea una instancia de RolesManager
     * @param
     * @return
     */
    public function __construct(RolesRepository $rolesRepository, Validator $val){
        parent::__construct($rolesRepository);
        $this->val = $val;
    }

    /**
     * Creates a new role in the system
     * @param
     * @return 
     */
    public function create(array $data): array{
        return parent::create($data);
    }

    /**
     * select sql query of roles in the system
     * @param   array $cols columns of the table [col1, col2]
     * @param   array $conditions Conditions of query [col1 => condVal]
     */
    public function read(array $conditions = [], array $cols = ['*']): array{
        return parent::read($conditions, $cols);
    }

    /** 
     * Update a role in the system
     * By id only updates the specific role
     * By role updates all the entries with that role
     * @param array $data format [colName => val]
     * @param array $conditions [colName => [op, val]]
     * @return
    */
    public function update(array $data, array $conditions): array{
        return parent::update($data, $conditions);
    }

    /**
     * Delete a role from the system
     * By id deletes the specific role
     * By role deletes all the entries with that role
     * @param array $params Params of the sql consult, by name
     */
    public function delete(array $conditions = []): array{
        return parent::delete($conditions);
    }
}
