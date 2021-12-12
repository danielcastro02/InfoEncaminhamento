<?php
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
    <div class="row">
        <div class="col s10 offset-s1 card">
            <div class="row center">
                <h5>Console</h5>
            </div>
            <div class="row" id="log" style="height: 300px; color: #3fbf32; background-color: #2b2b2b; overflow: scroll"></div>
            <div class="rew center">
                <a class="btn corPadrao2" href="#!" id="iniciarEnvio">Iniciar Envio</a>
                <a class="btn corPadrao2" href="#!" id="limparconsole">Limpar Console</a>
            </div>
            <div class="row" id="erro"></div>
            <div class="row center">
                <h4>Email a serem enviados:</h4>
            </div>
            <div class="row">
                <ul class="col s12 collection" >
                    <li class="collection-item"><span class="email bold">Destinatário</span><span class="assunto right bold">Assunto Email</span></li>
                    <div id="listaPendente"></div>
                </ul>
            </div>
        </div>
    </div>
</main>
<div class="hide" id="itemLista">
    <li class="collection-item"><span class="email"></span><span class="assunto right"></span></li>
</div>
<script>

    $("#limparconsole").click(function (){
        $("#limparconsole").attr("class" , "btn corPadrao2 disabled");
        $.ajax({
            url: "../Controle/destinatarioEmailControle.php?function=limpaLog",
            success: function (data) {
                $("#erro").html(data);
                $("#limparconsole").attr("class" , "btn corPadrao2");
            }
        });
    });

    $("#iniciarEnvio").click(function (){
        $("#iniciarEnvio").attr("class" , "btn corPadrao2 disabled");
        $.ajax({
            url: "../Controle/emailControle.php?function=starEnvio",
            success: function (data) {
                $("#erro").html(data);
                $("#iniciarEnvio").attr("class" , "btn corPadrao2");
            }
        });
    });

    function updateLista() {
        $("#listaPendente").html("");
        initComponentLoader($("#listaPendente"));
        $.ajax({
            url: "../Controle/destinatarioEmailControle.php?function=getListagem",
            success: function (data) {
                $("#listaPendente").html("");
                var response = JSON.parse(data);
                for (let i = 0; i < response.resultado; i++) {
                    $("#itemLista").find('.email').html(response[i].email);
                    $("#itemLista").find('.assunto').html(response[i].assunto);
                    $("#listaPendente").append($("#itemLista").html());
                }
            }
        });
        $.ajax({
            url: "../Controle/destinatarioEmailControle.php?function=getLog",
            success: function (data) {
                $("#log").html("");
                $("#log").html(data);
            }
        })
    }
    $(document).ready(function (){
       updateLista();
       setInterval(updateLista , 3000);
    });

</script>

<?php
include_once '../Base/footer.php';
?>

<script>
</script>
</body>
</html>
