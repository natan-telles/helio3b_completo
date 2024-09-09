<?php
use Firebase\JWT\MeuTokenJWT;
require_once "modelo/MeuTokenJWT.php";
require_once "modelo/Banco.php";
require_once "modelo/Cliente.php";
$txtrecebido = file_get_contents("php://input");
$objJson = json_decode($txtrecebido) or die('{"mensagem" : "formato invalido"}');

$objResposta = new stdClass();
$objCliente = new Cliente();
$objCliente->setIdCliente($id);
$objCliente->setNomeCliente($objJson->nomeCliente);
$objCliente->setPedidoCliente($objJson->pedidoCliente);

if ($objCliente->getNomeCliente() == "" || strlen($objCliente->getNomeCliente()) < 3) {
    $objResposta->cod = 2;
    $objResposta->status = false;
    $objResposta->mensagem = "Por favor insira dados validos";
} else {
    $headers = getallheaders();
    $authorization = $headers['Authorization'];
    $token = new MeuTokenJWT();
    if($token->validarToken($authorization)){
        if ($objCliente->update() == true) {
            $objResposta->cod = 1;
            $objResposta->status = true;
            $objResposta->mensagem = "Cliente atualizado com sucesso";
            $objResposta->novoCliente = $objCliente;
        } else {
            $objResposta->cod = 2;
            $objResposta->status = false;
            $objResposta->mensagem = "Erro ao atualizar cliente";
        }
    }else{
        $objResposta->cod = 2;
        $objResposta->status = false;
        $objResposta->mensagem = "Token invalido!";
        $objResposta->tokenRecebido = $authorization;
    }
}

header("Content-Type: application/json");
if ($objResposta->status == true) {
    header("HTTP/1.1 201");
} else {
    header("HTTP/1.1 200");
}

echo json_encode($objResposta);