<?php
require_once __DIR__ . '/../utils/Response.php';
require_once __DIR__ . '/BaseController.php';

/**
 * Controller responsible of validation of input data and make response with the
 * result of the call of userManager
 * @author Emanuel Santacruz Carbajal
 * @version V1.0
 */
class UsersController extends BaseController{
    private Validator  $validator;

    public function __construct(UsersManager $manager, Validator $validator){
        parent::__construct($manager);
        $this->validator = $validator;
    }

    /**
     * Call userManager and make a response with the all the users
     * @param array $conditions Condition of the where sql sentence
     * @param array $cols Columns of the sql sentence
     * @return void 
     */
    public function getUsers(array $conditions = [], array $cols = ['*']){
        $users = parent::get($conditions, $cols);
        if(isset($users['internal_code'])){
            Response::response($users, 500);
            exit;
        }
        Response::response($users, 200);
    }

    /**
     * Call userManager and make a response with the details of the creation of 
     * the new user
     * @param array $data The data of the new row in the database
     * @return void
     */
    public function insertUser(array $data){
        $user = parent::insert($data);
        if(isset($user['error'])){
            Response::response($user, $user['statusCode']);
            exit;
        }

        if(isset($user['internal_code'])){
            Response::response($user, 500);
            return;
        }
        Response::response($user, 201);
    }

    /**
     * Call userManager and make a response with the details of the update of
     * the user
     * @param array $updatedData The new data to be uploaded
     * @param array $conditions The conditions of the sql where sentence
     * @return void
     */
    public function updateUser(array $updatedData, array $conditions){
        $user = parent::update($updatedData, $conditions);
        if(isset($user['error'])){
            Response::response($user, $user['statusCode']);
            exit;
        }
        Response::response($user, 201);
    }

    public function deleteUser(array $conditions){
        $user = parent::delete($conditions);
        if(isset($user['error'])){
            Response::response($user, $user['statusCode']);
            exit;
        }
        Response::response($user, 200);   
    }
}