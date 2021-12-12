<?php
require_once "../vendor/autoload.php";

use TCC\Controle\EncaminhamentoPDO;

if (!isset($_SESSION)) {
    session_start();
}


$classe = new EncaminhamentoPDO();

if (isset($_GET['function'])) {
    $metodo = $_GET['function'];
    if(method_exists($classe , $metodo)) {
        $classe->$metodo();
    } else {
        http_response_code(401);
    }
}

