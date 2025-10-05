<?php
/**
 * MySQL database class implementing Database interface
 * @author Emanuel Santacruz
 * @version 1.0
 */
require_once __DIR__ . '/../../Core/interfaces/Database.php';
class MySQLdatabase implements Database{
    private PDO $pdo;
    
    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    /**
     * select sql query
     * @param array $conditions Conditions of the query. Format [colname => [op, val]]
     *              Example ['role' => ['=', 7]]
     * @return 
    */
    public function find(
        string $table, 
        array $columns = ['*'],
        array $conditions = [],
        bool $or = false 
        ): array {
        try{
            $cols = implode(',', $columns);
            $sltClause = "SELECT $cols FROM $table";
            $params = [];
            // create where clause if conditions exist
            if(!empty($conditions)){
                $sql = $this->whereClause($sltClause, $conditions, $params);
                $stmt = $this->pdo->prepare($sql[0]);
                $stmt->execute($sql[1]);
            }else{
                $stmt = $this->pdo->prepare($sltClause);
                $stmt->execute($params);
            }
            $roles = $stmt->fetchall(PDO::FETCH_ASSOC); 
            if(!empty($roles)){
                return $roles;               
            } else{
                return ['no se encontraron registros que cumplan las condiciones (revise las condiciones)']; 

            }
 
        }catch(PDOException $e){
            throw $e;
        }

    }

    /**
     * Insert sql query
     * @param string $table
     * @param array $data Datas to insert format [colname => value]
     *              example ['roles' => 'admin']
     * @return
    */
    public function insert(string $table, array $data): bool {
        try{
            $cols = implode(',', array_keys($data)); 
            $placeholders = ':' . implode(', :', array_keys($data));
            $sql = "INSERT INTO $table($cols) VALUES ($placeholders)";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute($data);
        }catch(PDOException $e){
            throw $e;
            // return false;
        }
    }

    /**
     * Update sql query
     * @param   
     * @return
    */
    public function update(string $table, array $data, array $conditions): bool{
        try{
            $set = [];
            $params = [];
            $setClause = "UPDATE $table ";
            // SET clause format
            foreach($data as $col => $val){$set[] = "$col = :$col";}
            $setClause .= 'SET ' . implode(', ', $set);

            // create where clause format if conditions exist
            if(!empty($conditions)){
                $sql = $this->whereClause($setClause, $conditions, $params);
            }
            foreach($data as $col => $val){$sql[1][":$col"] = $val;}
            $stmt = $this->pdo->prepare($sql[0]);
            return $stmt->execute($sql[1]);
        }catch(PDOException $e){
            throw $e;
        }
    }

    /**
     * Delete sql query
     * @param
     * @return
     */
    public function delete(String $table, array $conditions = []): bool {
        try{
            //where clause if conditions is not empty
            if(!empty($conditions)){
                $delClause = "DELETE FROM $table";
                $params = [];
                $sql =  $this->whereClause($delClause, $conditions, $params);
                $stmt = $this->pdo->prepare($sql[0]);
                $stmt->execute($sql[1]);
                if($stmt->rowCount() == 0) return false;
                return true;
            }else{
                return false;
            }
            // where clause
            
        }catch(PDOException $e){
            throw $e;
        }
    }

    /**
     * Consstruct a where section of a query, with dinamic conditions
     */
    private function whereClause(string $sql, array $conditions, array $params): array{
        $where = [];
        foreach($conditions as $col => [$op, $val]){
            $where[] = "$col $op :cond_$col";
            $params[":cond_$col"] = $val; 
        }
        $sql .= ' WHERE ' . implode(' AND ', $where);
        return [$sql, $params];
    }
}
