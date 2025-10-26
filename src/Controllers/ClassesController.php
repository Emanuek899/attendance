<?php
require_once __DIR__ . '/../utils/Response.php';
require_once __DIR__ . '/BaseController.php';

/**
 * Controller responsible of validation of input data and make response with the
 * result of the call of classManager
 * @author Emanuel Santacruz Carbajal
 * @version V1.0
 */
class ClassesController extends BaseController{
    private Validator  $validator;

    public function __construct(ClassesManager $manager, Validator $validator){
        parent::__construct($manager);
        $this->validator = $validator;
    }

    /**
     * Call classManager and make a response with the all the classes
     * @param array $conditions Condition of the where sql sentence
     * @param array $cols Columns of the sql sentence
     * @return void 
     */
    public function getClasses(array $conditions = [], array $cols = ['*'], array $joins = []){
        $classes = parent::get($conditions, $cols, $joins);
        if(isset($classes['internal_code'])){
            Response::response($classes, 500);
            exit;
        }
        Response::response($classes, 200);
    }

    /**
     * Call classManager and make a response with the details of the creation of 
     * the new class
     * @param array $data The data of the new row in the database
     * @return void
     */
    public function insertClass(array $data){
        $class = parent::insert($data);
        if(isset($class['error'])){
            Response::response($class, $class['statusCode']);
            exit;
        }

        if(isset($class['internal_code'])){
            Response::response($class, 500);
            return;
        }
        Response::response(['class_id' => $class['data']['id']], 201);
    }

    /**
     * Call classManager and make a response with the details of the update of
     * the class
     * @param array $updatedData The new data to be uploaded
     * @param array $conditions The conditions of the sql where sentence
     * @return void
     */
    public function updateClass(array $updatedData, array $conditions){
        $class = parent::update($updatedData, $conditions);
        if(isset($class['error'])){
            Response::response($class, $class['statusCode']);
            exit;
        }
        Response::response($class, 201);
    }

    public function deleteclass(array $conditions){
        $class = parent::delete($conditions);
        if(isset($class['error'])){
            Response::response($class, $class['statusCode']);
            exit;
        }
        Response::response($class, 200);   
    }
}