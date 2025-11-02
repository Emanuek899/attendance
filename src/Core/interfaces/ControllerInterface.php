<?php
namespace Core\Interfaces;

interface ControllerInterface{
    public function getAll(): void;
    public function deterAction(string $method, $action, $params): array;
}