<?php
require_once __DIR__ . '/../BaseManager.php';
require_once __DIR__ . '/../../../utils/validator.php';
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
        $classroom = $this->rooms->findById($classroomId);
        if(empty($classroom)) return statusError(["The classroom with id $classroomId does not exist"], 400);
        $class = parent::readQuery(
            self::TABLE,
            [
                [
                    'column' => 'class_name',
                    'op' => '=',
                    'val' => $newClass,
                    'boolean' => 'AND',
                ]
            ],
            ['class_name']
        );
        if(!empty($class)) return statusError(["the parameter $newClass already exists"], 400);
        return parent::createQuery(self::TABLE, $data);
    }

    public function read(array $conditions = [], array $cols = ['*'], array $joins = []): array{
        return parent::readQuery(self::TABLE, $conditions, $cols);
    }

    public function update(array $data, array $conditions): array{
        $class = parent::updateQuery(self::TABLE ,$data, $conditions);
        if(isset($class['details'])){
            $errors = $this->val->validate(
                ["DB_Code_Error" => $class],
                ['DB_Code_Error' => 'DBCodeError']
            );
        }
        if(!empty($errors)) return statusError($errors, 500);
        return $class;
    }

    public function delete(array $conditions = []): array{
        return parent::deleteQuery(self::TABLE, $conditions);
    }
}