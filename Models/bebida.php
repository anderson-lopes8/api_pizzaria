<?php

namespace apiBebida\Models;

use PDO;

class Bebida
{
    public $id;
    public $nome;
    public $ml;
    public $valor;

    private $db;
    private $tabela = "bebidas_ml";

    // Construtor
    public function __construct($db)
    {
        $this->db = $db;
    }

    //  LISTAR TODAS
    public function getAll()
    {
        $query = "SELECT * FROM " . $this->tabela . " ORDER BY nome";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    //  BUSCAR POR ID
    public function get()
    {
        $query = "SELECT id, nome, ml, valor 
                  FROM " . $this->tabela . " 
                  WHERE id = ? 
                  LIMIT 1";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->nome = $row['nome'];
            $this->ml = $row['ml'];
            $this->valor = $row['valor'];
        }
    }

    //  BEBIDAS ALCOÓLICAS
    public function alcoolicas()
    {
        $query = "SELECT id, nome, ml, valor 
                  FROM " . $this->tabela . " 
                  WHERE alcolica = 1";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    //  BEBIDAS NÃO ALCOÓLICAS
    public function naoAlcoolicas()
    {
        $query = "SELECT id, nome, ml, valor 
                  FROM " . $this->tabela . " 
                  WHERE alcolica = 0";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    // INSERIR
    public function add()
    {
        $query = "INSERT INTO " . $this->tabela . " 
                  (nome, ml, valor) 
                  VALUES (:nome, :ml, :valor)";

        $stmt = $this->db->prepare($query);

        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->ml = htmlspecialchars(strip_tags($this->ml));
        $this->valor = htmlspecialchars(strip_tags($this->valor));

        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':ml', $this->ml);
        $stmt->bindParam(':valor', $this->valor);

        return $stmt->execute();
    }

    // UPDATE 
    public function update()
    {
        $query = "UPDATE " . $this->tabela . " 
                  SET nome = :nome, ml = :ml, valor = :valor 
                  WHERE id = :id";

        $stmt = $this->db->prepare($query);

        // Limpar dados
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->ml = htmlspecialchars(strip_tags($this->ml));
        $this->valor = htmlspecialchars(strip_tags($this->valor));

        // Bind
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':ml', $this->ml);
        $stmt->bindParam(':valor', $this->valor);

        if ($stmt->execute()) {
            return $stmt->rowCount() > 0;
        }

        // Debug (caso dê erro)
        print_r($stmt->errorInfo());

        return false;
    }

    // DELETE (EXTRA)
    public function delete()
    {
        $query = "DELETE FROM " . $this->tabela . " WHERE id = :id";

        $stmt = $this->db->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':id', $this->id);

        return $stmt->execute();
    }
}