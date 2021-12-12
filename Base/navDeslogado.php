<?php
$pontos = "";
if (realpath("./index.php")) {
    $pontos = './';
} else {
    if (realpath("../index.php")) {
        $pontos = '../';
    } else {
        if (realpath("../../index.php")) {
            $pontos = '../../';
        }
    }
}

use TCC\Modelo\Parametros;

$parametros = new Parametros();
$url = $_SERVER['REQUEST_URI'];

require_once $pontos . 'vendor/autoload.php'; // change path as needed
?>
<style>

    .chipNav {
        background-color: transparent !important;
    }

    nav {
        background: linear-gradient(to right , white ,#0F8F00, #0F8F00);
        height: 64px !important;
    }

    @media only screen and (max-width: 600px) {
        nav {
            height: 45px !important;
        }
    }

    nav ul a:hover {
        color: white !important;
    }

</style>
<nav class="nav-extended" style="position: relative;">
    <div class="nav-wrapper " style="margin-left: auto; margin-right: auto; width: 95%; overflow: hidden">
        <a href="<?= $pontos ?>Tela/login.php" class="left hide-on-small-and-down valign-wrapper"
           style="max-height: 60px;">
            <img class="" src="<?php echo $pontos ?>Img/logoIffar.png"
                 style="width: auto; height: 55px; margin-top: 5px;">
        </a>
        <a href="<?= $pontos ?>Tela/login.php" class="left hide-on-med-and-up valign-wrapper"
           style="max-height: 45px;">
            <img class="iconAlvoDeslogado" src="<?php echo $pontos ?>Img/logoIffar.png"
                 style="width: 195px; height: 206px;">
        </a>
        <ul class="right">
            <li>
                <a class="modal-trigger chipNav" href="#modalLogin">
                    Entrar
                </a>
            </li>
            <li>
                <a class="modal-trigger hide-on-small-and-down chipNav" href="#modalRegistro" id="registro">
                    Cadastre-se
                </a>
            </li>

        </ul>
    </div>
</nav>

<div id="modalRegistro" class="modal">
    <div class="modal-content">
        <h4>Registre-se</h4>
        <div class="row" style="margin-bottom: 0">
            <form action="<?php echo $pontos; ?>Controle/usuarioControle.php?function=inserirUsuario" id="formModal"
                  method="post">
                <div class="row center">
                    <div class="input-field col s12 l6">
                        <input id="Nome" type="text" name="nome" required class="required">
                        <label for="Nome">Nome</label>
                    </div>
                    <div class="input-field col s12 l6">
                        <input type="text" name="telefone" required class="required" id="telefoneModal">
                        <label for="telefone">Telefone</label>
                    </div>
                    <div class="input-field col s12 l12">
                        <input type="email" name="email" required class="required" id="email">
                        <label for="email">E-mail</label>
                    </div>
                    <div class="input-field col s12 l6">
                        <input type="password" name="senha1" id="senha1Mod" required class="required tooltipped"
                               data-position="top" data-tooltip="Deve conter 8 caracteres e 1 número">
                        <label for="senha1Mod">Senha</label>
                    </div>
                    <div class="input-field col s12 l6">
                        <input type="password" name="senha2" id="senha2Mod" required class="required">
                        <label for="senha2Mod">Repita a senha</label>
                    </div>
                </div>

                <div class="modal-footer" style="padding: 0 !important;">
                    <div class="row center" style="margin-bottom: 0">
                        <a href="#!"
                           class="modal-close waves-effect waves-green btn waves-effect corPadrao3 white-text btnFooter">Cancelar</a>
                        <button type="submit"
                                class="waves-effect waves-green btn waves-effect corPadrao2 white-text btnFooter">
                            Registrar
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
<div id="modalLogin" class="modal transparent z-depth-0">
    <div class="row">
        <div class="col  m8 s12 offset-m2 card">
            <div class="modal-content" style="max-height: 100%; overflow: auto;">
                <h4>Identifique-se</h4>
                <div class="row">
                    <form action="<?php echo $pontos; ?>Controle/usuarioControle.php?function=login" method="post">
                        <div class="row center">
                            <div class="input-field col s12">
                                <?php
                                echo "<input type='text' name='url' value='.." . $url . "' hidden='true'/>";
                                ?>
                                <input id="Usuario" type="text" name="usuario" required="true">
                                <label for="Usuario">Celular ou e-mail</label>
                            </div>

                            <div class="input-field col s12">
                                <span>
                                     <i id="toggle-password" class="material-icons right iconeOlho">visibility</i>
                                </span>
                                <input id="Senha" type="password" name="senha">
                                <label for="Senha">Senha</label>
                            </div>
                        </div>
                        <div class="row center">
                            <a href="#!"
                               class="modal-close waves-effect waves-green btn waves-effect -flat corPadrao3 white-text btnFooter">Cancelar</a>
                            <button type="submit"
                                    class="waves-effect waves-green btn waves-effect -flat corPadrao2 white-text btnFooter">
                                Entrar
                            </button>
                        </div>
                        <div class="row center">
                            <a class="teal-text"
                               href="<?php echo $pontos ?>Tela/recuperaSenha.php">Esqueci minha senha!</a>
                            <br>
                            Ainda não está cadastrado?
                            <a class="teal-text modal-trigger" href="#modalRegistro">Cadastre-se</a>
                        </div>
                        <?php
                        if (isset($_GET['msg'])) {
                            if ($_GET['msg'] == "senhaerrada") {
                                echo "<script>M.toast({html: 'Você errou alguma coisa!<br> Ainda não é cadastrado? <a class='teal-text modal-trigger' href='#modalRegistro'>Cadastre-se</a>', classes: 'rounded'});</script>";
                            }
                        }
                        ?>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    $('.tooltipped').tooltip();
    // codigo para o olhinho
    $("#toggle-password").mousedown(function () {
        var tipoType = $("#Senha").attr("type");
        if (tipoType === "password") {
            $("#Senha").prop("type", "text");
            $(this).html("visibility_off");
        } else {
            $("#Senha").prop("type", "password");
            $(this).html("visibility");
        }
    });

    $('.dropdown-trigger').dropdown({
        coverTrigger: false
    });
    $('.modal').modal();
    $("#telefoneModal").mask("(00) 00000-0000");
    $("#telefone").mask("(00) 00000-0000");


    $("#formModal").submit(function () {
        if ($("#telefoneModal").val().length != 15) {
            M.toast({html: 'Digite um número de celular válido!', classes: 'rounded'})
            return false;
        } else {
            var dados = $(this).serialize();
            var resposta = true;
            $.ajax({
                url: '<?php echo $pontos; ?>Controle/usuarioControle.php?function=verificaTelefone',
                type: 'POST',
                data: dados,
                async: false,
                success: function (data) {
                    if (data == 'true') {
                        resposta = false;
                        $('#telefoneModal').attr('class', 'invalid');
                        M.toast({html: "O telefone já existe no sistema!", classes: 'rounded'});
                    } else {
                        $('#telefoneModal').attr('class', 'valid');
                    }
                }
            });
            $.ajax({
                url: '<?php echo $pontos; ?>Controle/usuarioControle.php?function=verificaEmailProfessor',
                type: 'POST',
                data: dados,
                async: false,
                success: function (data) {
                    if (data == 'true') {
                        resposta = false;
                        $('#email').attr('class', 'invalid');
                        M.toast({html: "Apenas professores do IFFar podem se cadastrar", classes: 'rounded'});
                    } else {
                        $('#telefoneModal').attr('class', 'valid');
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
                            M.toast({html: "O código do parceiro não existe!", classes: 'rounded'});
                            resposta = false;
                        }
                    }
                })
            }
            if ($("#senha1Mod").val() != $("#senha2Mod").val()) {
                resposta = false;
                M.toast({html: "Senhas não coincidem!", classes: 'rounded'});
            } else {
                console.log('1')
                var dados = $('#formModal').serialize();
                $.ajax({
                    url: '<?php echo $pontos; ?>Controle/usuarioControle.php?function=validatePassword',
                    type: 'POST',
                    data: dados,
                    async: false,
                    success: function (response) {
                        if (response == 'false') {
                            $('#senha1Mod').attr('class', 'invalid');
                            $('#senha2Mod').val('');
                            M.toast({html: "A senha não cumpre com os requisitos", classes: 'rounded'});
                            resposta = false;
                        }
                    }
                });
            }
            if (resposta) {
                $("#preLoader").show();
                gtag('event', 'conversion', {'send_to': 'AW-779227084/htJaCM-Hqf4BEMyfyPMC'});
            }

            return resposta;
        }
    });
    <?php
    if(isset($_GET['openRegistro'])){
    ?>
    $(document).ready(function () {
        $('#modalRegistro').modal('open');
    });
    <?php
    }
    ?>
</script>