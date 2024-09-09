<?php
require_once "modelo/Banco.php";
class Estagiario implements JsonSerializable
{
    private $id_estagiario;
    private $nome_estagiario;
    private $data_nascimento;
    private $telefone;
    private $email;
    private $id_empresa;

    public function jsonSerialize() : mixed
    {
        $obj = new stdClass();
        $obj->id_estagiario = $this->getIdEstagiario();
        $obj->nome_estagiario = $this->getNomeEstagiario();
        $obj->data_nascimento = $this->getDataNascimento();
        $obj->telefone = $this->getTelefone();
        $obj->email = $this->getEmail();
        $obj->id_empresa = $this->getIdEmpresa();
        return $obj;
    }

    public function getIdEstagiario()
    {
        return $this->id_estagiario;
    }

    public function setIdEstagiario($id_estagiario): self
    {
        $this->id_estagiario = $id_estagiario;

        return $this;
    }

    public function getNomeEstagiario()
    {
        return $this->nome_estagiario;
    }

    public function setNomeEstagiario($nome_estagiario): self
    {
        $this->nome_estagiario = $nome_estagiario;

        return $this;
    }

    public function getDataNascimento()
    {
        return $this->data_nascimento;
    }

    public function setDataNascimento($data_nascimento): self
    {
        $this->data_nascimento = $data_nascimento;

        return $this;
    }

    public function getTelefone()
    {
        return $this->telefone;
    }

    public function setTelefone($telefone): self
    {
        $this->telefone = $telefone;

        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email): self
    {
        $this->email = $email;

        return $this;
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
    
    public function isEstagiario()
    {
        $conexao = Banco::getConexao();
        $sql = "SELECT COUNT(*) AS qtd FROM estagiarios WHERE nome_estagiario = ?;";
        $prepareSql = $conexao->prepare($sql);
        $prepareSql->bind_param("s", $this->nome_estagiario);
        $executou = $prepareSql->execute();
        $matrizTuplas = $prepareSql->get_result();
        $objTupla = $matrizTuplas->fetch_object();
        return $objTupla->qtd > 0;
    }
    public function create()
    {
        $conexao = Banco::getConexao();
        $sql = "INSERT INTO estagiarios (id_estagiario,nome_estagiario,data_nascimento,telefone,email,id_empresa) VALUES (?,?,?,?,?,?);";
        $prepareSql = $conexao->prepare($sql);
        $prepareSql->bind_param("issssi", $this->id_estagiario, $this->nome_estagiario, $this->data_nascimento,$this->telefone,$this->email,$this->id_empresa);
        $executou = $prepareSql->execute();
        $idCadastrado = $conexao->insert_id;
        $this->setIdEstagiario($idCadastrado);
        return $executou;
    }

    public function delete()
    {
        $conexao = Banco::getConexao();
        $sql = "DELETE FROM estagiarios WHERE id_estagiario = ?;";
        $prepareSql = $conexao->prepare($sql);
        $prepareSql->bind_param("i", $this->id_estagiario);
        $executou = $prepareSql->execute();
        return $executou;
    }

    public function update()
    {
        $conexao = Banco::getConexao();
        $sql = "UPDATE estagiarios SET nome_estagiario = ?,data_nascimento = ?, telefone = ?, email = ? WHERE id_estagiario = ?;";
        $prepareSql = $conexao->prepare($sql);
        $prepareSql->bind_param("ssssi", $this->nome_estagiario,$this->data_nascimento,$this->telefone,$this->email, $this->id_estagiario);
        $executou = $prepareSql->execute();
        return $executou;
    }

    public function readById()
    {
        $conexao = Banco::getConexao();
        $sql = "SELECT id_estagiario,nome_estagiario,data_nascimento,telefone,email,id_empresa FROM estagiarios WHERE id_estagiario = ?";
        $prepareSql = $conexao->prepare($sql);
        $prepareSql->bind_param("i", $this->id_estagiario);
        $executou = $prepareSql->execute();

        $matrizResultados = $prepareSql->get_result();
        $tuplaBanco = $matrizResultados->fetch_object();

        $estagiario = new Estagiario();
        $estagiario->setIdEstagiario($tuplaBanco->id_estagiario);
        $estagiario->setNomeEstagiario($tuplaBanco->nome_estagiario);
        $estagiario->setDataNascimento($tuplaBanco->data_nascimento);
        $estagiario->setTelefone($tuplaBanco->telefone);
        $estagiario->setEmail($tuplaBanco->email);

        $prepareSql->close(); // Feche o statement para liberar os recursos
        return $estagiario;
    }

    public function readAll()
    {
        $conexao = Banco::getConexao();
        $sql = "SELECT * FROM estagiarios ORDER BY id_estagiario;";
        $prepareSql = $conexao->prepare($sql);
        $prepareSql->execute();

        $matrizResultados = $prepareSql->get_result();
        $estagiarios_array = array();
        $i = 0;
        while ($tuplaBanco = $matrizResultados->fetch_object()) {
            $estagiarios = new Estagiario();
            $estagiarios->setIdEstagiario($tuplaBanco->id_estagiario);
            $estagiarios->setNomeEstagiario($tuplaBanco->nome_estagiario);
            $estagiarios->setDataNascimento($tuplaBanco->data_nascimento);
            $estagiarios->setTelefone($tuplaBanco->telefone);
            $estagiarios->setEmail($tuplaBanco->email);
            $estagiarios->setIdEmpresa($tuplaBanco->id_empresa);
            $estagiarios_array[$i] = $estagiarios;
            $i = $i + 1;
        }
        $prepareSql->close(); 
        return $estagiarios_array;
    }
}
