<?php
interface SchollarCycleClassesInterface{
    public function select(array $conditions, array $cols): array;
    public function insert(array $data): bool;
    public function update(array $data, array $conditions): bool;
    public function delete(array $conditions): bool;
}