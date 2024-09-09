<?php
namespace Firebase\JWT;
use stdClass;
use Firebase\JWT\Key;
use Firebase\JWT\JWT;
use DomainException;
use Exception;
use InvalidArgumentException;
use UnexpectedValueException;
use Firebase\JWT\SignatureInvalidException;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWTExceptionWithPayloadInterface;
require_once "jwt/php-jwt-main/src/JWT.php";
require_once "jwt/php-jwt-main/src/JWK.php";
require_once "jwt/php-jwt-main/src/Key.php";
require_once "jwt/php-jwt-main/src/SignatureInvalidException.php";
require_once "jwt/php-jwt-main/src/ExpiredException.php";
require_once "jwt/php-jwt-main/src/JWTExceptionWithPayloadInterface.php";

class MeuTokenJWT {
//chave de criptografia, defina uma chave forte e a mantenha segura.
    private $key = "x9S4q0v+V0IjvHkG20uAxaHx1ijj+q1HWjHKv+ohxp/oK+77qyXkVj/l4QYHHTF3";
    //algoritmo de criptografia para assinatura
    //Suportados: 'HS256' , 'ES384','ES256', 'ES256K', ,'HS384', 'HS512', 'RS256', 'RS384'
    private $alg = 'HS256';
    private $type = 'JWT';
    private $iss = 'http://localhost'; //emissor do token
    private $aud = 'http://localhost'; //destinatário do token
    private $sub = "acesso_sistema"; //assunto do token
    private $iat = ""; //momento de emissão
    private $exp = ""; //momento de expiração
    private $nbf = ""; //não é válido antes do tempo especificado
    private $jti = ""; //Identificador único
    private $payload; //claims
    //tempo de validade do token
    private $duracaoToken = 3600 * 24 * 30; //3600 segundos = 60 min

    private function setPayload($payload) {
        $this->payload = $payload;
    }

    public function getPayload(){
        return $this->payload;
    }

    public function gerarToken($parametro_claims) {
        // Criação dos headers como objeto da classe stdClass
        $objHeaders = new stdClass();
        $objHeaders->alg = $this->alg;
        $objHeaders->typ = $this->type;
        // Criação do payload como objeto da classe stdClass
        $objPayload = new stdClass();
        //Registered Claims
        $objPayload->iss = $this->iss; // emissor do token
        $objPayload->aud = $this->aud; // destinatário do token
        $objPayload->sub = $this->sub; // assunto do token
        $objPayload->iat = time(); // momento de criação do token
        $objPayload->exp = time() + $this->duracaoToken; // momento de expiração = tempo atual + duração
        $objPayload->nbf = time(); // momento em que o token torna-se valido.
        $objPayload->jti = bin2hex(random_bytes(16)); // gera um valor aleatório para jti;


        //Public Claims
        $objPayload->nome = $parametro_claims->nome;
        $objPayload->email = $parametro_claims->email;
        $objPayload->nascimento = $parametro_claims->nascimento;
        
        
        //Private claims
        $objPayload->idCliente = $parametro_claims->idCliente;


        // Utiliza a biblioteca do Firebase para gerar o token com os parâmetros
        $token = JWT::encode((array) $objPayload, $this->key, $this->alg, null, (array) $objHeaders);
        return $token;
    }

    public function validarToken($stringToken){
        if (isset($stringToken)) {
            if ($stringToken == "") {
                return false;
            } else {
                $remover = ["Bearer ", " "];
                $token = str_replace($remover, "", $stringToken);
                try {
                    $payloadValido = JWT::decode($token, new Key($this->key, $this->alg));
                    $this->setPayload($payloadValido);
                    return true;
                } catch (SignatureInvalidException $e) { // A assinatura do token é inválida.
                    return false;
                } catch (BeforeValidException $e) { // O token não é válido ainda (antes do tempo 'nbf').
                    return false;
                } catch (ExpiredException $e) { // O token expirou.
                    return false;
                } catch (InvalidArgumentException $e) { // Argumento inválido passado.
                    return false;
                } catch (DomainException $e) { // Exceção de domínio genérica.
                    return false;
                } catch (UnexpectedValueException $e) { // Valor inesperado encontrado.
                    return false;
                } catch (Exception $e) { // Qualquer outra exceção genérica.
                    return false;
                }
            }
        }
        return false;
        }
}