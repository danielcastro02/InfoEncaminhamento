<?php

namespace TCC\Controle;

use Ramsey\Uuid\Uuid;

class ListaNegraPDO extends PDOBase
{

    function addRecipient($email){
        $pdo = Conexao::getConexao();
        $stmt = $pdo->prepare("insert into emaillistanegra values (:id_emaillistanegra , :email)");
        $stmt->bindValue(":id_emaillistanegra" , Uuid::uuid4()->toString());
        $stmt->bindValue(":email" , $email);
        $stmt->execute();
    }

    public function processaRequestAWS($json_convertido)
    {
        $message = json_decode($json_convertido['Message'], true);
        $bounceRecipients = $message['bounce']['bouncedRecipients'];
        foreach ($bounceRecipients as $bounce){
            $this->addRecipient($bounce['emailAddress']);
        }
    }

}