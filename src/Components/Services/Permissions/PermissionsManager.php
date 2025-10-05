<?php
class PermissionsManager{
    private PermissionsRepository $repo;

    public function __construct(PermissionsRepository $repository){
        $this->repo = $repository;
    }


    public function create(array $data): array{
        $exec = $this->repo->insert($data);
        return [
            'status' => $exec,
            'message' => $exec ? 'creado exitoso' : 'error al crear',
            'data' => $data
        ];
    }

    public function read(array $conditions = [], array $cols = ['*']){
        return $this->repo->select($conditions, $cols);
    }

    public function update(array $data, array $conditions){
        $exec = $this->repo->update($data, $conditions);
        return [
            'status' => $exec,
            'message' => $exec ? 'modificado exitoso' : 'error al modificar',
            'data' => $data,
        ];
    }

    public function delete(array $conditions){
        $exec = $this->repo->delete($conditions);
        return [
            'status' => $exec,
            'message' => $exec ? 'eliminado exitoso' : 'error al eliminar',
            'conditions' => $conditions,
        ];
    }
}