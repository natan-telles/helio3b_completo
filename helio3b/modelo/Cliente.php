<?php
require_once "modelo/Banco.php";
class Cliente implements JsonSerializable
{
    private $id_cliente;
    private $nome_cliente;
    private $pedido_cliente;

    public function jsonSerialize()
    {
        $obj = new stdClass();
        $obj->id_cliente = $this->getIdCliente();
        $obj->nome_cliente = $this->getNomeCliente();
        $obj->pedido_cliente = $this->getPedidoCliente();
        return $obj;
    }

    public function getIdCliente()
    {
        return $this->id_cliente;
    }

    public function setIdCliente($id_cliente)
    {
        $this->id_cliente = $id_cliente;
        return $this;
    }

    public function getNomeCliente()
    {
        return $this->nome_cliente;
    }

    public function setNomeCliente($nome_cliente)
    {
        $this->nome_cliente = $nome_cliente;
        return $this;
    }

    public function getPedidoCliente()
    {
        return $this->pedido_cliente;
    }

    public function setPedidoCliente($pedido_cliente)
    {
        $this->pedido_cliente = $pedido_cliente;
        return $this;
    }

    public function isCliente()
    {
        $conexao = Banco::getConexao();
        $sql = "SELECT COUNT(*) AS qtd FROM clientes WHERE nome_cliente = ?";
        $prepareSql = $conexao->prepare($sql);
        $prepareSql->bind_param("s", $this->nome_cliente);
        $executou = $prepareSql->execute();
        $matrizTuplas = $prepareSql->get_result();
        $objTupla = $matrizTuplas->fetch_object();
        return $objTupla->qtd > 0;
    }
    public function create()
    {
        $conexao = Banco::getConexao();
        $sql = "INSERT INTO clientes (id_cliente, nome_cliente, pedido_cliente) VALUES (?,?,?)";
        $prepareSql = $conexao->prepare($sql);
        $prepareSql->bind_param("iss", $this->id_cliente, $this->nome_cliente, $this->pedido_cliente);
        $executou = $prepareSql->execute();
        $idCadastrado = $conexao->insert_id;
        $this->setIdCliente($idCadastrado);
        return $executou;
    }

    public function delete()
    {
        $conexao = Banco::getConexao();
        $sql = "DELETE FROM clientes WHERE id_cliente = ?;";
        $prepareSql = $conexao->prepare($sql);
        $prepareSql->bind_param("i", $this->id_cliente);
        $executou = $prepareSql->execute();
        return $executou;
    }

    public function update()
    {
        $conexao = Banco::getConexao();
        $sql = "UPDATE clientes SET nome_cliente = ?,pedido_cliente = ? WHERE id_cliente = ?;";
        $prepareSql = $conexao->prepare($sql);
        $prepareSql->bind_param("ssi", $this->nome_cliente,$this->pedido_cliente, $this->id_cliente);
        $executou = $prepareSql->execute();
        return $executou;
    }

    public function readById()
    {
        $conexao = Banco::getConexao();
        $sql = "SELECT id_cliente, nome_cliente, pedido_cliente FROM clientes WHERE id_cliente = ?";
        $prepareSql = $conexao->prepare($sql);
        $prepareSql->bind_param("i", $this->id_cliente);
        $executou = $prepareSql->execute();

        $matrizResultados = $prepareSql->get_result();
        $tuplaBanco = $matrizResultados->fetch_object();

        $cliente = new Cliente();
        $cliente->setIdCliente($tuplaBanco->id_cliente);
        $cliente->setNomeCliente($tuplaBanco->nome_cliente);
        $cliente->setPedidoCliente($tuplaBanco->pedido_cliente);

        $prepareSql->close(); // Feche o statement para liberar os recursos
        return $cliente;
    }

    public function readAll()
    {
        $conexao = Banco::getConexao();
        $sql = "SELECT * FROM clientes ORDER BY id_cliente;";
        $prepareSql = $conexao->prepare($sql);
        $prepareSql->execute();

        $matrizResultados = $prepareSql->get_result();
        $clientes_array = array();
        $i = 0;
        while ($tuplaBanco = $matrizResultados->fetch_object()) {
            $clientes = new Cliente();
            $clientes->setIdCliente($tuplaBanco->id_cliente);
            $clientes->setNomeCliente($tuplaBanco->nome_cliente);
            $clientes->setPedidoCliente($tuplaBanco->pedido_cliente);
            $clientes_array[$i] = $clientes;
            $i = $i + 1;
        }
        $prepareSql->close(); 
        return $clientes_array;
    }


    public function logar($usuario,$senha){
        $conexao = Banco::getConexao();
        $sql = "select count(*) as qtd from login where usuario = ? and senha = ?;";
        $prepareSql = $conexao->prepare($sql);
        $prepareSql->bind_param("ss",$usuario,$senha);
        $executou = $prepareSql->execute();
        $matrizTuplas = $prepareSql->get_result();
        $objTupla = $matrizTuplas->fetch_object();
        return $objTupla->qtd > 0;
    }

    public function cadastrar($usuario,$senha){
        $conexao = Banco::getConexao();
        $sql = "insert into login(usuario,senha) values (?,?);";
        $prepareSql = $conexao->prepare($sql);
        $prepareSql->bind_param("ss",$usuario,$senha);
        $executou = $prepareSql->execute();
        return $executou;
    }
}


