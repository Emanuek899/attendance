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
        $classroomId = $data['class_classroom_id'];
        if($this->checkExistenceClassByName($newClass)){
            return statusError(["The classroom $newClass already exists"], 400);
        } 
        if($this->rooms->checkExistenceClassroomById($classroomId)){
            return statusError(["The classroom with id $classroomId does not exist"], 400);
        } 

        return parent::createQuery(self::TABLE, $data);
    }

    public function read(array $conditions = [], array $cols = ['*'], array $joins = []): array{
        return parent::readQuery(self::TABLE, $conditions, $cols);
    }

    public function update(array $data, array $conditions): array{
        $existingClass = parent::readQuery(self::TABLE, $conditions);
        if(empty($existingClass)) return statusError(['can\'t find the object to update'], 400);
        $class = parent::updateQuery(self::TABLE ,$data, $conditions);

        return $class;
    }

    public function delete(array $conditions = []): array{
        $existingClass = parent::readQuery(self::TABLE, $conditions);
        if(empty($existingClass)) return statusError(['can\'t find the object to delete'], 400);
        return parent::deleteQuery(self::TABLE, $conditions);
    }

    public function checkExistenceClassByName(string $class){
        $entity = parent::readQuery(
            self::TABLE,
            [
                [
                    'column' => 'class_name',
                    'op' => '=',
                    'val' => $class,
                    'boolean' => 'AND',
                ]
            ],
            ['class_name']
        );
        if(!empty($entity)) return true;
        return false;
    }
}