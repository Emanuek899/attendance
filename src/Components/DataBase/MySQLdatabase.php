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
    public function ejecutar(string $sql, array $params = []): void {
        try{
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
        }catch(PDOException $e){
            throw $e;
        }

    }

    /**
     * 
    */
    public function consultar(string $sql, array $params = []): array {
        try{
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchall(PDO::FETCH_ASSOC);
        }catch(PDOException $e){
            throw $e;
        }
    }
}
