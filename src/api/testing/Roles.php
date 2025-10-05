<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../Config/connection.php';
require_once __DIR__ . '/../../utils/Response.php';

$url = $_SERVER['REQUEST_URI'];
$route = explode('/', $url);
$manager = 'Permissions.php';

switch($manager){
    case 'Roles.php':
        require_once __DIR__ . '/../../Components/Services/Roles/RolesManager.php';
        require_once __DIR__ . '/../../Components/Repositories/Roles.php';
        $repo = new RolesRepository($db);
        $manager = new RolesManager($repo); 
        break;
    
    case 'Permissions.php':
        require_once __DIR__ . '/../../Components/Services/Permissions/PermissionsManager.php';
        require_once __DIR__ . '/../../Components/Repositories/Permissions.php';
        $repo = new PermissionsRepository($db);
        $manager = new PermissionsManager($repo); 
        break;
}

$json = json_decode(file_get_contents('php://input'), true);
$method = $_SERVER["REQUEST_METHOD"];

/**
 * falta validacion de json, a trabajar en un futuro un componente
 * Por el momento sin validacion de json, json hardcode
*/
switch ($method){
    case 'GET':
        $data = $manager->read(empty($json) ? [] : $json['cond']);
        if(empty($data)){
            Response::response($data, 200);
            // Response::response($all, 200);
        } else {
            Response::response($data, 201);

        }
        break;
    
    case 'POST':
        $data = $manager->create($json['permName']);
        $status = $data['status'];
        if($status){
            Response::response($data, 200);
        }else{
            Response::response($data, 400);
        }
        break;
    
    case 'PUT':
        $data = $manager->update($json['new'], $json['cond']);
        $status = $data['status'];
        if($status){
            Response::response($data, 200);
        }else{
            Response::response($data, 400);
        }
        break;
    
    case 'DELETE':
        $data = $manager->delete($json['cond']);
        $status = $data['status'];
        if($status){
            Response::response($data, 200);
        }else{
            Response::response($data, 400);
        }
        break;
}


// $all = $rolesManager->delete(['role_id' => $json['role_id']]);




