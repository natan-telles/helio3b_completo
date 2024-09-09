<?php
use Firebase\JWT\MeuTokenJWT;
require_once "modelo/MeuTokenJWT.php";
require_once "modelo/Banco.php";
require_once "modelo/Empresa.php";

$objResposta = new stdClass();
$objEmpresa = new Empresa();
$objEmpresa->setIdEmpresa($id);

$headers = getallheaders();
$authorization = $headers['Authorization'] ?? '';
$token = new MeuTokenJWT();
if ($token->validarToken($authorization)) {
    if ($objEmpresa->delete() == true) {
        $objResposta->cod = 1;
        $objResposta->status = true;
        $objResposta->mensagem = "Deletado com sucesso!";
        header("HTTP/1.1 204 No Content");
    } else {
        $objResposta->cod = 2;
        $objResposta->status = false;
        $objResposta->mensagem = "Erro ao deletar empresa.";
        header("HTTP/1.1 200 OK");
        header("Content-Type: application/json");
    }
} else {
    $objResposta->cod = 2;
    $objResposta->status = false;
    $objResposta->mensagem = "Token inválido!";
    $objResposta->tokenRecebido = $authorization;
    header("HTTP/1.1 401 Unauthorized");
    header("Content-Type: application/json");
}

echo json_encode($objResposta);
