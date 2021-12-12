<?php
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

use TCC\Modelo\Parametros;

$parametros = new Parametros();
$data = new DateTime();
include_once $pontos . 'Componentes/modalSugestoes.php';
?>


<footer class="page-footer corPadrao2" style="padding-top: 3px">
    <div class="footer-copyright" style="align-items: center; justify-content: center;">
        <div class="center-align">
            <a target="_blank" rel="noopener" href="https://TCC.app/" class="center col s12 white-text">
                © <?php echo $data->format("Y"); ?> Projeto<b>TCC</b></a>
        </div>
    </div>
</footer>


<!--Codigo que realiza os loaders-->
<div id="preLoader"
     style="z-index: 214748364; position: fixed; height: 100vh; width: 100vw; background-color: white; opacity: 0.7; ; top: 0; left: 0; display: none;">
    <div style="display: block; position: fixed; left: calc(50% - 32px); top:calc(50% - 32px); opacity: 1;">
        <div class="preloader-wrapper big active">
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
    </div>
</div>

<div id="componenLoader" class="hide">
    <div style="width: 100%; height: 100%;" class="center">
        <div class="preloader-wrapper big active">
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
    </div>
</div>

<script>

    setInterval(function () {
        $.ajax({
            url: "<?php echo $pontos;?>/Controle/usuarioControle.php?function=stayAlive",
            success: function (data) {
                if (data != 'true') {
                    window.location.href = "<?php echo $pontos ?>/index.php";
                }
            }
        });
    }, (1000 * 60 * 25));
    required()


</script>
<!--Não mexam nesses malditos pontos-->
<input id="malditosPontos" value="<?php echo $pontos ?>" hidden/>
<?php
if (isset($_SESSION)) {
    if (isset($_SESSION['logado'])) {
        if ($parametros->getActiveChat() == 1) {
            include_once __DIR__ . "/chat2.php";
        }
    }
}
?>

<div id="testeDeNotifcacao" style="display: none"></div>

<script src="<?php echo $pontos ?>js/notificationService.js">


</script>


