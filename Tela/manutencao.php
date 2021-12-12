<?php
if(!isset($_SESSION)){
    session_start();
}
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
        include_once '../Base/navDeslogado.php';
        ?>
        <main>
            <div class="row">
                <div class="col l6 m8 s10 offset-l3 offset-m2 offset-s1 card center">
                    <h5>Estamos fechados pra manutenção!</h5>
                    <p>Nossa equipe está desempenhando uma atualização pra trazer mais beneficios e velocidade aos seus negócios...
Pode estar corrigindo bugs tambem... Ou adicinando mais...</p>
                    <div class="row">
                        Previsão para término 18:00
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

