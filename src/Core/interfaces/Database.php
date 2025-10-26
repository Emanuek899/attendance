<?php
/**
 * Database interface to be implemented by database clases
 * @author Emanuel Santacruz
 * @version 1.0
 */
interface Database {
    public function table(string $table);
    public function columns(array $columns);
    public function where(array $conditions);
    public function join(array $joins);
    public function vals(array $vals);

    public function find(): array;
    public function insert(): array;
    public function update(): array;
    public function delete(): array;
}