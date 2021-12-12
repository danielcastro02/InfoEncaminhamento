<?php
require_once "./vendor/autoload.php";
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['logado'])) {
    header("location: ./Tela/login.php");
}
?>
<!DOCTYPE html>

<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>ProjetoTCC</title>
    <?php

    use TCC\Controle\PDOBase;
    use TCC\Modelo\Encaminhamento;
    use TCC\Modelo\Parametros;
    use TCC\Modelo\Usuario;

    include_once './Base/header.php';
    $parametros = new Parametros();

    ?>
</head>

<body class="homeimg">
<?php
include_once "./Controle/PDOBase.php";
$pdoBase = new PDOBase();

include_once './Base/iNav.php';
?>
<main>
    <div class="row">
        <div class="col s8 offset-l2 card center">
            <h5>Novo encaminhamento:</h5>
            <div class="row">
                <a class="btn large corPadrao2" href="./Tela/encaminhamentoDisciplinar.php">Disciplinar (CAE)</a>
                <a class="btn large corPadrao2" href="./Tela/encaminhamentoPedagogico.php">Pedagogico</a>
            </div>
        </div>
    </div>
    <div class="row containerListCuston">
        <div class="card col s12">
            <div class="divider" style="margin-bottom: 0"></div>
            <div id="loaderEncaminhamentos" class="preloader-wrapper big active"
                 style="left: calc(50% - 32px); top: calc(50% - 32px);">
                <div class="spinner-layer spinner-blue-only">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="gap-patch">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <div id="divEncaminhamentos">
            </div>
        </div>
    </div>
</main>
<script src="./Componentes/listEncaminhamentos.js"></script>
<script>
    $(document).ready(function () {
        getEncaminhamentos()
    })

    function getEncaminhamentos() {
        $('#loaderEncaminhamentos').show()

        $.ajax({
            <?php
            if($pdoBase->getLogado()->getAdministrador() > 0){
            if($pdoBase->getLogado()->getSetor() == Encaminhamento::SET_CAE){
            ?>
            url: '../Controle/encaminhamentoControle.php?function=selectTolistagemCAE',
            <?php
            }else{
            ?>
            url: '../Controle/encaminhamentoControle.php?function=selectTolistagemPedagogico',
            <?php
            }
            }else {
            ?>
            url: '../Controle/encaminhamentoControle.php?function=selectTolistagemByServidorLogado',
            <?php
            }
            ?>
            method: 'get',
            success: function (response) {
                $('#loaderEncaminhamentos').hide()
                console.warn(response)
                if (response.length > 0) {
                    $('#divEncaminhamentos').html(listEncaminhamentos(response))
                } else {
                    $('#divEncaminhamentos').html('<div class="textoSemRetorno">Nenhum dado encontrado.</div>')
                }
            }
        })
    }
</script>
<?php
require_once "./Base/footer.php";
?>
</body>
</html>
