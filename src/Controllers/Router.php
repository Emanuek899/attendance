<?php
namespace Controllers;
use Components\Services\ManagerFactory;
use Components\Repositories\MySQLRepositorie;
use Utils\Response;
/**
 * class to work with routing to api front api controller
 */
require_once __DIR__ . '/../../vendor/autoload.php';

class Router{
    private string $basePath;
    private string $controller;
    private array $recources = ['classes'];
    private MySQLRepositorie $mysql;
    private ManagerFactory $factory;
    
    public function __construct(string $basePath, MySQLRepositorie $mysql, ManagerFactory $factory){
        $this->basePath = trim($basePath, '/');
        $this->mysql = $mysql;
        $this->factory = $factory;
    }

    /**
     * sanitize and give a format to the url to be used
     */
    public function resolveUrl(string $basePath, string $requestURI){
        $cleanURL = str_replace("$basePath/", '', strtok($requestURI, '?'));
        return explode('/', $cleanURL);
    }

    private function importController(string $controllerName, string $version){
        $controllerPath = __DIR__ . "/$version/{$controllerName}.php";
        if(file_exists($controllerPath)){
            return true;
        }
        return false;
    }

    /**
     * create the manager of the required service by use of the factory
     */
    private function createManagerInstance(string $managerName){
        return $this->factory->createManager($managerName);
    }

    /**
     * Give a format to assing to the controller
     */
    private function formatControllerName(string $unformatName){
        $formatedName = ucfirst($unformatName) . 'Controller';
        return $formatedName;
    }

    /**
     * Create the controller of the required manager and service
     */
    private function createControllerInstance(string $recourse, string $version){
        if(!in_array($recourse, $this->recources)){
            Response::response(['error' => 'resource not allowed'], 403);
            exit;
        }
        if(!$this->createManagerInstance(ucfirst($recourse))){
            Response::response(['error' => 'manager not found'], 404);
            exit;
        };
        $manager = $this->createManagerInstance($recourse);
        $controllerName = $this->formatControllerName($recourse);
        $fqcn = "\\Controllers\\$version\\$controllerName";
        if(!class_exists($fqcn)) {
            Response::response(['error' => 'controller class not found'], 404);
            exit;
        }
        return new $fqcn($manager);
    }

    private function determineAction(object $controller, string $method, $action, $params){
        return $controller->deterAction($method, $action, $params);
    }

    public function router(string $requestURI){
        $cleanURL = $this->resolveUrl($this->basePath, $requestURI);
        $version = isset($cleanURL[2]) ? $cleanURL[2] : null;
        $recourse = isset($cleanURL[3]) ? $cleanURL[3] : null;
        $action = isset($cleanURL[4]) ? $cleanURL[4] : null;
        $body = json_decode(file_get_contents('php://input'), true);
        
        $controller = $this->createControllerInstance($recourse, $version);
        $method = $_SERVER['REQUEST_METHOD'];
        $actionDeter = $this->determineAction($controller, $method, $action, $body);

        if(method_exists($controller, $actionDeter[0])){
            call_user_func_array([$controller, $actionDeter[0]], $actionDeter[1]);
        } else{
            Response::response(['not found'], 404);
            exit;
        }

    }
}