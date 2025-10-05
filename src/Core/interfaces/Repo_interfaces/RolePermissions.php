<?php
interface RolePermissionsInterface{
    public function select(array $conditions, array $cols): array;
    public function insert(array $data): bool;
    public function update(array $data, array $cond): bool;
    public function delete(array $cond): bool;
}