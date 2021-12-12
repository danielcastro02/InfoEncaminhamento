<?php
require_once "../vendor/autoload.php";

use TCC\Modelo\Usuario;

if (!isset($_SESSION)) {
    session_start();
}
include_once '../Base/requerLogin.php';
$logado = new Usuario(unserialize($_SESSION['logado']));
?>
<form action="../Controle/usuarioControle.php?function=updateSenha" method="POST" id="formTrocaSenha">
    <div class="modal-content">
        <div class="row">
            <h4>Editar Dados</h4>
            <input type="text" name="id_usuario" hidden value="<?php echo $logado->getId_usuario() ?>">
            <div class="input-field col l5 offset-l1 m6 s12">
                <input id="oldSenha" type="password" name="oldSenha">
                <label for="oldSenha">Senha antiga</label>
            </div>
            <div class="input-field col l5 m6 s12">
                <input id="senha1" type="password" name="senha1" required class="tooltipped" data-position="top" data-tooltip="Deve conter 8 caracteres e 1 número">
                <label for="senha1">Nova Senha</label>
            </div>
            <div class="input-field col l10 m12 offset-l1 s12">
                <input id="senha2" type="password" name="senha2" required>
                <label for="senha2">Repita a nova senha</label>
            </div>
        </div>
        <div class="row center divBtn">
            <a href="#!" class="modal-close waves-effect waves-green btn waves-effect  corPadrao3">Cancelar</a>
            <button type="submit" class="btn waves-effect  corPadrao2">
                <i class="material-icons right">done</i>
                Salvar
            </button>
        </div>
    </div>

    </div>
</form>

<script>
    $('.tooltipped').tooltip();
</script>
