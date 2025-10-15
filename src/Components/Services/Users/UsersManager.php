<?php
require_once __DIR__ . '/../BaseManager.php';
require_once __DIR__ . '/../../../utils/validator.php';
require_once __DIR__ . '/../../../utils/status.php';

class UsersManager extends BaseManager{
    private Validator $val;

    public function __construct(UsersRepository $repo, Validator $val){
        parent::__construct($repo);
        $this->val = $val;
    }

    public function create(array $data): array{
        return parent::create($data);
    }

    public function read(array $conditions = [], array $cols = ['*']): array{
        $users = parent::read($conditions, $cols);
        if(isset($users['errorCode'])){
            return status(false, '', 'database error', $users);
        }
        return parent::read($conditions, $cols);
    }
    
    public function update(array $data, array $conditions = []): array{
        return parent::update($data, $conditions);
    }

    public function delete(array $conditions = []): array{
        return parent::delete($conditions);
    }
}