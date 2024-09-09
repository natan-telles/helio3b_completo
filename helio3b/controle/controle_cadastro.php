<?php

header('Content-Type = application/json');
use Firebase\JWT\MeuTokenJWT;
require_once "modelo/Cliente.php";
require_once "modelo/MeuTokenJWT.php";
$json = file_get_contents('php://input');
$objJson = json_decode($json);

$usuario = $objJson->usuario;
$senha = $objJson->senha;

$cliente = new Cliente();
$resposta = new stdClass();


if ($cliente->cadastrar($usuario,$senha)){
	$objToken = new MeuTokenJWT();
	$claims = new stdClass();
	$claims->usuario = $objJson->usuario;
	$token = $objToken->gerarToken($claims);

	$resposta->cod = 1;
	$resposta->status = true;
	$resposta->msg = "Cadastrado com sucesso!";
	$resposta->token = $token;
}else{
	$resposta->cod = 2;
	$resposta->status = false;
	$resposta->msg = "E-mail ou senha incorretos!";
}

echo json_encode($resposta);
if ($resposta->status == true){
	header("HTTP/1.1 200");
}else{
	header("HTTP/1.1 401");
}
	