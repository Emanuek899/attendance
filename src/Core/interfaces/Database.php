<?php
/**
 * Database interface to be implemented by database clases
 * @author Emanuel Santacruz
 * @version 1.0
 */
interface Database {
    public function find(string $table, array $cols, array $conditions, bool $or): array;
    public function insert(string $table, array $data): array;
    public function update(string $table, array $data, array $conditions): array;
    public function delete(string $table, array $conditions): array;
}