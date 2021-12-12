<?php

namespace TCC\Controle;

use TCC\Modelo\Chamado;
use TCC\Modelo\Email;
use TCC\Modelo\Mensagem;
use TCC\Modelo\Parametros;
use TCC\Modelo\Usuario;
use Ramsey\Uuid\Uuid;

class MensagemPDO extends PDOBase
{

    function inserirMensagem(){
        $uuid = Uuid::uuid4()->toString();
        $pdo = Conexao::getConexao();
        $parametros = new Parametros();
        $mensagem = new Mensagem($_POST);
        $mensagem->setIdUsuario($this->getLogado()->getId_usuario());
        if($this->getLogado()->getAdministrador()==0){
            $mensagem->setFromUser(1);
            $chamadoPDO = new ChamadoPDO();
            $chamado = $chamadoPDO->selectByIdChamado($mensagem->getIdChamado());
            $chamado = new Chamado($chamado->fetch());
            if($chamado->getIdResponsavel() != null){
                $usuarioPDO = new UsuarioPDO();
                $usuario = $usuarioPDO->selectUsuarioId_usuario($chamado->getIdResponsavel());
                $usuario = new Usuario($usuario->fetch());
                $email = new Email();
                $email->addDestinatario($usuario->getEmail(), $usuario->getNome());
                $email->setAssunto("Resposta do Cliente");
                $email->setTituloModeP("O cliente respondeu o chamado");
                $email->setMensagemModeP("<p>Chamado:".$chamado->getDescricao()."</p>
                <p>Resposta: ".$mensagem->getMensagem()."</p>
                <p><a href='". $parametros->getServer() ."/Tela/verChamado.php?id_chamado=". $mensagem->getIdChamado() ."'>Acessar chamado</a></p>
                ");
                $email->enviar();
            }
        }else{
            $mensagem->setFromUser(0);
            $chamadoPDO = new ChamadoPDO();
            $chamado = $chamadoPDO->selectByIdChamado($mensagem->getIdChamado());
            $chamadoPDO->verifyIdResponsavel($mensagem->getIdChamado(), $mensagem->getIdUsuario());
            $chamado = new Chamado($chamado->fetch());
            $usuarioPDO = new UsuarioPDO();
            $usuario = $usuarioPDO->selectUsuarioId_usuario($chamado->getIdUsuario());
            $usuario = new Usuario($usuario->fetch());
            $email = new Email();
            $email->addDestinatario($usuario->getEmail(), $usuario->getNome());
            $email->setAssunto("Resposta ao Chamado");
            $email->setTituloModeP("Olá, respondemos ao seu chamado!");
            $email->setMensagemModeP("<p>Chamado:".$chamado->getDescricao()."</p>
                <p>Resposta: ".$mensagem->getMensagem()."</p>
                <p>Não responda este e-mail, acesso o chamado clicando aqui: <a href='". $parametros->getServer() ."/Tela/verChamado.php?id_chamado=". $mensagem->getIdChamado() ."'>Chamado</a></p>");
            $email->enviar();
        }
        $stmt = $pdo->prepare("insert into mensagem values (:uuid , :id_chamado , :id_usuario , :from_user , :mensagem , default)");
        $stmt->bindValue(":uuid" , $uuid);
        $stmt->bindValue(":id_chamado", $mensagem->getIdChamado());
        $stmt->bindValue(":id_usuario", $mensagem->getIdUsuario());
        $stmt->bindValue(":from_user" , $mensagem->getFromUser());
        $stmt->bindValue(":mensagem" , $mensagem->getMensagem());
        $stmt->execute();

        header("location: ../Tela/verChamado.php?id_chamado=".$mensagem->getIdChamado());
    }

    function selectMensagemIdChamado($id_chamado){
        $pdo = Conexao::getConexao();
        $stmt = $pdo->prepare("select * from mensagem where id_chamado = :id_chamado order by hora asc");
        $stmt->bindValue(":id_chamado" , $id_chamado);
        $stmt->execute();
        if($stmt->rowCount()>0){
            return $stmt;
        }else{
            return false;
        }
    }
}
                