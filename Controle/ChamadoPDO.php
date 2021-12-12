<?php
namespace TCC\Controle;

use TCC\Modelo\Chamado;
use Ramsey\Uuid\Uuid;


class ChamadoPDO extends PDOBase
{

    function registroChamado()
    {
        $chamado = new Chamado($_POST);
        if ($chamado->getDescricao() == null) {
            exit(0);
        }
        $pdo = Conexao::getConexao();
        $uuid = Uuid::uuid4()->toString();
        $stmt = $pdo->prepare("insert into chamado values (:id , :id_usuario , default , :tipo , :tela , :descricao , :status , default)");
        $stmt->bindValue(":id", $uuid);
        $logado = $this->getLogado();
        $stmt->bindValue(":id_usuario", $logado->getId_usuario());
        $stmt->bindValue(":tipo", $chamado->getTipo());
        $stmt->bindValue(":tela", $chamado->getTela());
        $stmt->bindValue(":descricao", $chamado->getDescricao());
        $stmt->bindValue(":status", Chamado::ST_ABERTO);
        $stmt->execute();
        $emailPDO = new EmailPDO();
        $emailPDO->newChamado($chamado);
        file_put_contents("../Repo/chamados.log", serialize($chamado), FILE_APPEND);
        echo 'true';

    }

    function selectByUser($id_usuario)
    {
        $pdo = Conexao::getConexao();
        $stmt = $pdo->prepare("select * from chamado where id_usuario = :id_usuario order by status desc , hora desc; ");
        $stmt->bindValue(":id_usuario", $id_usuario);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }

    function selectByIdChamado($id_chamado)
    {
        $pdo = Conexao::getConexao();
        $stmt = $pdo->prepare("select * from chamado where id_chamado = :id_chamado;");
        $stmt->bindValue(":id_chamado", $id_chamado);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }

    function selectAtivos()
    {
        $pdo = Conexao::getConexao();
        $stmt = $pdo->prepare("select * from chamado where status = :status;");
        $stmt->bindValue(":status", Chamado::ST_ABERTO);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }

    function fechaChamado()
    {
        $pdo = Conexao::getConexao();
        $stmt = $pdo->prepare("update chamado set status = :status where id_chamado = :id_chamado");
        $stmt->bindValue(":status", Chamado::ST_FECHADO);
        $stmt->bindValue(":id_chamado", $_GET['id_chamado']);
        $stmt->execute();
        header("location: ../Tela/verChamado.php?id_chamado=" . $_GET['id_chamado']);
    }

    function abreChamado()
    {
        $pdo = Conexao::getConexao();
        $stmt = $pdo->prepare("update chamado set status = :status where id_chamado = :id_chamado");
        $stmt->bindValue(":status", Chamado::ST_ABERTO);
        $stmt->bindValue(":id_chamado", $_GET['id_chamado']);
        $stmt->execute();
        $emailPDO = new EmailPDO();
        $emailPDO->chamadoReaberto($_GET['id_chamado']);
        header("location: ../Tela/verChamado.php?id_chamado=" . $_GET['id_chamado']);
    }

    function verifyIdResponsavel($id_chamado, $id_usuario)
    {
        $pdo = Conexao::getConexao();
        $stmt = $pdo->prepare('update chamado set id_responsavel = :id_responsavel where id_chamado = :id_chamado');
        $stmt->bindValue(':id_responsavel', $id_usuario);
        $stmt->bindValue(':id_chamado', $id_chamado);
        return $stmt->execute();
    }


}