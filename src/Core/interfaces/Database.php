<?php
interface Database {
    public function ejecutar(string $sql, array $params): void;
    public function consultar(string $sql, array $params): array;
}