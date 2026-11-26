<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

use  apiPizza\Config\Database;
use  apiPizza\Models\Pizza;
// Incluir arquivos de banco de dados e modelo
require_once  __DIR__ . '/../../Config/Database.php';
require_once  __DIR__ . '/../../Models/pizza.php';

$database = new Database();
$db = $database->getConnection();

$pizza = new Pizza($db);

try {
    $stmt = $pizza->getall();
    $num = $stmt->rowCount();

    if ($num > 0) {
        $pizzas_arr = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $pizza_item = array(
                "id" => $idPizza,
                "nome" => $nome,
                "ingredientes" => $ingredientes,
                "valor" => $valor
            );

            array_push($pizzas_arr, $pizza_item);
        }

        http_response_code(200);

        echo json_encode($pizzas_arr);
    } else {
        http_response_code(404);

        echo json_encode(
            array("Mensagem" => "Nenhuma pizza encontrada.")
        );
    }
} catch (PDOException $e) {
    echo json_encode(array("Erro de Banco de Dados" => $e->getMessage()));
} catch (Throwable $e) {
    echo json_encode(array("Erro Generico" => $e->getMessage()));
}
