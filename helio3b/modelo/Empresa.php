<?php
require_once "modelo/Banco.php";
class Empresa implements JsonSerializable
{
    private $id_empresa;
    private $id_cliente_empresa;
    private $nome_empresa;
    private $cnpj;
    public function jsonSerialize() : mixed
    {
        $obj = new stdClass();
        $obj->id_empresa = $this->getIdEmpresa();
        $obj->id_cliente_atual = $this->getIdClienteEmpresa();
        $obj->nome_empresa = $this->getNomeEmpresa();
        $obj->cnpj = $this->getCnpj();
        return $obj;
    }
    public function getIdEmpresa()
    {
        return $this->id_empresa;
    }
    
    public function setIdEmpresa($id_empresa): self
    {
        $this->id_empresa = $id_empresa;
        return $this;
    }
    
    public function getIdClienteEmpresa()
    {
        return $this->id_cliente_empresa;
    }
    
    public function setIdClienteEmpresa($id_cliente_atual): self
    {
        $this->id_cliente_empresa = $id_cliente_atual;
        return $this;
    }
    
    public function getNomeEmpresa()
    {
        return $this->nome_empresa;
    }
    
    public function setNomeEmpresa($nome_empresa): self
    {
        $this->nome_empresa = $nome_empresa;
        return $this;
    }
    
    public function getCnpj()
    {
        return $this->cnpj;
    }
    
    public function setCnpj($cnpj): self
    {
        $this->cnpj = $cnpj;
        return $this;
    }

    
    public function isEmpresa()
    {
        $conexao = Banco::getConexao();
        $sql = "SELECT COUNT(*) AS qtd FROM empresas WHERE nome_empresa = ?";
        $prepareSql = $conexao->prepare($sql);
        $prepareSql->bind_param("s", $this->nome_empresa);
        $executou = $prepareSql->execute();
        $matrizTuplas = $prepareSql->get_result();
        $objTupla = $matrizTuplas->fetch_object();
        return $objTupla->qtd > 0;
    }
    public function create()
    {
        $conexao = Banco::getConexao();
        $sql = "INSERT INTO empresas (id_cliente_empresa, nome_empresa, cnpj) VALUES (?,?,?)";
        $prepareSql = $conexao->prepare($sql);
        $prepareSql->bind_param("iss", $this->id_cliente_empresa, $this->nome_empresa,$this->cnpj);
        $executou = $prepareSql->execute();
        $idCadastrado = $conexao->insert_id;
        $this->setIdEmpresa($idCadastrado);
        return $executou;
    }

    public function delete()
    {
        $conexao = Banco::getConexao();
        $sql = "DELETE FROM empresas WHERE id_empresa = ?;";
        $prepareSql = $conexao->prepare($sql);
        $prepareSql->bind_param("i", $this->id_empresa);
        $executou = $prepareSql->execute();
        return $executou;
    }

    public function update()
    {
        $conexao = Banco::getConexao();
        $sql = "UPDATE empresas SET nome_empresa = ?, cnpj = ? WHERE id_empresa = ?;";
        $prepareSql = $conexao->prepare($sql);
        $prepareSql->bind_param("ssi", $this->nome_empresa, $this->cnpj,$this->id_empresa);
        $executou = $prepareSql->execute();
        return $executou;
    }

    public function readById()
    {
        $conexao = Banco::getConexao();
        $sql = "SELECT id_empresa, id_cliente_empresa, nome_empresa, cnpj FROM empresas WHERE id_empresa = ?";
        $prepareSql = $conexao->prepare($sql);
        $prepareSql->bind_param("i", $this->id_empresa);
        $executou = $prepareSql->execute();

        $matrizResultados = $prepareSql->get_result();
        $tuplaBanco = $matrizResultados->fetch_object();

        $empresa = new Empresa();
        $empresa->setIdEmpresa($tuplaBanco->id_empresa);
        $empresa->setIdClienteEmpresa($tuplaBanco->id_cliente_empresa);
        $empresa->setNomeEmpresa($tuplaBanco->nome_empresa);
        $empresa->setCnpj($tuplaBanco->cnpj);

        $prepareSql->close(); // Feche o statement para liberar os recursos
        return $empresa;
    }

    public function readAll()
    {
        $conexao = Banco::getConexao();
        $sql = "SELECT * FROM empresas ORDER BY id_empresa;";
        $prepareSql = $conexao->prepare($sql);
        $prepareSql->execute();

        $matrizResultados = $prepareSql->get_result();
        $empresas_array = array();
        $i = 0;
        while ($tuplaBanco = $matrizResultados->fetch_object()) {
            $empresas = new Empresa();
            $empresas->setIdEmpresa($tuplaBanco->id_empresa);
            $empresas->setIdClienteEmpresa($tuplaBanco->id_cliente_empresa);
            $empresas->setNomeEmpresa($tuplaBanco->nome_empresa);
            $empresas->setCnpj($tuplaBanco->cnpj);
            $empresas_array[$i] = $empresas;
            $i = $i + 1;
        }
        $prepareSql->close(); 
        return $empresas_array;
    }
}
