<?php
interface PermissionsInterface{
    public function select(array $conditions, array $cols): array;
    public function insert(string $permission): bool;
    public function update(array $data, array $conditions): bool;
    public function delete(array $conditions): bool;
}