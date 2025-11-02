<?php
namespace Components\Services\Classrooms;
use Components\Services\BaseManager;
use Components\Repositories\MySQLRepositorie;

require_once __DIR__ . '/../../../utils/validator.php';
class ClassroomsManager extends BaseManager{
    const TABLE = 'classrooms';

    public function __construct(MySQLRepositorie $repo){
        parent::__construct($repo);
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

    public function existById(int $id){
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

    public function existBygradeId(int $gradeId){
        // technical debt, logic is used in existBySectionId and existById refactor pending
        $conditions =[
            [
                'column' => 'classroom_grade_id',
                'op' => '=',
                'val' => $gradeId,
                'boolean' => 'AND',
            ]
        ];
        $cols = ['classroom_grade_id'];
        $entity = parent::readQuery(self::TABLE, $conditions, $cols);
        if(!empty($entity)) return true;
        return false;
    }    

    public function existBySectionId(int $sectionId){
        $conditions =[
            [
                'column' => 'classroom_section_id',
                'op' => '=',
                'val' => $sectionId,
                'boolean' => 'AND',
            ]
        ];
        $cols = ['classroom_section_id'];
        $entity = parent::readQuery(self::TABLE, $conditions, $cols);
        if(!empty($entity)) return true;
        return false;
    }   
    
    public function getAll(): array{
        return $this->read();
    }
}