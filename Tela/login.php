<?php
if (!isset($_SESSION)) {
    session_start();
}
if (isset($_SESSION['logado'])) {
    header('location: ../index.php');
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
    <div class='hide-on-small-and-down' style="margin-top: 5vh;"></div>
    <div class="row">
        <form action="../Controle/usuarioControle.php?function=login"
              class="card col l4 offset-l4 m6 offset-m3 s12" method="post">
            <div class="row center" style="margin-bottom: unset">
                <h4 class="textoCorPadrao2">Entrar</h4>
                <div class="input-field col s10 offset-s1">
                    <?php
                    if (isset($_GET['url'])) {
                        echo '<input type="text" hidden="true" name="url" value="' . $_GET['url'] . '"/>';
                    }

                    if (isset($_GET['token'])) {
                        echo '<input type="text" hidden name="token" value="' . $_GET['token'] . '"/>';
                    }
                    ?>
                    <input id="telefoneEmail" type="text" name="usuario" required>
                    <label for="telefoneEmail">E-mail ou Telefone</label>
                </div>
                <div class="input-field col s10 offset-s1">
                    <span>
                        <i class="material-icons right toggle-password iconeOlho">visibility</i>
                    </span>
                    <input class="senha" id="senha" type="password" name="senha">
                    <label for="senha">Senha</label>
                </div>
            </div>
            <div class="center col s10 offset-s1" style="padding: 0;">
                <!--                <a href="../index.php" class="corPadrao3 btn waves-effect ">Voltar</a>-->
                <button type="submit" class="btn waves-effect white-text corPadrao2 btnLogin">Entrar</button>
                <div class="row center">
                    <a class="teal-text" href="./recuperaSenha.php">Esqueci minha senha!</a>
                    <br>
                    Ainda não está cadastrado?
                    <a class="teal-text modal-trigger" href="#modalRegistro">Cadastre-se</a>
                </div>
                <div class='row'>
                    <?php
                    if (isset($_GET['msg'])) {
                        if ($_GET['msg'] == "erro") {
                            echo "<script>M.toast({html: \"Você errou alguma coisa!<br> Ainda não é cadastrado? <a class='btn-flat toast-action textoCorPadrao3 modal-trigger' href='#modalRegistro'>Cadastre-se</a>\", classes: 'rounded'});</script>";
                        }
                    }
                    ?>
                </div>
            </div>

        </form>
    </div>
</main>
<script>
    $(".toggle-password").mousedown(function () {
        var tipoType = $(".senha").attr("type");
        if (tipoType === "password") {
            $(".senha").prop("type", "text");
            $(this).html("visibility_off");
        } else {
            $(".senha").prop("type", "password");
            $(this).html("visibility");
        }
    });

    try {
        if (interfaceAndroid != undefined) {
            toast.makeToast("Senha redefinida!");
            interfaceAndroid.logOut();
        }
    } catch (e) {
        console.log("N é android...")
    }
</script>
<?php
include_once '../Base/footer.php';
?>
</body>
</html>

