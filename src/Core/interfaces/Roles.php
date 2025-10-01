<?php
/**
 * Role interface to be implemented by RolesManager
 * @author Emanuel Santacruz
 * @version 1.0
 */
interface RoleInterface{
    public function select(array $cols, array $conditions): array;
    public function post(string $role): bool;
    public function delete(array $params): bool;
    public function update(array $data, array $conditions): bool;
}