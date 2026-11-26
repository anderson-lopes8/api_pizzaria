<?php

namespace apiPizza\Config;

use PDO;
use PDOException;
use Throwable;

class Database {
    private $host = "localhost";
    private $port = "3306";
    private $db_name = "apipizzaria";
    private $username = "root";
    private $password = "";
    private $conn;

    // Método para obter a conexão com o banco de dados
    public function getConnection() {
        $this->conn = null;

        try {
            $dsn = 'mysql:host=' . $this->host . ';port=' . $this->port . ';dbname=' . $this->db_name . ';charset=utf8';
            
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Erro de Conexão: ' . $e->getMessage();
        } catch (Throwable $e) {
            echo 'Erro genérico: ' . $e->getMessage();
        }

        return $this->conn;
    }
}
