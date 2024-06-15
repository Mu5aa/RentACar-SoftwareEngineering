<?php

require_once __DIR__ . '/../config.php';

class BaseDao{
    protected $connection;
    private $table_name;

    public function __construct($table_name){
        $this->table_name = $table_name;
        try{
            $this->connection = new PDO("mysql:host=". Config::DB_HOST() . ";dbname=" .Config::DB_NAME() . ";port=" . Config::DB_PORT(), Config::DB_USER(), Config::DB_PASSWORD(), 
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]);
        }catch(PDOException $e){
            throw $e;
        }
    }

    protected function query($query, $params = []) {
        $stmt = $this->connection->prepare($query);
        $stmt->execute($params);
        return $stmt;
    }

    protected function query_unique($query, $params){
        $statement = $this->query($query, $params);
    
        if ($statement === false || $statement->rowCount() === 0) {
            // Handle case where query fails or returns no results
            return null; // Or throw an exception, depending on your requirements
        }
    
        // Fetch the first row as an associative array
        $result = $statement->fetch(PDO::FETCH_ASSOC);
    
        // Free the statement resources
        $statement->closeCursor();
    
        return $result;
    }
    
    

    function get_all() {
        $stmt = $this->query("SELECT * FROM " . $this->table_name);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function getById($id) {
        return $this->query_unique("SELECT * FROM " . $this->table_name . " WHERE id = :id", ["id" => $id]);
    }

    public function add($table_name, $entity) {
        $query = "INSERT INTO {$table_name} (" ;
        foreach ($entity as $column => $value) {
            $query .= $column . ", ";
        }
        $query = substr($query, 0, -2);
        $query .= ") VALUES (";
        foreach ($entity as $column => $value) {
            $query .= ":" . $column . ", ";
        }
        $query = substr($query, 0, -2);
        $query .= ")";

        $stmt = $this->connection->prepare($query);
        $stmt->execute($entity); // sql injection prevention
        $entity['id'] = $this->connection->lastInsertId();
        return $entity;
    }
    
    

    public function delete($id) {
        $stmt = $this->connection->prepare("DELETE FROM " . $this->table_name . " WHERE id=:id");
        $stmt->bindParam(':id', $id); // SQL injection prevention
        $stmt->execute();
    }

    public function update($id, $entity, $id_column = "id") {
        $query = "UPDATE " . $this->table_name . " SET ";
        foreach ($entity as $column => $value) {
            $query .= $column . "= :" . $column . ", ";
        }
        $query = substr($query, 0, -2);
        $query .= " WHERE $id_column = :id";

        $stmt = $this->connection->prepare($query);
        $entity['id'] = $id;
        $stmt->execute($entity);
        return $entity;
    }

    protected function execute($query, $params) {
        $prepared_statement = $this->connection->prepare($query);
        if ($params) {
        foreach ($params as $key => $param) {
            $prepared_statement->bindValue($key, $param);
        }
        }
        $prepared_statement->execute();
        return $prepared_statement;
    }
    
}