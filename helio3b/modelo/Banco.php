<?php
class Banco {
    private static $host = 'localhost';
    private static $user = 'root';
    private static $password = ''; 
    private static $banco = 'api_rest';
    private static $porta = 3306;
    private static $conexao = NULL;

    private static function conectar_banco() {
        error_reporting(E_ERROR | E_PARSE);
        if (Banco::$conexao == NULL) {
            Banco::$conexao = new mysqli(Banco::$host, Banco::$user, Banco::$password, Banco::$banco, Banco::$porta);
            
            // Verifica se houve erro na conexão
            if (Banco::$conexao->connect_errno) {
                $objResposta = new stdClass();
                $objResposta->cod = 1;
                $objResposta->erro = Banco::$conexao->connect_error;

                die(json_encode($objResposta)); // Exibe o JSON)
            } 
        }
    }

    public static function getConexao(){
        if(Banco::$conexao == NULL){
            Banco::conectar_banco();
        }
        return Banco::$conexao;
    }
}

?>
