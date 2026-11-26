<?php

header('Access-Control-Allow-Origin: *');

header('Content-Type: application/json');

header('Access-Control-Allow-Methods: POST');


include_once '../../Config/Database.php';

include_once '../../Models/Bebida.php';


use Apipizza\Config\Database;
use Apibebida\Models\Bebida;

$database = new Database();

$db = $database->getConnection();


$bebida = new Bebida($db);


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    try {


        $data = json_decode(file_get_contents("php://input"));


        if (

            !empty($data->nome) &&

            !empty($data->ml) &&

            !empty($data->valor)

        ) {


            $bebida->nome = $data->nome;

            $bebida->ml = $data->ml;

            $bebida->valor = $data->valor;

            if ($bebida->add()) {

                http_response_code(201);

                // Resposta de sucesso

                echo json_encode(

                    array('Mensagem' => 'Bebida Criada com Sucesso')

                );
            } else {

                http_response_code(400);

                // Resposta de erro

                echo json_encode(

                    array('Erro' => 'Nao foi possivel criar a Bebida')

                );
            }
        } else {

            http_response_code(400);

            // Resposta se dados estiverem incompletos

            echo json_encode(

                array('Erro' => 'Dados Incompletos. Nao foi possivel criar a Bebida.')

            );
        }
    } catch (Exception $e) {

        echo json_encode(array("Erro" => $e->getMessage()));
    }
} else {

    http_response_code(400);

    echo json_encode(array("Erro" => "Método não suportado!"));
}
