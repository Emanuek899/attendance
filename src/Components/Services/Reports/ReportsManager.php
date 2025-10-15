<?php
require_once __DIR__ . '/../../../utils/status.php';
class ReportsManager{
    private ReportsRepository $repo;
    private Validator $val;

    public function __construct(ReportsRepository $repo, Validator $val){
        $this->repo = $repo;
        $this->val = $val;
    }

    public function create(array $data): array{
        $exec = $this->repo->insert($data);
        return status($exec, 'creado con exito', 'error al crear', $data); 
    }

    public function read(array $cond = [], array $cols = ['*']): array{
        return $this->repo->select($cond, $cols);
    }   

    public function update(array $data, array $cond): array{
        $exec = $this->repo->update($data, $cond);
        return status($exec, 'modificado exitosamente', 'error al modificar', $data);
    }

    public function delete(array $cond): array{
        $exec = $this->repo->delete($cond);
        return status($exec, 'eliminado exitosamens', 'error al eliminar', $cond);
    }
}