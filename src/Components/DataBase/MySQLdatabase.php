<?php
/**
 * MySQL database class implementing Database interface
 * @author Emanuel Santacruz
 * @version 1.0
 */
require_once __DIR__ . '/../../Core/interfaces/Database.php';
require_once __DIR__ . '/../../utils/status.php';
require_once __DIR__ . '/../../utils/Response.php';

class MySQLdatabase implements Database{
    private PDO $pdo;
    private string $table;
    private array $columns = ['*'];
    private array $where = []; //[[column => col, op => op, placeholder => :placeholder, boolean => and]]
    private array $joins = [];
    private array $params = []; // [:param1 => val]
    private array $vals = []; // [val1 => val]
    
    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    /**
     * select sql query
     * @return array The founded users in the database or an empty array
    */
    public function find(): array {
        try{
            $cols = implode(',', $this->columns);
            $sql = "SELECT $cols FROM $this->table";
            // create where clause if conditions exist
            if(!empty($this->where)) $sql = $this->whereClause($sql);
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($this->params);
            $roles = $stmt->fetchall(PDO::FETCH_ASSOC); 
            $this->cleanVariables();
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
    public function insert(): array {
        try{
            $cols = implode(',', array_keys($this->vals)); 
            $placeholders = implode(', ', array_keys($this->params));
            $table = $this->table;
            $sql = "INSERT INTO $table($cols) VALUES ($placeholders)";
            $stmt = $this->pdo->prepare($sql);
            $status = $stmt->execute($this->params);
            $data['id'] = $this->pdo->lastInsertId();
            $this->cleanVariables();
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
    public function update(): array{
        try{
            $set = [];
            $table = $this->table;
            $sql = "UPDATE $table ";
            // SET clause format
            foreach($this->vals as $col => $val){$set[] = "$col = :$col";}
            $sql .= 'SET ' . implode(', ', $set);

            // create where clause format if conditions exist
            if(!empty($this->where)){
                $sql = $this->whereClause($sql);
            }
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($this->params);
            $affectedRows = $stmt->rowCount();
            if($affectedRows == 0) return statusError(['No se encontro el recurso'], 404);
            return status(true, 'sucesfully uploaded', '', $this->pdo->lastInsertId());
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
    public function delete(): array {
        try{
            //where clause if conditions is not empty
            if(!empty($conditions)){
                $delClause = "DELETE FROM $table";
                $params = [];
                $where =  $this->whereClause($delClause, $conditions, $params);
                $sql = $where[0];
                $params = $where[1];
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute($this->params);
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
    private function whereClause(string $sql): string{
        foreach($this->where as $idx => $cond){
            if($idx > 0){
                $sql .= $cond['boolean'] . ' ' . 
                        $cond['column'] . ' ' .
                        $cond['op']. ' ' .
                        $cond['placeholder'] . ' ';
            }else{
                $sql .= ' WHERE' . ' ' . 
                        $cond['column'] . ' ' . 
                        $cond['op']. ' ' .
                        $cond['placeholder'] . ' ';
            }
        }
        return $sql;
    }

    private function joinClause(string $sql){
        foreach($this->joins as $idx => $join){
            if($idx > 0){
                $sql .= $join['boolean'] . ' ' . 
                        $join['column'] . ' ' .
                        $join['op']. ' ' .
                        $join['placeholder'] . ' ';
            }
        }
    }

    //methods to build querys

    /**
     * Stablish the table name
     */
    public function table(string $table){
        $this->table = $table;
        return $this;
    }

    /**
     * Stablish the columns of the query
     */
    public function columns(array $columns){
        $this->columns = $columns;
        return $this;
    }

    /**
     * [[column => 'columna1', 'op' => '=', 'val' => 1], [...]]
     */
    public function where(array $conditions){
        foreach($conditions as $condition){
            $this->where[] = [
                'column'      => $condition['column'], 
                'op'          => $condition['op'], 
                'placeholder' => ":{$condition['column']}",
                'boolean'     => $condition['boolean'],
            ];
            $this->params[":{$condition['column']}"] = $condition['val'];
        }
        return $this;
    }

    /**
     * Stablis the joins for the query
     */
    public function join(array $joins){
        foreach($joins as $join){
            $this->joins[] = $join;
        }
        return $this;
    }

    public function vals($vals){
        foreach($vals as $column => $val){
            $this->vals[$column] = $val;
            $this->params[":$column"] = $val;

        }
        return $this;
    }

    public function cleanVariables(){
        $this->columns = ['*'];
        $this->where = []; //[[column => col, op => op, placeholder => :placeholder, boolean => and]]
        $this->joins = [];
        $this->params = []; // [:param1 => val]
        $this->vals = []; // [val1 => val]
    }
}
