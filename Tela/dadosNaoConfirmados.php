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
            <div class="row center">
                <h5>Oops!</h5>

            </div>

            <?php
            if (isset($_GET['email'])) {
                if ($_GET['email'] == 0) {
                    ?>
                    <div class="row center">
                        <div class="col l6 m8 s10 offset-l3 offset-m2 offset-s1 card">
                            <p>Seu e-mail ainda não foi confirmado! Não esqueça de verificar sua caixa de spam!</p>
                            <form action="../Controle/usuarioControle.php?function=reenviaEmail" method="POST">
                                <div class="input-field container">
                                    <button class="btn waves-effect corPadrao2 "type="submit">Reenviar E-mail</button>
                                    <a class="btn waves-effect corPadrao3 white-text" href="./confirmaCadastro.php">Alterar E-mail</a>
                                </div>
                            </form>
                        </div>
                    </div>

                    <?php
                }
            }
            if (isset($_GET['telefone'])) {
                if ($_GET['telefone'] == 0) {
                    ?><div class="row center">
                        <div class="col l6 m8 s10 offset-l3 offset-m2 offset-s1 card">
                            <p>Seu telefone ainda não foi confirmado!</p>
                            <form action="../Controle/usuarioControle.php?function=reenviaSMS&id_usuario=<?php echo $_GET['id_usuario']; ?>" method="POST" id="">
                                <div class="input-field container">
                                    <input autocomplete="off" class="btn waves-effect  corPadrao2" value="Reenviar SMS" type="submit">
                                    <a class="btn waves-effect  corPadrao3" href="./alterarTelefone.php?id_usuario=<?php echo $_GET['id_usuario']; ?>">Alterar Celular</a>
                                </div>
                            </form>
                        </div>
                    </div><?php
                }
            }
            ?>
        </main>
        <?php
        include_once '../Base/footer.php';
        ?>

        <script>

        </script>
    </body>
</html>

