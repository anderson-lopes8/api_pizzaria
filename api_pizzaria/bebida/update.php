<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
 
include_once '../../Config/Database.php';
include_once '../../Models/Bebida.php';
 
use Apipizza\Config\Database;
use apiBebida\Models\bebida;  
 
$database = new Database();
$db = $database->getConnection();
 
$bebida = new bebida ($db);
 
if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    try {
        $data = json_decode(file_get_contents("php://input"));
 
        // Verificar se os dados não estão vazios e se o ID foi fornecido
            if (
            !empty($data->id) &&
            !empty($data->nome) &&
            !empty($data->ml) &&
            !empty($data->valor)
        ) {
            $bebida->id = $data->id; //é o que vem pelo json
 
            // Atribuir os demais valores
            $bebida->nome = $data->nome;
            $bebida->ml = $data->ml;
            $bebida->valor = $data->valor;
 
            // Tentar atualizar a bebida
            if  ($bebida->update()) {   
                http_response_code(200);

                echo json_encode(
                    array('Mensagem' => 'Bebida Atualizada com Sucesso')
                );
            } else {
                http_response_code(500);

                echo json_encode(
                    array('Mensagem' => 'Nao foi possivel atualizar a Bebida')
                );
            }
        } else {

        http_response_code(400);
            echo json_encode(
                array('Mensagem' => 'Dados Incompletos. Nao foi possivel atualizar a Bebida.')
            );
        }
    } catch (Exception $e) {        
        echo json_encode(array("erro" => $e->getMessage()));
    }
} else {
    http_response_code(400);
    echo json_encode(array("erro" => "Método não suportado!"));
}