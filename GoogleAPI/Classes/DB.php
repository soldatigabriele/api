<?php


class DB
{
    private static $_instance = null;
    private
        $_username = 'homestead',
        $_password = 'secret',
        $_pdo,
        $_query,
        $_results,
        $_error,
        $_count = 0;

    public function __construct()
    {
        try {
            $this->_pdo = new PDO('mysql:host=127.0.0.1;dbname=homestead', $this->_username, $this->_password);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public static function getInstance()
    {
//check if I have an instance of the class
        if (!isset(self::$_instance)) {
            self::$_instance = new DB();
        }
        return self::$_instance;
    }

    public function query($table,$fields)
    {
        $query = "SELECT * FROM {$table} WHERE {$fields} ";
        $this->_query = $this->_pdo->prepare($query);
        if ($this->_query->execute()) {
            $this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
            $this->_count = $this->_query->rowCount();

        } else {
            $this->_error = true;
        }
    }

    public function results()
    {
        return $this->_results;
    }
    public function count()
    {
        return $this->_count;
    }

    public function error()
    {
        return $this->_error;
    }
}