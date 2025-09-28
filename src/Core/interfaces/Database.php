<?php
interface Database {
    public function ejecutar(string $sql, array $params);
    public function consultar(string $sql, array $params);
}