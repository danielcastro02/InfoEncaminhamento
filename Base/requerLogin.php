<?php
require_once "../vendor/autoload.php";

use TCC\Controle\PDOBase;
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
if (!isset($_SESSION['logado'])) {
    PDOBase::addToastStatic("Você precisa estar logado para acessar essa página");
    header('location: ' . $pontos . "Tela/login.php?url=.." . $_SERVER['REQUEST_URI']);
} else {
    $logado = new Usuario(unserialize($_SESSION['logado']));
}

