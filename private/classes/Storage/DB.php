<?php

namespace Storage;
class DB
{
    private $table_name = null;
    private $connection = null;
    public function __construct(string $table_name) {
        $this->table_name = $table_name;
        $this->conn = new \mysqli(DB_SERVER_NAME, DB_USERNAME, DB_PASSWORD, DB_NAME);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function __deconstruct() {
        $this->conn->close();
    }
    
    public function addEntry(array $entry) {
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

    public function updateEntry(int $id, array $entry) {
        $column_value_str = '';
        foreach ($entry as $key => $value) {
            $column_value_str .= $key . "=" . "' " . $this->conn->real_escape_string($value) . " ',";
        }
        $column_value_str = rtrim($column_value_str, ',');

        $sql = "UPDATE " . $this->table_name . " SET $column_value_str WHERE id=$id";

        $result = $this->conn->query($sql);
        if ($result === true) {
            return $entry;
        }
        return false;
    }

    public function getAll() {
        $sql = "SELECT * FROM " . $this->table_name;
        $result = $this->conn->query($sql);

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getEntry(int $id) {
        $sql = "SELECT * FROM " . $this->table_name . " WHERE id=$id";
        $result = $this->conn->query($sql);

        return $result->fetch_assoc();
    }

    public function deleteEntry(int $id) {
        $sql = "DELETE FROM " . $this->table_name . " WHERE id=$id";

        return ($this->conn->query($sql) === true);
    }
}