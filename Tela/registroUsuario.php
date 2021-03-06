<?php
if (!isset($_SESSION)) {
    session_start();
}
include_once '../Base/requerNaoLogin.php';
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
                <form action="../Controle/usuarioControle.php?function=inserirUsuario" id="formUsuario" class="card col l10 offset-l1 m10 offset-m1 s12" method="post">
                    <div class="row center">
                        <h4 class="textoCorPadrao2">Registre-se</h4>
                        <div class="input-field col s12 l6">
                            <input id="nome" type="text" name="nome"  required class="required">
                            <label for="nome">Nome</label>
                        </div>
                        <?php if(isset($_GET['token'])) {
                            ?>
                        <input type="text" name="token" value="<?php echo $_GET['token'] ?>" hidden/>
                        <?php } ?>
                        <div class="input-field col s12 l6">
                            <input type="text" name="telefone" required id="telefone" class="fone required">
                            <label for="telefone">Telefone</label>
                        </div>
                        <div class="input-field col s12">
                            <input type="email" name="email" required class="required" id="email">
                            <label for="email">E-mail</label>
                        </div>

                        <div class = "input-field col s12 l6">
                            <input type="password" name="senha1" id="senha1"  required class="required">
                            <label for="senha1">Senha</label>
                        </div>
                        <div class = "input-field col s12 l6">
                            <input type="password" name="senha2" id="senha2"  required class="required">
                            <label for="senha2">Repita a senha</label>
                        </div>
                    </div>

                    <div class="row center">
                        <a href="../index.php" class="corPadrao3 btn waves-effect ">Voltar</a>
                        <button type="submit" class="btn waves-effect  corPadrao2" value="">Registrar</button>
                        <?php
                        if (isset($_GET['msg'])) {
                            if ($_GET['msg'] == "senhaerrada") {
                                echo "<script>M.toast({html: \"Senhas n??o coincidem!\", classes: 'rounded'});</script>";
                            }
                        }
                        ?>
                    </div>

                </form>
            </div>
        </main>
        <?php
        include_once '../Base/footer.php';
        ?>

        <script>
            $(".fone").mask("(00) 00000-0000");
            $("#formUsuario").submit(function () {
                if ($(".fone").val().length != 15) {
                    M.toast({html: 'Digite um n??mero de celular v??lido!', classes: 'rounded'})
                    return false;
                } else {
                    var dados = $(this).serialize();
                    var resposta = true;
                    $.ajax({
                        url: '../Controle/usuarioControle.php?function=verificaTelefone',
                        type: 'POST',
                        data: dados,
                        async: false,
                        success: function (data) {
                            if (data == 'true') {
                                resposta = false;
                                $('#telefone').attr('class', 'invalid');
                                M.toast({html: "O telefone j?? existe no sistema!", classes: 'rounded'});
                            } else {
                                $('#telefone').attr('class', 'valid');
                            }
                        }
                    });
                    if ($('#codigo_parceiro').val() !== '') {
                        $.ajax({
                            url: '../Controle/parceiroControle.php?function=verificaCodigoParceiroAjax',
                            type: 'POST',
                            data: dados,
                            async: false,
                            success: function (resposne) {
                                if (resposne) {
                                    $('#codigo_parceiro').attr('class', 'valid');
                                } else {
                                    $('#codigo_parceiro').val('');
                                    M.toast({html: "O c??digo do parceiro n??o existe!", classes: 'rounded'});
                                    resposta = false;
                                }
                            }
                        })
                    }
                    if ($("#senha1").val() != $("#senha2").val()) {
                        resposta = false;
                        M.toast({html: "Senhas n??o coincidem!", classes: 'rounded'});
                    } else {
                        var dados = $('#formUsuario').serialize();
                        $.ajax({
                            url: '../Controle/usuarioControle.php?function=validatePassword',
                            type: 'POST',
                            data: dados,
                            async: false,
                            success: function (response) {
                                if (response == 'false') {
                                    $('#senha1').attr('class', 'invalid');
                                    $('#senha2').val('');
                                    M.toast({html: "A senha n??o cumpre com os requisitos", classes: 'rounded'});
                                    resposta = false;
                                }
                            }
                        });
                    }
                    return resposta;
                }
            });
        </script>
    </body>
</html>

