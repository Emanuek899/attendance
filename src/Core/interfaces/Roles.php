<?php
interface RoleInterface{
    public function readAll(): array;
    public function read(array $params): array;
    public function create(string $role): void;
    public function delete(array $params): void;
    public function update(array $params): void;
}