<?php

namespace Storage;
class DB
{
    private $table_name = null;
    private $connection = null;
    public function __construct($table_name) {
        $this->table_name = $table_name;
        $this->conn = new \mysqli(DB_SERVER_NAME, DB_USERNAME, DB_PASSWORD, DB_NAME);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function __deconstruct() {
        $this->conn->close();
    }
    
    public function addEntry($entry) {
        $column_str = '';
        $value_str = '';
        foreach ($entry as $key => $value) {
            $column_str .= $key . ',';
            $value_str .= "'" . $this->conn->real_escape_string($value) . "',";
        }
        $column_str = rtrim($column_str, ',');
        $value_str = rtrim($value_str, ',');

        $sql = "INSERT INTO " . $this->table_name . " ($column_str) VALUES ($value_str)";

        $result = $this->conn->query($sql);
        if ($result === true) {
            return $this->conn->insert_id;
        }
        return false;
    }

    public function getAll() {
        $sql = "SELECT * FROM " . $this->table_name;
        $result = $this->conn->query($sql);

        return $result->fetch_all(MYSQLI_ASSOC);
    }
}