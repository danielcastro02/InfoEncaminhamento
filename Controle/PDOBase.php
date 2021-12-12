<?php

namespace TCC\Controle;



use DateTime;
use TCC\Modelo\Parametros;
use TCC\Modelo\Usuario;
use PDO;
use PDOStatement;

date_default_timezone_set('America/Recife');

class PDOBase
{

    public function __construct()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
    }

    public static function staticLog($content, string $file)
    {
        $data = new \DateTime();
        file_put_contents(__DIR__ . "/../Logs/" . $file, "
" . $data->format("d/m/Y H:i:s - - -") . $content, FILE_APPEND);
    }

    function getToasts()
    {
        header('Content-Type: application/json');
        $fileName = "../Repo/Toasts/" . $this->getLogado()->getId_usuario() . ".toasts";
        if (realpath($fileName)) {
            $file = file_get_contents($fileName);
            $array = array_filter(explode("\n", $file));
            echo "{
    \"toasts\":true ,
    \"size\": " . count(file($fileName)) . " ,
    \"texts\" : " .
                json_encode($array) .
                "}";
            unlink($fileName);
        } else {
            echo "{\"toasts\":false}";
        }
    }

    /**
     * @return Retorna o id da entidade logada atualmente ou false caso não possua
     */
    public function getIdEntidade()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        if (isset($_SESSION['entidade'])) {
            return $_SESSION['entidade'];
        } else {
            return false;
        }
    }

    static function addToastStatic(string $toast)
    {
        if(PDOBase::getLogadoStatic()) {
            $fileName = "../Repo/Toasts/" . PDOBase::getLogadoStatic()->getId_usuario() . ".toasts";
            file_put_contents($fileName, $toast . "\n", FILE_APPEND);
        }else{
            $_SESSION["toast"][] = $toast;
        }
    }

    public function addToast(string $toast)
    {
        if($this->getLogado()) {
            $fileName = "../Repo/Toasts/" . $this->getLogado()->getId_usuario() . ".toasts";
            file_put_contents($fileName, $toast . "\n", FILE_APPEND);
        }else{
            $_SESSION["toast"][] = $toast;
        }
    }

    public function log(string $content, string $file = "logEmergence")
    {
        $data = new \DateTime();
        file_put_contents(__DIR__ . "/../Logs/" . $file, "
" . $data->format("d/m/Y H:i:s - - -") . $content, FILE_APPEND);
    }

    function requerGodMode()
    {
        if ($this->getLogado()->getAdministrador() < 2) {
            $this->addToast("Você não tem permissão para realizar esta ação!");
            header('location: ../index.php');
            exit(0);
        }
    }

    public function requerLogin()
    {
        if (!isset($_SESSION['logado'])) {
            $this->addToast("Você precisa fazer login para acessar esta função!");
            header("location: ../Tela/login.php");
            exit(0);
        }
    }

    public function requerEntidadeAjax()
    {
        if (!isset($_SESSION['entidade'])) {
            echo "false";
            exit(0);
        }
    }

    /**
     * Envia teu stmt aqui e confia, vai imprimir certinho
     * @author Adivinha?
     * @param PDOStatement $stmt
     * @return JSON Printa o json do teu stmt.
     */


    function printJsonRawStmt(PDOStatement $stmt)
    {
        header('Content-Type: application/json');
        if ($stmt->rowCount() > 0) {
            echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        } else {
            echo json_encode(array("resultado" => 0));
        }
    }

    function restError(string $string)
    {
        header('Content-Type: application/json');
        echo "{ERROR : $string}";
    }

    function cleanNumber($number){
        return preg_replace("/[^0-9]/", "", $number)/100;
    }

    function printJsonStmt(PDOStatement $stmt)
    {
        header('Content-Type: application/json');
        if ($stmt->rowCount() > 0) {
            $resultado["resultado"] = $stmt->rowCount();
            while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $resultado[] = $linha;
            }
            echo json_encode($resultado);
        } else {
            echo json_encode(array("resultado" => 0));
        }
    }
    function printJsonArray(array $array)
    {
        header('Content-Type: application/json');
        if (count($array) > 0) {
            $resultado["resultado"] = count($array);
            foreach ($array as $linha) {
                $resultado[] = $linha;
            }
            echo json_encode($resultado);
        } else {
            echo json_encode(array("resultado" => 0));
        }
    }
    function printJsonRaw($array)
    {
        header('Content-Type: application/json');
        echo json_encode($array);
    }


    function dataFormated2Db($data)
    {
        if (strpos($data, "/") !== false) {
            $data_hora = explode(" ", $data);
            if (count($data_hora) > 1) {
                $arrData = explode("/", $data_hora[0]);
                $data = $arrData[2] . "-" . $arrData[1] . "-" . $arrData[0] . " " . $data_hora[1];
            } else {
                $arrData = explode("/", $data_hora[0]);
                $horaatual = new \DateTime();
                $data = $arrData[2] . "-" . $arrData[1] . "-" . $arrData[0] . " " . $horaatual->format("H:i");
            }
            return $data;
        } else {
            return $data;
        }
    }

    public function requerAdm()
    {
        if (!isset($_SESSION['logado'])) {
            $this->addToast("Você precisa fazer login para acessar esta função!");
            header("location: ../Tela/login.php");
            exit(0);
        } else {
            $usuario = new Usuario(unserialize($_SESSION['logado']));
            if ($usuario->getAdministrador() == 0) {
                header("location: ../Tela/acessoNegado.php");
                exit(0);
            }
        }
    }

    public function getLogado()
    {
        if (isset($_SESSION['logado'])) {
            $usuario = new Usuario(unserialize($_SESSION['logado']));
            return $usuario;
        } else {
            return false;
        }
    }

    public static function getLogadoStatic()
    {
        if (isset($_SESSION['logado'])) {
            $usuario = new Usuario(unserialize($_SESSION['logado']));
            return $usuario;
        } else {
            return false;
        }
    }

    function validateForm($post, $parameters)
    {
        $parametroEntidade = new ParametroEntidade();
        $response = true;
        if ($parametroEntidade->getCategoriasModule()) {
            foreach ($parameters as $parameter) {
                if (trim($post[$parameter]) == "") {
                    $response = false;
                }
            }
        }
        return $response;
    }

    function requerAcessoAcaoEntidade($id_acao)
    {
        $this->requerEntidade();
        $acaoPDO = new AcaoPDO();
        $acao = new Acao($acaoPDO->selectAcaoIdAcao($id_acao)->fetch());
        if ($acao->getIdEntidade() != $_SESSION['entidade']) {
            $this->addToast('Sem permissão');
            header("location: ../index.php");
            exit(0);
        }
        if (!$this->requerAcessoEntidade($acao->getIdEntidade())) {
            $this->addToast('Sem permissão');
            header("location: ../index.php");
            exit(0);
        }
    }

    function getDataHoraBrasilia()
    {
        $date = new DateTime();
        $this->printJsonRaw(array("data" => $date->format('Y-m-d h:i:s')));
    }
}