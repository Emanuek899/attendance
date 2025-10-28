<?php
require_once __DIR__ . '/../BaseManager.php';
require_once __DIR__ . '/../../../utils/validator.php';
class ClassroomsManager extends BaseManager{
    private Validator $val;
    const TABLE = 'classrooms';

    public function __construct(MySQLRepositorie $repo, Validator $val){
        parent::__construct($repo);
        $this->val = $val;
    }
    
    public function create(array $data): array{
        return parent::createQuery(self::TABLE, $data);
    }

    public function read(array $conditions = [], array $cols = ['*']): array{
        return parent::readQuery(self::TABLE, $conditions, $cols);
    }

    public function update(array $data, array $conditions): array{
        return parent::updateQuery(self::TABLE, $data, $conditions);
    }

    public function delete(array $conditions = []): array{
        return parent::deleteQuery(self::TABLE, $conditions);
    }

    public function checkExistenceClassroomById(int $id){
        $conditions =[
            [
                'column' => 'classroom_id',
                'op' => '=',
                'val' => $id,
                'boolean' => 'AND',
            ]
        ];
        $cols = ['classroom_id'];
        $entity = parent::readQuery(self::TABLE, $conditions, $cols);
        if(!empty($entity)) return true;
        return false;
    }
}