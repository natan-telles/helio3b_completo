<?php
use Firebase\JWT\MeuTokenJWT;
require_once "modelo/MeuTokenJWT.php";
require_once "modelo/Banco.php";
require_once "modelo/Empresa.php";
$txtrecebido = file_get_contents("php://input");
$objJson = json_decode($txtrecebido) or die('{"mensagem" : "formato invalido"}');

$objResposta = new stdClass();
$objEmpresa = new Empresa();
$objEmpresa->setIdEmpresa($id);
$objEmpresa->setNomeEmpresa($objJson->nome_empresa);
$objEmpresa->setCnpj($objJson->cnpj);

if ($objEmpresa->getNomeEmpresa() == "" || strlen($objEmpresa->getNomeEmpresa()) < 3 || 
    $objEmpresa->getCnpj() == "" || strlen($objEmpresa->getCnpj()) < 18) {
    $objResposta->cod = 2;
    $objResposta->status = false;
    $objResposta->mensagem = "Por favor insira dados validos";
} else {
    $headers = getallheaders();
    $authorization = $headers['Authorization'];
    $token = new MeuTokenJWT();
    if($token->validarToken($authorization)){
        if ($objEmpresa->update() == true) {
            $objResposta->cod = 1;
            $objResposta->status = true;
            $objResposta->mensagem = "Empresa atualizado com sucesso";
            $objResposta->novoEmpresa = $objEmpresa;
        } else {
            $objResposta->cod = 2;
            $objResposta->status = false;
            $objResposta->mensagem = "Erro ao atualizar Empresa";
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
