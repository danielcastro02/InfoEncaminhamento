<?php

namespace TCC\Controle;


use TCC\Modelo\DestinatarioEmail;

class DestinatarioEmailPDO extends PDOBase
{

    function updateEnviados($arrayIds){
        $paramns = "";
        $cont = 0;
        foreach ($arrayIds as $id){
            $paramns = $paramns . ":param" . $cont . "," ;
            $cont++;
        }
        $paramns = substr($paramns, 0, -1);
        $pdo = Conexao::getConexao();
        $stmt = $pdo->prepare("update destinatarioemail set status = :status where id_destinatarioemail in (".$paramns.")");
        $cont = 0;
        foreach ($arrayIds as $id){
            $stmt->bindValue(":param" . $cont , $id);
            $cont++;
        }
        $stmt->bindValue(":status" , DestinatarioEmail::ST_ENVIADO);
        return $stmt->execute();
    }

    function getListagem(){
        $pdo = Conexao::getConexao();
        $stmt = $pdo->prepare("select u.email as email, d.status as status , eb.assunto  as assunto 
                                        from (destinatarioemail as d inner join usuario as u on u.id_usuario = d.id_usuario) 
                                            inner join emailbroadcast as eb on eb.id_email = d.id_email 
                                        where status = 0");
        $stmt->execute();
        $this->printJsonStmt($stmt);
    }

    function limpaLog(){
        file_put_contents("../Logs/logEnvioEmMassa.log" , "");
    }

    function getLog(){
        echo nl2br(file_get_contents("../Logs/logEnvioEmMassa.log"));
    }

}