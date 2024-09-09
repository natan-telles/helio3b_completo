<?php
use Firebase\JWT\MeuTokenJWT;
require_once "modelo/MeuTokenJWT.php";
require_once "modelo/Banco.php";
require_once "modelo/Estagiario.php";
$txtrecebido = file_get_contents("php://input");
$objJson = json_decode($txtrecebido) or die('{"mensagem" : "formato invalido"}');

$objResposta = new stdClass();
$objEstagiario = new Estagiario();
$objEstagiario->setIdEstagiario($id);
$objEstagiario->setNomeEstagiario($objJson->nome_estagiario);
$objEstagiario->setDataNascimento($objJson->data_nascimento);
$objEstagiario->setTelefone($objJson->telefone);
$objEstagiario->setEmail($objJson->email);

if ($objEstagiario->getNomeEstagiario() == "" || strlen($objEstagiario->getNomeEstagiario()) < 5 || $objEstagiario->getDataNascimento() == ""
    || $objEstagiario->getTelefone() == "" || $objEstagiario->getEmail() == "") {
    $objResposta->cod = 2;
    $objResposta->status = false;
    $objResposta->mensagem = "Por favor insira dados validos";
} else {
    $headers = getallheaders();
    $authorization = $headers['Authorization'];
    $token = new MeuTokenJWT();
    if($token->validarToken($authorization)){
        if ($objEstagiario->update() == true) {
            $objResposta->cod = 1;
            $objResposta->status = true;
            $objResposta->mensagem = "Estagiario atualizado com sucesso";
            $objResposta->novoCliente = $objEstagiario;
        } else {
            $objResposta->cod = 2;
            $objResposta->status = false;
            $objResposta->mensagem = "Erro ao atualizar estagiario";
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