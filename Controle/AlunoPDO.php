<?php

namespace TCC\Controle;

use Exception;
use TCC\Modelo\Aluno;
use PDO;
use Ramsey\Uuid\Uuid;

class AlunoPDO extends PDOBase
{

    function insert()
    {
        $aluno = new Aluno($_POST);
        $aluno->setIdAluno(Uuid::uuid4()->toString());
        if ($aluno->inserir($aluno)) {
            header('Content-Type: application/json');
            $this->printJsonRaw(array("id"=>$aluno->getIdAluno() , "nome" => $aluno->getNome()));
        } else {
            http_response_code(500);
        }

    }


    function selectByIdAluno($id_aluno)
    {
        $pdo = Conexao::getConexao();
        $stmt = $pdo->prepare("select * from aluno where id_aluno = :id_aluno");
        $stmt->bindValue(":id_aluno", $id_aluno);
        $stmt->execute();
        $this->printJsonRaw($stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    function selectToModal()
    {
        $pdo = Conexao::getConexao();
        $stmt = $pdo->prepare("
select 
       id_aluno as id ,  
       concat(nome , ' - ' , coalesce((
           select texto 
           from selectoption 
           where id_option = id_turma),'Sem turma')) 
           as nome 
from aluno 
where nome like :filtro");
        $stmt->bindValue(':filtro', '%' . $_POST['busca'] . '%');
        $stmt->execute();
        $this->printJsonRaw($stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    public function selectObjectByIdAluno($id_aluno)
    {
        $pdo = Conexao::getConexao();
        $stmt = $pdo->prepare("select * from aluno where id_aluno = :id_aluno");
        $stmt->bindValue(":id_aluno", $id_aluno);
        $stmt->execute();
        return new Aluno($stmt->fetch(PDO::FETCH_ASSOC));
    }


}