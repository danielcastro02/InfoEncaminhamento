<?php
require_once "../vendor/autoload.php";

if (!isset($_SESSION)) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <?php
        include_once '../Base/header.php';
        use TCC\Modelo\Parametros;
        $parametros = new Parametros();
    ?>
    <title><?php echo $parametros->getNome_empresa(); ?></title>

<body class="homeimg">
<?php
    include_once '../Base/iNav.php';
?>
<main>
    <div class="hide-on-med-and-down" style="margin-top: 1vh;"></div>
    <div class="row">
        <div class="card col s8 offset-s2">
            <div class="row center">
                <p>Verificamos que seu e-mail já está registrado em nosso sistema. Por favor, acesse seu e-mail e complete seu cadastro.</p>
<!--                <a href="https://mail.google.com/mail/u/0/#search/Completar++cadastro" target="_blank" rel="noopener" class="btn red darken-2">Ir para o Gmail</a>-->
<!--                <a href="https://outlook.live.com/mail/0/inbox" target="_blank" rel="noopener" class="btn blue darken-2">Ir para o Outlook</a>-->
<!--                <a href="https://outlook.live.com/mail/0/inbox" target="_blank" rel="noopener" class="btn blue darken-2">Ir para o Hotmail</a>-->
                <br>
            </div>
        </div>
    </div>
</main>
<?php
    include_once '../Base/footer.php';
?>
</body>
</html>

