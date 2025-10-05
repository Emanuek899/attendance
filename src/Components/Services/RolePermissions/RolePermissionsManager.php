<?php
require_once __DIR__ . '/../../../utils/status.php';
class RolePermissionsManager{
    private RolePermissionsRepository $repo;

    public function __construct(RolePermissionsRepository $repo){
        $this->repo = $repo;
    }

    public function create(array $data): array{
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