<?php
require_once __DIR__ . '/../BaseManager.php';
class RolePermissionsManager extends BaseManager{
    private Validator $val;


    public function __construct(RolePermissionsRepository $repo, Validator $val){
        parent::__construct($repo);
        $this->val = $val;
    }

    public function create(array $data): array{
        /* $rules = ['role_id' => 'Integer', 'permission_id' => 'Integer'];
        $validation = $this->val->validate($data, $rules);
        if(!empty($validation)){
            return status(false, 'no mensaje', 'error en tipo de datos', $validation);
        } */
        return parent::create($data);
    }

    public function read(array $conditions = [], array $cols = ['*']): array{
        return parent::read($conditions, $cols);
    }

    public function update(array $data, array $conditions): array{
        return parent::update($data, $conditions);
    }

    public function delete(array $cond = []): array{
        return parent::delete($cond);
    }
}