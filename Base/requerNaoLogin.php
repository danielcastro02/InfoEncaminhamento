<?php
require_once "../vendor/autoload.php";

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

    header('location: ' . $pontos . "/index.php");
}
