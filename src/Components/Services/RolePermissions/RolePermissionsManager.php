<?php
require_once __DIR__ . '/../../../utils/status.php';

class RolePermissionsManager{
    private RolePermissionsRepository $repo;
    private Validator $val;


    public function __construct(RolePermissionsRepository $repo, Validator $val){
        $this->repo = $repo;
        $this->val = $val;
    }

    public function create(array $data): array{
        $rules = ['role_id' => 'Integer', 'permission_id' => 'Integer'];
        $validation = $this->val->validate($data, $rules);
        if(!empty($validation)){
            return status(false, 'no mensaje', 'error en tipo de datos', $validation);
        }
        $exec = $this->repo->insert($data);
        return status($exec, 'creado exitosamente', 'error al crear', $data);
    }

    public function read(array $conditions = [], array $cols = ['*']): array{
        return $this->repo->select($conditions, $cols);
    }

    public function update(array $data, array $conditions): array{
        $exec = $this->repo->update($data, $conditions);
        return status($exec, 'modificado exitoso', 'error al modificar', $data);
    }

    public function delete(array $cond = []): array{
        $exec = $this->repo->delete($cond);
        return status($exec, 'borrado exitoso', 'error al borrar', $cond);
    }
}