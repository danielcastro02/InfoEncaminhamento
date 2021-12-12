<?php
if (!isset($_SESSION)) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <?php
        include_once '../Base/header.php';
        use TCC\Modelo\Parametros;
        $parametros = new Parametros();
        ?>
        <meta charset="UTF-8">

        <title><?php echo $parametros->getNome_empresa(); ?></title>

    <body class="homeimg">
        <?php
        include_once '../Base/iNav.php';
        ?>
        <main>
            <div class="row">
                <div class="col l6 m8 s10 offset-l3 offset-m2 offset-s1 card center">
                    <h5>Oops!</h5>
                    <p>Parece que você não tem acesso a esta página, verifique se sua sessão não expirou
                        ou entre em contato com o administrador.</p>
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

