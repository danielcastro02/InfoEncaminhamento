<?php
if(!isset($_SESSION)){
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
        <div class="col l10 m10 s10 offset-l1 offset-m1 offset-s1 card center">
            <h5>Você não deveria ter vindo aqui... De meia volta e continue fazendo o que costuma fazer...</h5>
            <div style="width: auto; min-height: 300px; background-image: url('../Img/gisSuspeito.gif'); background-position: center;
background-size: cover;"></div>
            <div class="row"></div>
            <div class="row">
                <a class="btn waves-effect  corPadrao2" href='../Tela/login.php'>Voltar</a>
            </div>
        </div>
    </div>
</main>
<?php
include_once '../Base/footer.php';
?>

<script>
    $("#telefone").mask("(00) 00000-0000");
</script>
</body>
</html>

