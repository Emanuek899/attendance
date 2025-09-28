<?php

class MySQLdatabase implements Database{
    private PDO $pdo;
    
    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Ejecuta una consulta sql (PUT, UPDTAE, DELET)
     * @param
     * @return 
    */
    public function ejecutar(string $sql, array $params = []) {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
    }

    /**
     * 
    */
    public function consultar(string $sql, array $params = []) {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchall(PDO::FETCH_ASSOC);
    }
}
