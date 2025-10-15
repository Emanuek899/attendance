<?php
/**
 * MySQL database class implementing Database interface
 * @author Emanuel Santacruz
 * @version 1.0
 */
require_once __DIR__ . '/../../Core/interfaces/Database.php';
require_once __DIR__ . '/../../utils/status.php';

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
                $where = $this->whereClause($sltClause, $conditions, $params);
                $sql = $where[0];
                $params = $where[1];
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute($params);
            }else{
                $stmt = $this->pdo->prepare($sltClause);
                $stmt->execute($params);
            }
            $roles = $stmt->fetchall(PDO::FETCH_ASSOC); 
            if(!empty($roles)) return $roles;               
            return []; 
 
        }catch(PDOException $e){
            $errorCode = $e->getCode();
            switch($errorCode){
                case '42S22':
                    return dbErrorStatus($e->getMessage(), $errorCode);
                    break;

            }
            return dbErrorStatus($e->getMessage(), $errorCode);
        }

    }

    /**
     * Insert sql query
     * @param string $table
     * @param array $data Datas to insert format [colname => value]
     *              example ['roles' => 'admin']
     * @return
    */
    public function insert(string $table, array $data): array {
        try{
            $cols = implode(',', array_keys($data)); 
            $placeholders = ':' . implode(', :', array_keys($data));
            $sql = "INSERT INTO $table($cols) VALUES ($placeholders)";
            $stmt = $this->pdo->prepare($sql);
            $status = $stmt->execute($data);
            $data['id'] = $this->pdo->lastInsertId();
            return status($status, 'creado exitosamente', '', $data);
        }catch(PDOException $e){
            $errorCode = $e->getCode();
            return dbErrorStatus($e->getmessage(), $errorCode);
        }
    }

    /**
     * Update sql query
     * @param   
     * @return
    */
    public function update(string $table, array $data, array $conditions): array{
        try{
            $set = [];
            $params = [];
            $setClause = "UPDATE $table ";
            // SET clause format
            foreach($data as $col => $val){$set[] = "$col = :$col";}
            $setClause .= 'SET ' . implode(', ', $set);

            // create where clause format if conditions exist
            if(!empty($conditions)){
                $where = $this->whereClause($setClause, $conditions, $params);
            }
            $sql = $where[0];
            $params = $where[1];
            foreach($data as $col => $val){$params[":$col"] = $val;}
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            $affectedRows = $stmt->rowCount();
            if($affectedRows == 0) return statusError('No se encontro el recurso', 404);
            return status(true, 'sucesfully uploaded', '', $data);
        }catch(PDOException $e){
            $errorCode = $e->getCode();
            return dbErrorStatus($e->getmessage(), $errorCode);
        }
    }

    /**
     * Delete sql query
     * @param
     * @return
     */
    public function delete(String $table, array $conditions = []): array {
        try{
            //where clause if conditions is not empty
            if(!empty($conditions)){
                $delClause = "DELETE FROM $table";
                $params = [];
                $where =  $this->whereClause($delClause, $conditions, $params);
                $sql = $where[0];
                $params = $where[1];
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute($params);
                if($stmt->rowCount() == 0) return statusError('cant found the recourse', 404);
                return status(true, 'succesfully deleted', '', $conditions);
            }else{
                return statusError('cant delete without conditions', 409);
            }
            // where clause
            
        }catch(PDOException $e){
            $errorCode = $e->getCode();
            return dbErrorStatus($e->getmessage(), $errorCode);
        }
    }

    /**
     * Consstruct a where section of a query, with dinamic conditions
     */
    private static function whereClause(string $sql, array $conditions, array $params,): array{
        $where = [];
        foreach($conditions as $col => [$op, $val]){
            $where[] = "$col $op :cond_$col";
            $params[":cond_$col"] = $val; 
        }
        $sql .= " WHERE " . implode(' OR ', $where);
        return [$sql, $params];
    }
}
