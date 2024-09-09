<?php
use Firebase\JWT\MeuTokenJWT;
require_once "modelo/MeuTokenJWT.php";
require_once __DIR__ . '/../modelo/Cliente.php';
$resposta = new stdClass();

$headers = getallheaders();
$authorization = $headers['Authorization']; 
$token = new MeuTokenJWT();
if ($token->validarToken($authorization)) {
    $nomeArquivo = $_FILES['csv']['tmp_name'];
    $ponteiroArquivo = fopen($nomeArquivo, "r");
    $clientes = array();
    $i = 0;
    while (($linhaArguivo = fgetcsv($ponteiroArquivo, 1000, ";")) !== false) {
        $linhaArguivo = array_map("utf8_encode", $linhaArguivo);

        $clientes[$i] = new Cliente();
        $clientes[$i]->setNomeCliente($linhaArguivo[0]);
        $clientes[$i]->setPedidoCliente($linhaArguivo[1]);

        if ($clientes[$i]->create()) {
            $i++;
        }
        //echo $linhaArguivo[0] . "<br>";
        //echo $linhaArguivo[1] . "<br>";
    }

    $resposta->status = true;
    $resposta->msg = "Clientes cadastrados com sucesso";
    $resposta->cadastrados = $clientes;
    $resposta->totalClientes = $i;
}else{
    $resposta->cod = 2;
    $resposta->status = false;
    $resposta->mensagem = "Token inválido!";
    $resposta->tokenRecebido = $authorization;
}

echo json_encode($resposta);

