<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../Components/Services/Roles/RolesManager.php';
require_once __DIR__ . '/../../Config/connection.php';
require_once __DIR__ . '/../../utils/Response.php';
require_once __DIR__ . '/../../Components/Repositories/Roles.php';

$data = json_decode(file_get_contents('php://input'), true);
$method = $_SERVER["REQUEST_METHOD"];
$repo = new RolesRepository($db); 
$rolesManager = new RolesManager($repo);

switch ($method){
    case 'GET':
        $roles = $rolesManager->read([$data['col_cond'] => [$data['op'], $data['val']]]);
        if(empty($roles)){
            Response::response($roles, 200);
            // Response::response($all, 200);
        } else {
            Response::response($roles, 201);

        }
        break;
    
    case 'POST':
        $newRole = $rolesManager->create($data['roleName']);
        $status = $newRole['status'];
        if($status){
            Response::response($newRole, 200);
        }else{
            Response::response($newRole, 400);
        }
        break;
    
    case 'PUT':
        $editRole = $rolesManager->update($data['new'], $data['cond']);
        $status = $editRole['status'];
        if($status){
            Response::response($editRole, 200);
        }else{
            Response::response($editRole, 400);
        }
        break;
    
        case 'DELETE':
            $editRole = $rolesManager->delete($data['cond']);
            $status = $editRole['status'];
            if($status){
                Response::response($editRole, 200);
            }else{
                Response::response($editRole, 400);
            }
            break;
}


// $all = $rolesManager->delete(['role_id' => $data['role_id']]);




