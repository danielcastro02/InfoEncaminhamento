<?php
$pontos = "";
if (realpath("./index.php")) {
    $pontos = './';
} else {
    if (realpath("../index.php")) {
        $pontos = '../';
    } else {
        if (realpath("../../index.php")) {
            $pontos = '../../';
        }
    }
}
require_once $pontos."vendor/autoload.php";

if (!isset($_SESSION)) {
    session_start();
}

use TCC\Modelo\Parametros;
use TCC\Modelo\Usuario;

$parametros = new Parametros();
$uri = $_SERVER['REQUEST_URI'];
$teste = false;
$um = 1;
while(strstr($uri , "//")){
    $uri = str_replace("//", "/" , $uri, $um);
    $teste = true;
}
if($teste){
    echo "<script>window.location.href = '".$parametros->getServer().$uri."'</script>";
}

if (!isset($_SESSION['logado'])) {
    if (isset($_COOKIE['user'])) {
        echo "<script>window.location.href = '".$pontos."Controle/usuarioControle.php?function=loginByCookie&url=".$_SERVER['REQUEST_URI']."'</script>";
        exit();
    }
    include_once $pontos . 'Base/navDeslogado.php';
} else {
    $usuario = new Usuario(unserialize($_SESSION['logado']));

    if ($usuario->getAdministrador() == 0) {
        include_once $pontos . "Base/navLogado.php";
    } else {
        include_once $pontos . "Base/navAdm.php";
    }
}