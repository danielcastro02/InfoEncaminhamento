<?php

use TCC\Controle\PDOBase;
use TCC\Modelo\Usuario;

if(isset($_SESSION['logado'])){
    $usuario = new Usuario(unserialize($_SESSION['logado']));
    PDOBase::staticLog($_SERVER["REQUEST_URI"] , "Tracker/".$usuario->getNome().$usuario->getId_usuario().".log");
}