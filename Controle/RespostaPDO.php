<?php

namespace TCC\Controle;

use TCC\Modelo\Resposta;
use Ramsey\Uuid\Uuid;

class RespostaPDO extends PDOBase
{

    function inserir(){
        $resposta = new Resposta($_POST);
        $resposta->setIdResposta(Uuid::uuid4()->toString());
        $resposta->setIdServidor($this->getLogado()->getId_usuario());
        $resposta->setResposta(nl2br($resposta->getResposta()));
        $resposta->inserir($resposta);
        $this->printJsonRaw(Resposta::toArray($resposta));
    }

    public function selectByIdEncaminhamento($IdEncaminhamento)
    {
        $pdo = Conexao::getConexao();
        $stmt = $pdo->prepare("select * from resposta where id_encaminhamento = :id_encaminhamento order by data_resposta asc");
        $stmt->bindValue(":id_encaminhamento" , $IdEncaminhamento);
        $stmt->execute();
        if($stmt->rowCount()>0){
            return $stmt;
        }else{
            return false;
        }

    }

}