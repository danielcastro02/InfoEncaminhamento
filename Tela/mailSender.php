<?php
if (!isset($_SESSION)) {
    session_start();
}
include_once "../Base/permissao.php";
include_once "../Base/requerGodMode.php"
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>ProjetoTCC</title>
    <?php
    include_once '../Base/header.php';
    ?>
<body class="homeimg" >
<?php
include_once '../Base/iNav.php';
use TCC\Modelo\Parametros;
$parametros = new Parametros()
?>
<main>

    <div class="row center">
        <h4>Enviar Email</h4>
        <form action="../Componentes/mailPrevew.php" target="iframeprevew" id="formEmail" method="post">
            <div class="col s10 offset-s1">
                <div class="row card">
                    <div class="col s4 input-field">
                        <select name="tipo">
                            <option value="0">NewsLetter</option>
                            <option value="1" selected>Notificação</option>
                            <option value="3">Pesquisa</option>
                        </select>
                    </div>
                    <div class="col s4 input-field">
                        <select name="modulo">
                            <option value="0">Qualquer</option>
                            <option value="1">Clientes</option>
                            <option value="2">Forncedores</option>
                            <option value="3">Recebimento</option>
                            <option value="4">Pagamento</option>
                            <option value="5">Estoque</option>
                            <option value="6">Contas</option>
                            <option value="7">Categorias</option>
                            <option value="8">Vendas</option>
                        </select>
                    </div>
                    <div class="col s4 input-field">
                        <p>
                            <label>
                                <input type="checkbox" name="prioridade"/>
                                <span>Email Prioritário</span>
                            </label>
                        </p>
                    </div>
                    <div class="col s12 input-field">
                        <input autocomplete="off" type="text" name="assunto" id="assunto">
                        <label for="assunto">Assunto</label>
                    </div>
                    <div class="col s12 input-field">
                        <textarea class="materialize-textarea" name="conteudo" id="conteudo"></textarea>
                        <label for="conteudo">Conteudo</label>
                    </div>
                </div>
                <div class="row center">
                    <a href="../index.php" class="btn corPadrao3 btnFooter">
                        <i class="material-icons left">keyboard_arrow_left</i>
                        Voltar
                    </a>
                    <button type="submit" id="verPrevew" class="btn waves-effect corPadrao2 enviar btnFooter" value="">
                        <i class="material-icons right">done</i>
                        Ver Prevew
                    </button>
                    <button type="submit" id="send" class="btn waves-effect corPadrao2 enviar btnFooter" value="">
                        <i class="material-icons right">done</i>
                        Enviar E-mail
                    </button>
                </div>
            </div>
        </form>
        <div class="col s12" style="display: none;" id="mostraaqui">
            <h5>Prevew</h5>
            <iframe width="100%" height="700px" name="iframeprevew" src="../Componentes/mailPrevew.php" id="prevew">

            </iframe>
        </div>
    </div>

    <script>
        var x = false;
        $("select").formSelect();
        $("#verPrevew").click(function () {
            if(x == false) {
                $("#mostraaqui").slideToggle();
                x = true;
            }
        });
        $("#send").click(function (e){
            e.preventDefault();
            $("#formEmail").attr("action" , "../Controle/emailControle.php?function=broadCast");
            $("#formEmail").attr("target" , "");
            $("#formEmail").submit();

        })
    </script>
</main>
<?php
include_once '../Base/footer.php';
?>
</body>
</html>
<script>
</script>

