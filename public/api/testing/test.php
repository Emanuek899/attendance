<?php

class ApiTest{
    private object $manager;

    public function __construct(object $instance){
        $this->manager = $instance;
    }

    public function api(array $data, string $method){
        switch ($method){
            case 'GET':
                $roles = $this->manager->read([$data['col_cond'] => [$data['op'], $data['val']]]);
                if(empty($roles)){
                    Response::response($roles, 200);
                    // Response::response($all, 200);
                } else {
                    Response::response($roles, 201);

                }
                break;
            
            case 'POST':
                $newRole = $this->manager->create($data['roleName']);
                $status = $newRole['status'];
                if($status){
                    Response::response($newRole, 200);
                }else{
                    Response::response($newRole, 400);
                }
                break;
            
            case 'PUT':
                $editRole = $this->manager->update($data['new'], $data['cond']);
                $status = $editRole['status'];
                if($status){
                    Response::response($editRole, 200);
                }else{
                    Response::response($editRole, 400);
                }
                break;
            
            case 'DELETE':
                $editRole = $this->manager->delete($data['cond']);
                $status = $editRole['status'];
                if($status){
                    Response::response($editRole, 200);
                }else{
                    Response::response($editRole, 400);
                }
                break;
        }
    }
    
}