<?php
interface ReportsInterface{
    public function select(array $cond, array $cols): array;
    public function insert(array $data): bool;
    public function update(array $data, array $cond): bool;
    public function delete(array $cond): bool;
}