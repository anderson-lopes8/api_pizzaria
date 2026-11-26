<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
 
include_once '../../Config/Database.php';
include_once '../../Models/Pizza.php';
 
use Apipizza\Config\Database;
use Apipizza\Models\Pizza;  
 

$database = new Database();
$db = $database->getConnection();
 

$pizza = new Pizza($db);
 
if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    try {

    $data = json_decode(file_get_contents("php://input"));
 

    if (
            !empty($data->id) &&
            !empty($data->nome) &&
            !empty($data->ingredientes) &&
            !empty($data->valor)
        ) {

        $pizza->id = $data->id; //é o que vem pelo json
 

        $pizza->nome = $data->nome;
            $pizza->ingredientes = $data->ingredientes;
            $pizza->valor = $data->valor;
 

            if ($pizza->update()) {
                http_response_code(200);

                echo json_encode(
                    array('Mensagem' => 'Pizza Atualizada com Sucesso')
                );
            } else {
                http_response_code(500);

                echo json_encode(
                    array('Mensagem' => 'Nao foi possivel atualizar a Pizza')
                );
            }
        } else {

        http_response_code(400);
            echo json_encode(
                array('Mensagem' => 'Dados Incompletos. Nao foi possivel atualizar a Pizza.')
            );
        }
    } catch (Exception $e) {        
        echo json_encode(array("erro" => $e->getMessage()));
    }
} else {
    http_response_code(400);
    echo json_encode(array("erro" => "Método não suportado!"));
}