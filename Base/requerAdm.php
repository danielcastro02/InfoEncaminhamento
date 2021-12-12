<?php
require_once "../vendor/autoload.php";

use TCC\Modelo\Usuario;

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
if (!isset($_SESSION)) {
    session_start();
}
if (isset($_SESSION['logado'])) {
    $usuario = new Usuario(unserialize($_SESSION['logado']));
    if ($usuario->getAdministrador() == 0) {
        header('location: ' . $pontos . "Tela/acessoNegado.php");
    } else {
        $logado = $usuario;
    }
} else {
    header('location: ' . $pontos . "Tela/acessoNegado.php");
}

