<?php
interface MySQLRepositorieInterface{
    public function select(string $table, array $conditions, array $cols): array;
    public function insert(string $table, array $data): array;
    public function update(string $table, array $data, array $conditions): array;
    public function delete(string $table, array $conditions): array;
}