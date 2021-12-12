<?php
require_once "../vendor/autoload.php";

use TCC\Controle\ChamadoPDO;

if (!isset($_SESSION)) {
    session_start();
}
$classe = new ChamadoPDO();
if (isset($_GET['function'])) {
    $metodo = $_GET['function'];
    if(method_exists($classe , $metodo)) {
        $classe->$metodo();
    } else {
        http_response_code(401);
    }
}