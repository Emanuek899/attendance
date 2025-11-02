<?php
namespace Components\Services\Classes;
use Components\Services\BaseManager;
use Components\Repositories\MySQLRepositorie;
use Components\Services\Classrooms\ClassroomsManager;
// require_once __DIR__ . '/../../../utils/DB_helpers.php';
require_once __DIR__ . '/../../../utils/status.php';



class ClassesManager extends BaseManager{
    private ClassroomsManager $rooms;
    const TABLE = 'classes';

    public function __construct(MySQLRepositorie $repo, ClassroomsManager $rooms){
        parent::__construct($repo);
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
        if(!$this->existByConditions($conditions)){
            return statusError(['can\'t find the object to delete'], 404);
        }
        return parent::deleteQuery(self::TABLE, $conditions);
    }

    public function existByColumn(string $table, string $column, string $value){
        $conditions = [['column' => $column, 'op' => '=', 'val' => $value, 'boolean' => 'AND']];
        $entity = parent::readQuery($table, $conditions, [$column]);
        if(empty($entity)) return false;
        return true;
    }  

    public function existByName(string $class){
        if($this->existByColumn(self::TABLE, 'class_name', $class)) return true;
        return false;
    }

    public function existByConditions(array $conditions){
        $entity = parent::readQuery(self::TABLE, $conditions);
        if(!empty($entity)) return true;
        return false; 
    }
}