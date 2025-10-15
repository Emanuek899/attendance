<?php
interface UsersInterface{
    public function insert(array $data): array;
    public function select(array $conditions, array $cols): array;
    public function update(array $data, array $conditions): array;
    public function delete(array $conditions): array;
}