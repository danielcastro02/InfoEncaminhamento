<?php
if(!isset($_SESSION)){
    session_start();
}
require_once "../Base/requerGodMode.php";
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Voltamos Logo</title>
    <?php
    include_once '../Base/header.php';
    ?>
<body class="homeimg">
<?php
include_once '../Base/iNav.php';
?>
<main>
    <div class="row">
        <div class="col s10 offset-s1 card center">
            <?php
            $path = "../Logs/Tracker/";
            $diretorio = dir($path);

            echo "Lista de Arquivos do diretório '<strong>".$path."</strong>':<br />";
            while($arquivo = $diretorio -> read()){
            echo "<a target='_blank' href='".$path.$arquivo."'>".$arquivo."</a><br />";
            }
            $diretorio -> close();
            ?>
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

