<?php

namespace Storage;
class DB
{
    private $table_name = null;
    private $connection = null;
    private static $conn = null;

    public function __construct(string $table_name) {
        $this->table_name = $table_name;
        if (self::$conn == null) {
            self::$conn = new \mysqli(DB_SERVER_NAME, DB_USERNAME, DB_PASSWORD, DB_NAME);
            if (self::$conn->connect_error) {
                die("Connection failed: " . self::$conn->connect_error);
            }
        }
    }

    public function __deconstruct() {
        self::$conn->close();
    }
    
    public function addEntry(array $entry) {
        $column_str = '';
        $value_str = '';
        foreach ($entry as $key => $value) {
            $column_str .= $key . ',';
            $value_str .= "'" . self::$conn->real_escape_string($value) . "',";
        }
        $column_str = rtrim($column_str, ',');
        $value_str = rtrim($value_str, ',');

        $sql = "INSERT INTO " . $this->table_name . " ($column_str) VALUES ($value_str)";

        $result = self::$conn->query($sql);
        if ($result === true) {
            return self::$conn->insert_id;
        }
        return false;
    }

    public function updateEntry(int $id, array $entry) {
        $column_value_str = '';
        foreach ($entry as $key => $value) {
            $column_value_str .= ' ' . $key . "=" . "'" . self::$conn->real_escape_string($value) . "',";
        }
        $column_value_str = rtrim($column_value_str, ',');

        $sql = "UPDATE " . $this->table_name . " SET $column_value_str WHERE id=$id";

        $result = self::$conn->query($sql);
        if ($result === true) {
            return $entry;
        }
        return false;
    }

    public function getAll() {
        $sql = "SELECT * FROM " . $this->table_name;
        $result = self::$conn->query($sql);
        if ($result !== false) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return false;
    }

    public function getEntry(int $id) {
        $sql = "SELECT * FROM " . $this->table_name . " WHERE id=$id";
        $result = self::$conn->query($sql);

        if ($result !== false) {
            return $result->fetch_assoc();
        }
        return false;
    }

    public function deleteEntry(int $id) {
        $sql = "DELETE FROM " . $this->table_name . " WHERE id=$id";

        return (self::$conn->query($sql) === true);
    }

    public function getError() {
        if (DEBUG_MODE) {
            return self::$conn->error;
        }
        else {
            return 'An error has aqured';
        }
    }
}