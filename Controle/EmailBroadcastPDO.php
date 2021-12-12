<?php

namespace TCC\Controle;

use TCC\Modelo\DestinatarioEmail;

class EmailBroadcastPDO extends PDOBase
{

    function selectEmailPendente(){
        $pdo = Conexao::getConexao();
        $stmt = $pdo->prepare('select * from emailbroadcast where id_email in (select id_email from destinatarioemail where status = :status)');
        $stmt->bindValue(":status" , DestinatarioEmail::ST_PENDENTE);
        $stmt->execute();
        if($stmt->rowCount()>0) {
            return $stmt;
        }else{
            return false;
        }
    }

}