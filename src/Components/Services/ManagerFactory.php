<?php
namespace Components\Services;
use Components\Repositories\MySQLRepositorie;
use Components\Services\Classrooms\ClassroomsManager;
use Components\Services\Classes\ClassesManager;

class ManagerFactory{
    private MySQLRepositorie $repo;

    public function __construct(MySQLRepositorie $mysql){
        $this->repo =  $mysql;
    }

    public function createManager(string $name){
        $name = ucfirst($name) . 'Manager';
        if(!class_exists("Components\\Services\\Classes\\$name")) return false;
        switch($name){
            case 'ClassesManager':
                $classroomsManager = new ClassroomsManager($this->repo);
                $manager = new ClassesManager($this->repo, $classroomsManager);
                return $manager;
        }
    }
}