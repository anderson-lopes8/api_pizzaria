<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
use  apiPizza\Config\Database; 
use  apiBebida\Models\Bebida; 

require_once  __DIR__ . '/../../Config/Database.php';
require_once  __DIR__ . '/../../Models/Bebida.php';


 
$database = new Database();
$db = $database->getConnection();
 
$bebida = new Bebida($db);

try {
    $stmt = $bebida->getall();
    $num = $stmt->rowCount();
 
    if ($num > 0) {
        // Array de bebidas
        $bebidas_arr = array();
 
        // Percorrer o resultado da consulta
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // A função extract transforma $row['nome'] em apenas $nome
            extract($row);
 
            $bebida_item = array(
                "id" => $id,
                "nome" => $nome,
                "ml" => $ml,
                "valor" => $valor
            );
 
            array_push($bebidas_arr, $bebida_item);
        }
 
        http_response_code(200);
 
        echo json_encode($bebidas_arr);
    } else {

        http_response_code(404);
 
        // Informar ao usuário que nenhuma bebida foi encontrada
        echo json_encode(
            array("Mensagem" => "Nenhuma bebida encontrada.")
        );
    }
} catch (PDOException $e) {
    echo json_encode(array("Erro de Banco de Dados" => $e->getMessage()));
}catch (Throwable $e) {
    echo json_encode(array("Erro Generico" => $e->getMessage()));
}