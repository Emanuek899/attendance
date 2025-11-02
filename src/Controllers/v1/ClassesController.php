<?php
namespace Controllers\v1;
use Components\Services\Classes\ClassesManager;
use Controllers\v1\BaseController;
use Utils\Response;
use Core\interfaces\ControllerInterface;

require_once __DIR__ . '/../../utils/Response.php';
require_once __DIR__ . '/BaseController.php';

/**
 * Controller responsible of validation of input data and make response with the
 * result of the call of classManager
 * @author Emanuel Santacruz Carbajal
 * @version V1.0
 */
class ClassesController extends BaseController implements ControllerInterface{

    public function __construct(ClassesManager $manager){
        parent::__construct($manager);
        // $this->validator = $validator;
    }

     public function getAll(): void{
        $classes = parent::get();
        Response::response($classes, 200);
    }   

    public function getById(int $classId){
        $condition = [['column' => 'class_id','omethod,p' => '=','val' => $classId,'boolean' => 'AND',]];
        $classes = parent::get($condition);
        Response::response($classes, 200);
    }

    public function getByClass(string $className){
        $formatted = str_replace('-', ' ', strtolower($className));
        $condition = [['column' => 'class_name','op' => '=','val' => $formatted,'boolean' => 'AND',]];
        $classes = parent::get($condition);
        Response::response($classes, 200);
    }

    public function newClass(array $data,){
        $class = parent::insert($data);
        if(isset($class['error'])){
            Response::response($class, $class['statusCode']);
            exit;
        }
        Response::response($class, 201);

    }

    /**
     * Call classManager and make a response with the details of the update of
     * the class
     * @param array $updatedData The new data to be uploaded
     * @param array $conditions The conditions of the sql where sentence
     * @return void
     */
    public function updateClassById(int $classId, array $data){
        $conditions = [['column' => 'class_id', 'op' => '=', 'val' => $classId, 'boolean' => 'AND']];
        $class = parent::update($data, $conditions);
        Response::response($class, 201);
    }

    public function deleteById(int $id){
        $conditions =[['column' => 'class_id', 'op' => '=', 'val' => $id, 'boolean' => 'AND']];
        $class = parent::delete($conditions);
        if(isset($class['error'])){
            Response::response($class, $class['statusCode']);
            exit;
        }
        Response::response($class, 200);   
    }

    public function deterAction(string $method, $action, $params): array{
        return match (true) {
                        $method === 'GET' && is_numeric($action) => ['getById', [$action]],
                        $method === 'GET' && is_string($action) => ['getByClass', [$action]],
                        $method === 'GET' && $action === null => ['getAll', []],
                        $method === 'POST' => ['newClass', [$params['newData']]],
                        $method === 'PUT' && is_numeric($action) => ['updateClassById', [$action, $params['updatedData']]],
                        $method === 'DELETE' && is_numeric($action) => ['deleteById', [$action]],
                    };
    }
}