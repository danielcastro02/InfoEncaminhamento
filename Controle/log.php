<?php
use TCC\Controle\PDOBase;
$PDOBase = new PDOBase();

$PDOBase->log("_____________________________________" , $_GET['file']);
$PDOBase->log($_GET['data'] , $_GET['file']);