<?php

namespace TCC\Controle;

use TCC\Modelo\Encaminhamento;
use PDO;
use Ramsey\Uuid\Uuid;

class EncaminhamentoPDO extends PDOBase
{
    const SELECT_LISTAGEM = "
    select 
       e.id_encaminhamento as id,
       a.nome as nome,
       e.relato as relato,
       m.texto as motivo,
       DATE_FORMAT(e.data_encaminhamento , '%d/%m/%Y %H:%i') as data_aberto,
       DATE_FORMAT(e.data_ocorrencia , '%d/%m/%Y %H:%i') as data_ocorrencia,
       e.status as status
from encaminhamento e 
    inner join aluno a 
        on e.id_aluno = a.id_aluno
    inner join selectoption m
        on m.id_option = e.id_motivo
where 1=1 
    ";

    function insert()
    {

        $encaminhamento = new Encaminhamento($_POST);
        $encaminhamento->setIdEncaminhamento(Uuid::uuid4()->toString());
        $encaminhamento->setIdServidor($this->getLogado()->getId_usuario());
        $encaminhamento->setRelato(nl2br($encaminhamento->getRelato()));
        $encaminhamento->setDataOcorrencia($this->dataFormated2Db($encaminhamento->getDataOcorrencia()));
        if ($encaminhamento->inserir($encaminhamento)) {
            $this->printJsonRaw(Encaminhamento::toArray($encaminhamento));
        } else {
            http_response_code(500);
        }
    }

    function selectByServidor($id_servidor)
    {
        $pdo = Conexao::getConexao();
        $stmt = $pdo->prepare("select * from encaminhamento where id_servidor = :id_servidor");
        $stmt->bindValue(":id_servidor", $id_servidor);
        $stmt->execute();
        $this->printJsonRaw($stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    function selectBySetor($setor)
    {
        $pdo = Conexao::getConexao();
        $stmt = $pdo->prepare("select * from encaminhamento where setor = :setor");
        $stmt->bindValue(":setor", $setor);
        $stmt->execute();
        $this->printJsonRaw($stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    function selectByStatus($status)
    {
        $pdo = Conexao::getConexao();
        $stmt = $pdo->prepare("select * from encaminhamento where status = :status");
        $stmt->bindValue(":status", $status);
        $stmt->execute();
        $this->printJsonRaw($stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    function selectByAluno($id_aluno)
    {
        $pdo = Conexao::getConexao();
        $stmt = $pdo->prepare("select * from encaminhamento where id_aluno = :id_aluno");
        $stmt->bindValue(":id_aluno", $id_aluno);
        $stmt->execute();
        $this->printJsonRaw($stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    public function selectObjectByIdEncaminhamento($id_encaminhamento)
    {
        $pdo = Conexao::getConexao();
        $stmt = $pdo->prepare("select * from encaminhamento where id_encaminhamento = :id_encaminhamento");
        $stmt->bindValue(":id_encaminhamento", $id_encaminhamento);
        $stmt->execute();
        return new Encaminhamento($stmt->fetch(PDO::FETCH_ASSOC));
    }

    function updateStatus()
    {
        $encaminhamento = new Encaminhamento($_POST);
        $pdo = Conexao::getConexao();
        $stmt = $pdo->prepare("update encaminhamento set status = :status where id_encaminhamento = :id_encaminhamento");
        $stmt->bindValue(":status", $encaminhamento->getStatus());
        $stmt->bindValue(":id_encaminhamento", $encaminhamento->getIdEncaminhamento());
        $stmt->execute();
    }

    function selectTolistagem()
    {
        $pdo = Conexao::getConexao();
        $stmt = $pdo->prepare(self::SELECT_LISTAGEM . "
 and e.status <> :status");
        $stmt->bindValue(":status", Encaminhamento::STT_RESOLVIDO);
        $stmt->execute();
        $this->printJsonRaw($stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    function selectTolistagemPedagogico()
    {
        $pdo = Conexao::getConexao();
        $stmt = $pdo->prepare(self::SELECT_LISTAGEM . "
 and e.status <> :status
and e.setor = :setor");
        $stmt->bindValue(":status", Encaminhamento::STT_RESOLVIDO);
        $stmt->bindValue(":setor", Encaminhamento::SET_PEDAGOGICO);
        $stmt->execute();
        $this->printJsonRaw($stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    function selectTolistagemCAE()
    {
        $pdo = Conexao::getConexao();
        $stmt = $pdo->prepare(self::SELECT_LISTAGEM . "
 and e.status <> :status
and e.setor = :setor");
        $stmt->bindValue(":status", Encaminhamento::STT_RESOLVIDO);
        $stmt->bindValue(":setor", Encaminhamento::SET_CAE);

        $stmt->execute();
        $this->printJsonRaw($stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    function selectTolistagemByServidorLogado()
    {
        $pdo = Conexao::getConexao();
        $stmt = $pdo->prepare(self::SELECT_LISTAGEM . "
 and e.status <> :status
and e.id_servidor = :id_servidor");
        $stmt->bindValue(":status", Encaminhamento::STT_RESOLVIDO);
        $stmt->bindValue(":id_servidor", $this->getLogado()->getId_usuario());
        $stmt->execute();
        $this->printJsonRaw($stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    function selectTolistagemByPesquisa()
    {
        $pdo = Conexao::getConexao();
        $consulta = self::SELECT_LISTAGEM;
        if ($_POST['status'] != 0) {
            $consulta = $consulta . " and status = :status";
        }
        if ($_POST['setor'] != 0) {
            $consulta = $consulta . " and e.setor = :setor";
        }

        if($this->getLogado()->getAdministrador()<1){
            $consulta = $consulta . " and e.id_servidor = :id_servidor";
        }
        if (isset($_POST['id_motivo'])) {
            if ($_POST['id_motivo'] != null) {
                $consulta = $consulta . " and e.id_motivo = :id_motivo";
            }
        }
        if (isset($_POST['id_servidor'])) {
            if ($_POST['id_servidor'] != null) {
                $consulta = $consulta . " and e.id_servidor = :id_servidor";
            }
        }
        if (isset($_POST['id_aluno'])) {
            if ($_POST['id_aluno'] != null) {
                $consulta = $consulta . " and e.id_aluno = :id_aluno";
            }
        }
        if ($_POST['pesquisa'] != "") {
            $consulta = $consulta . "
            and( a.nome like :pesquisa1
            or m.texto like :pesquisa2
            or e.relato like :pesquisa3
            or e.id_servidor in (select id_usuario from usuario where nome like :pesquisa4)
            )
        ";
        }
        $stmt = $pdo->prepare($consulta);
        if ($_POST['status'] != 0) {
            $stmt->bindValue(":status", $_POST['status']);
        }
        if ($_POST['setor'] != 0) {
            $stmt->bindValue(":setor", $_POST['setor']);
        }
        if($this->getLogado()->getAdministrador()<1){
            $stmt->bindValue(":id_servidor", $this->getLogado()->getId_usuario());
        }
        if (isset($_POST['id_motivo'])) {
            if ($_POST['id_motivo'] != null) {
                $stmt->bindValue(":id_motivo", $_POST['id_motivo']);
            }
        }
        if (isset($_POST['id_servidor'])) {
            if ($_POST['id_servidor'] != null) {
                $stmt->bindValue(":id_servidor", $_POST['id_servidor']);
            }
        }
        if (isset($_POST['id_aluno'])) {
            if ($_POST['id_aluno'] != null) {
                $stmt->bindValue(":id_aluno", $_POST['id_aluno']);
            }
        }
        if ($_POST['pesquisa'] != "") {
            $pesquisa = '%' . $_POST['pesquisa'] . '%';
            $stmt->bindValue(":pesquisa1", $pesquisa);
            $stmt->bindValue(":pesquisa2", $pesquisa);
            $stmt->bindValue(":pesquisa3", $pesquisa);
            $stmt->bindValue(":pesquisa4", $pesquisa);
        }

        $stmt->execute();
        $this->printJsonRaw($stmt->fetchAll(PDO::FETCH_ASSOC));
    }

}