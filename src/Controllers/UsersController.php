<?php
require_once __DIR__ . '/../utils/Response.php';
require_once __DIR__ . '/BaseController.php';
class UsersController extends BaseController{
    private Validator  $validator;

    public function __construct(UsersManager $manager, Validator $validator){
        parent::__construct($manager);
        $this->validator = $validator;
    }

    public function getUsers(array $conditions = [], array $cols = ['*']){
        $users = parent::get($conditions, $cols);
        if(isset($users['internal_code'])){
            Response::response($users, 400);
            return;
        }
        Response::response($users, 200);
    }
}