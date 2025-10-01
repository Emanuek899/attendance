<?php
/**
 * Database interface to be implemented by database clases
 * @author Emanuel Santacruz
 * @version 1.0
 */
interface Database {
    public function find(string $table, array $cols, array $conditions ): array;
    public function insert(string $table, array $data): bool;
    public function update(string $table, array $data, array $conditions): bool;
    public function delete(string $table, array $conditions): bool;
}