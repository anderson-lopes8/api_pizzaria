<?php


header('Access-Control-Allow-Origin: *');

header('Content-Type: application/json');

header('Access-Control-Allow-Methods: POST');


include_once '../../Config/Database.php';
include_once '../../Models/Pizza.php';


use Apipizza\Config\Database;
use Apipizza\Models\Pizza;


$database = new Database();

$db = $database->getConnection();

$pizza = new Pizza($db);


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    try {

        $data = json_decode(file_get_contents("php://input"));

        if (

            !empty($data->nome) &&

            !empty($data->ingredientes) &&

            !empty($data->valor)

        ) {

        $pizza->nome = $data->nome;

            $pizza->ingredientes = $data->ingredientes;

            $pizza->valor = $data->valor;

            if ($pizza->add()) {

                http_response_code(201);

          echo json_encode(

                    array('Mensagem' => 'Pizza Criada com Sucesso')

                );
            } else {

                http_response_code(400);


                echo json_encode(

                    array('Erro' => 'Nao foi possivel criar a Pizza')

                );
            }
        } else {

            http_response_code(400);


            echo json_encode(

                array('Erro' => 'Dados Incompletos. Nao foi possivel criar a Pizza.')

            );
        }
    } catch (Exception $e) {

        echo json_encode(array("Erro" => $e->getMessage()));
    }
} else {

    http_response_code(400);

    echo json_encode(array("Erro" => "Método não suportado!"));
}
