<?php
use Firebase\JWT\MeuTokenJWT;
require_once "modelo/MeuTokenJWT.php";
require_once __DIR__ . '/../modelo/Empresa.php';
$resposta = new stdClass();

$headers = getallheaders();
$authorization = $headers['Authorization']; 
$token = new MeuTokenJWT();
if ($token->validarToken($authorization)) {
    $nomeArquivo = $_FILES['csv']['tmp_name'];
    $ponteiroArquivo = fopen($nomeArquivo, "r");
    $empresas = array();
    $i = 0;
    while (($linhaArguivo = fgetcsv($ponteiroArquivo, 1000, ";")) !== false) {
        $linhaArguivo = array_map("utf8_encode", $linhaArguivo);

        $empresas[$i] = new Empresa();
        $empresas[$i]->setNomeEmpresa($linhaArguivo[0]);
        $empresas[$i]->setCnpj($linhaArguivo[1]);
        $empresas[$i]->setIdClienteEmpresa($linhaArguivo[2]);

        if ($empresas[$i]->create()) {
            $i++;
        }
    }

    $resposta->status = true;
    $resposta->msg = "Empresas cadastradas com sucesso";
    $resposta->cadastrados = $empresas;
    $resposta->totalEmpresas = $i;
}else{
    $resposta->cod = 2;
    $resposta->status = false;
    $resposta->mensagem = "Token inválido!";
    $resposta->tokenRecebido = $authorization;
}

echo json_encode($resposta);
