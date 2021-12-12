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
                <div class="col l6 m8 s10 offset-l3 offset-m2 offset-s1 card center">
                    <h5>Manutenção</h5>
                    <p>Olá, desculpe pelo inconveniente, a função que você tentou acessar esta suspensa para manutenção, logo deverá estar de
                    volta e funcionando melhor :)</p>
                    <div class="row">
                        <a class="btn waves-effect  corPadrao2" href="javascript:location.href = document.referrer;">Voltar</a>
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

