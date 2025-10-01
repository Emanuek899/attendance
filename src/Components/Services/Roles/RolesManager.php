<?php
class RolesManager{
    private RolesRepository $rolesRepository;

    /**
     * Crea una instancia de RolesManager
     * @param
     * @return
     */
    public function __construct(RolesRepository $rolesRepository){
        $this->rolesRepository = $rolesRepository;
    }

    /**
     * Creates a new role in the system
     * @param
     * @return 
     */
    public function create(string $role): array{
        $exec = $this->rolesRepository->post($role);
        if($exec){
            return ['status' => true, 'data' => $role];
        } else { 
            return ['status' => false, 'data' => $role];  
        }
        exit;
    }

    /**
     * select sql query of roles in the system
     * @param   array $cols columns of the table [col1, col2]
     * @param   array $conditions Conditions of query [col1 => condVal]
     */
    public function read(array $conditions = [], array $cols = ['*']): array{
        return $this->rolesRepository->select($conditions, $cols);
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
        $exec = $this->rolesRepository->update($data, $conditions);
        return ['status' => $exec, 'message' => $exec ? 'creado' : 'fallo al crear'];
    }

    /**
     * Delete a role from the system
     * By id deletes the specific role
     * By role deletes all the entries with that role
     * @param array $params Params of the sql consult, by name
     */
    public function delete(array $conditions = []): array{
        $exec = $this->rolesRepository->delete($conditions);
        return ['status' => $exec, 'message' => $exec ? 'borrado' : 'fallo al borrar'];
    }
}
