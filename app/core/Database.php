<?php
class Database {
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;
    
    private $dbh;
    private $stmt;
    private $error;
    
    public function __construct() {
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_EMULATE_PREPARES => false
        );
        
        try {
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
        } catch(PDOException $e) {
            $this->error = $e->getMessage();
            throw new Exception("Database connection failed: " . $this->error);
        }
    }
    
    public function beginTransaction() {
        return $this->dbh->beginTransaction();
    }
    
    public function commit() {
        return $this->dbh->commit();
    }
    
    public function rollBack() {
        return $this->dbh->rollBack();
    }
    
    public function query($sql, $params = []) {
        try {
            $this->stmt = $this->dbh->prepare($sql);
            
            if (!empty($params)) {
                foreach ($params as $param => $value) {
                    $type = PDO::PARAM_STR;
                    if (is_int($value)) {
                        $type = PDO::PARAM_INT;
                    } elseif (is_bool($value)) {
                        $type = PDO::PARAM_BOOL;
                    } elseif (is_null($value)) {
                        $type = PDO::PARAM_NULL;
                    }
                    
                    if (is_numeric($param)) {
                        $param++;  // Array is 0-based, but PDO is 1-based
                    }
                    
                    $this->stmt->bindValue($param, $value, $type);
                }
            }
            
            $this->stmt->execute();
            return $this->stmt;
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            error_log("Database error: " . $this->error);
            return false;
        }
    }
    
    public function fetchAll() {
        return $this->stmt->fetchAll();
    }
    
    public function fetch() {
        return $this->stmt->fetch();
    }
    
    public function rowCount() {
        return $this->stmt->rowCount();
    }
    
    public function lastInsertId() {
        return $this->dbh->lastInsertId();
    }
    
    public function getError() {
        return $this->error;
    }
} 