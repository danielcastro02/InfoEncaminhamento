<?php

namespace TCC\Controle;

use TCC\Modelo\SelectOption;
use PDO;
use Ramsey\Uuid\Uuid;

class SelectOptionPDO extends PDOBase
{

    function insert(){
        $selectOption = new SelectOption($_POST);
        $selectOption->setIdOption(Uuid::uuid4()->toString());
        $selectOption->inserir($selectOption);
        header('Content-Type: application/json');
        $this->printJsonRaw(SelectOption::toArray($selectOption));
    }

    function selectByTipo($tipo){
        $pdo = Conexao::getConexao();
        $stmt = $pdo->prepare("select * from selectoption where tipo = :tipo");
        $stmt->bindValue(":tipo" , $tipo);
        $stmt->execute();
        $this->printJsonRaw($stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    function selectTurmaToModal(){
        $pdo = Conexao::getConexao();
        $stmt = $pdo->prepare("select id_option as id , texto as nome from selectoption where tipo = :tipo and texto like :filtro");
        $stmt->bindValue(":tipo" , SelectOption::TP_TURMA);
        $stmt->bindValue(':filtro', '%' . $_POST['busca'] . '%');
        $stmt->execute();
        $this->printJsonRaw($stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    function selectToModal(){
        $pdo = Conexao::getConexao();
        $selectOption = new SelectOption($_POST);
        $stmt = $pdo->prepare("select id_option as id , texto as nome from selectoption where tipo = :tipo and setor = :setor and texto like :filtro");
        $stmt->bindValue(":tipo" , $selectOption->getTipo());
        $stmt->bindValue(":setor" , $selectOption->getSetor());
        $stmt->bindValue(':filtro', '%' . $_POST['busca'] . '%');
        $stmt->execute();
        $this->printJsonRaw($stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    public function selectObjectByIdOption($idOption)
    {
        $pdo = Conexao::getConexao();
        $stmt = $pdo->prepare("select * from selectoption where id_option = :id_option");
        $stmt->bindValue(":id_option" , $idOption);
        $stmt->execute();
        return new SelectOption($stmt->fetch(PDO::FETCH_ASSOC));
    }

}