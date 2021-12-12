<?php

use TCC\Controle\ListaNegraPDO;

require_once "../vendor/autoload.php";

$json_convertido = json_decode(file_get_contents('php://input'), true);
$listaNegraPDO = new ListaNegraPDO();
$listaNegraPDO->processaRequestAWS($json_convertido);
