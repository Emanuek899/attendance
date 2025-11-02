<?php
require_once __DIR__ . '/../BaseManager.php';
class GradesManager extends BaseManager{
    private Validator $val;
    const TABLE = 'grade_name';

    public function __construct(MySQLRepositorie $repo, Validator $val){
        parent::__construct($repo);
        $this->val = $val;
    }
    
    public function create(array $data): array{
        $newGrade = $data['grade_name'];
        if($this->existByGrade($newGrade)) return existentEntity($newGrade);
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

    public function existByGrade(string $grade){
        $conditions = [['column' => '', 'op' => '=', 'val' => $grade, 'bool' => 'AND']];
        $columns = ['grade_name'];
        $group = parent::readQuery(self::TABLE, $conditions, $columns);
        if(!empty($group)) return true;
        return false;
    }
}