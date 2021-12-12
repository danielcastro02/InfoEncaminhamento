<?php
require_once "../vendor/autoload.php";

use TCC\Controle\UsuarioPDO;
use TCC\Modelo\Usuario;

$usuarioPDO = new UsuarioPDO();
$stmt = $usuarioPDO->pesquisaListagem($_GET['pesquisa']);
if($stmt){
    while ($linha = $stmt->fetch()){
        $usuario = new Usuario($linha);
        echo "<option value='".$usuario->getId_usuario()."'>".$usuario->getNome()."</option>";
    }
}else{
    echo "<option value='0'>Sem Resultado</option>";
}