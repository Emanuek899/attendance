<?php
require_once __DIR__ . '/../BaseManager.php';
require_once __DIR__ . '/../../../utils/DB_helpers.php';

class ClassesManager extends BaseManager{
    private Validator $val;
    private ClassroomsManager $rooms;
    const TABLE = 'classes';

    public function __construct(MySQLRepositorie $repo, Validator $val, ClassroomsManager $rooms){
        parent::__construct($repo);
        $this->val = $val;
        $this->rooms = $rooms;
    }
    
    /**
     * Creates a new class in the system
     * @param array $data The data to be created
     * @return array An array with the id of the last insertion
     */
    public function create(array $data): array{
        $newClass = $data['class_name'];
        $classroomIdToInsert = $data['class_classroom_id'];
        if($this->existByName($newClass)){
            return statusError(["The classroom $newClass already exists"], 400);
        } 
        if(!$this->rooms->existById($classroomIdToInsert)){
            return statusError(["The classroom with id $classroomIdToInsert does not exist"], 400);
        } 
        return parent::createQuery(self::TABLE, $data);
    }

    public function read(array $conditions = [], array $cols = ['*'], array $joins = []): array{
        return parent::readQuery(self::TABLE, $conditions, $cols);
    }

    public function update(array $data, array $conditions): array{
        if(!$this->existByConditions($conditions)){
            return statusError(['can\'t find the object to update'], 400);
        } 
        return parent::updateQuery(self::TABLE ,$data, $conditions);
    }

    public function delete(array $conditions = []): array{
        if($this->existByConditions($conditions)){
            return statusError(['can\'t find the object to delete'], 400);
        }
        return parent::deleteQuery(self::TABLE, $conditions);
    }

    public function existByName(string $class){
        $entity = parent::readQuery(
            self::TABLE,
            [
                [
                    'column' => 'class_name',
                    'op' => '=',
                    'val' => $class,
                    'boolean' => 'AND',
                ]
            ]
        );
        if(!empty($entity)) return true;
        return false;
    }

    public function existByConditions(array $conditions){
        $entity = parent::readQuery(self::TABLE, $conditions);
        if(!empty($entity)) return true;
        return false; 
    }
}