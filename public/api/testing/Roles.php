<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); 

require_once __DIR__ . '/../../../src/Config/connection.php';
require_once __DIR__ . '/../../../src/utils/Response.php';
require_once __DIR__ . '/../../../src/utils/validator.php';

$url = $_SERVER['REQUEST_URI'];
$route = explode('/', $url);
$json = json_decode(file_get_contents('php://input'), true);
$file = isset($json['file']) ? $json['file'] : null;
$val = new Validator;

function pull($route1, $route2, $route3){
    require_once __DIR__ . $route1;
    require_once __DIR__ . $route2;    
    require_once __DIR__ . $route3;    
}

function objs($manager, $db, $val){
    $repoClass = $manager . 'Repository';
    $managerClass = $manager . 'Manager';
    $controllerClass = $manager . 'Controller'; 
    $repo = new $repoClass($db);
    $manager = new $managerClass($repo, $val); 
    $controller = new $controllerClass($manager, $val);
    return $controller;
}

switch($file){
/*     case 'Roles':
        pull('/../../Components/Services/Roles/RolesManager.php', '/../../Components/Repositories/Roles.php');
        break;
    
    case 'Permissions':
        pull('/../../Components/Services/Permissions/PermissionsManager.php', '/../../Components/Repositories/Permissions.php');
        break;

    case 'RolePermissions':
        pull('/../../Components/Services/RolePermissions/RolePermissionsManager.php', '/../../Components/Repositories/RolePermissions.php');
        break;

    case 'Reports':
        pull('/../../Components/Services/Reports/ReportsManager.php', '/../../Components/Repositories/Reports.php');
        break;

    case 'Sections':
        pull('/../../../src/Components/Services/Reports/ReportsManager.php', '/../../../src/Components/Repositories/Reports.php');
        break;     */    
    
    case 'Users':
        pull('/../../../src/Components/Services/Users/UsersManager.php', 
             '/../../../src/Components/Repositories/Users.php',
             '/../../../src/Controllers/UsersController.php');
        break;
        
    default:
        Response::response([
            'no tienes acceso papu si no especificas file XD o hay error de formato en json'
        ], 404);
        exit;
}

$controller = objs($file, $db, $val);
$method = $_SERVER["REQUEST_METHOD"];

/**
 * falta validacion de json, a trabajar en un futuro un componente
 * Por el momento sin validacion de json, json hardcode
*/
switch ($method){
    case 'GET':
        $queryConditions = isset($json['queryConditions']) ? $json['queryConditions'] : [];
        $queryColumns = isset($json['queryColumns']) ? $json['queryColumns'] : [];
        $inputData = [
            'queryColumns'    => $queryColumns
        ];
        $inputRules = [
            'queryColumns'   => 'Empty'
        ];
        $errors = $val->validate($inputData, $inputRules);
        if(!empty($errors)){
            Response::response($errors, 400);
        }
        $controller->getUsers($queryConditions, $queryColumns);
        break;
    
    case 'POST':
        $newData = isset($json['data']) ? $json['data'] : [];
        $data = $manager->create($json['data']);
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
        $data = $manager->delete($json['cond'] ?? []);
        $status = $data['status'];
        if($status){
            Response::response($data, 200);
        }else{
            Response::response($data, 400);
        }
        break;
}


// $all = $rolesManager->delete(['role_id' => $json['role_id']]);




