<?php
require_once "../vendor/autoload.php";
use TCC\Modelo\Parametros;
use TCC\Modelo\Usuario;

include_once '../Base/requerLogin.php';

$logado = new Usuario(unserialize($_SESSION['logado']));
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="cache-control" content="no-cache"/>
    <?php
    include_once '../Base/header.php';

    $parametros = new Parametros();
    ?>
    <title><?php echo $parametros->getNome_empresa(); ?></title>

<body class="homeimg">
<?php
include_once '../Base/iNav.php';
?>
<main>

    <div class="row">
        <div class="col l8 m8 s12 offset-l2 offset-m2 card">
            <div class="row" style="margin-top: 2vh;">
                <div class="col l4 s12 right-divider">
                    <a href="#!" id="linkfoto" class="center" style="width: 100%">
                        <div style="margin: auto" class="circle ">
                            <img class=" prev-img fotoPerfil center" width="150" height="150"
                                 src="<?php echo $logado->getIs_foto_url() == 1 ? $logado->getFoto() : "../" . $logado->getFoto() ?>">
                        </div>
                        <div class="fotoPerfil" style="position: relative; margin-top: -155px; z-index: 2">
                            <div class="linkfoto white-text center">Adicionar Foto</div>
                        </div>


                    </a>

                    <div class="row center">
                        <div id="loader" class="fotoPerfilLoader preloader-wrapper big active center"
                             style="display: none;">
                            <div class="spinner-layer spinner-black-only center">
                                <div class="circle-clipper left">
                                    <div class="circle"></div>
                                </div>
                                <div class="gap-patch">
                                    <div class="circle"></div>
                                </div>
                                <div class="circle-clipper right">
                                    <div class="circle"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <form action="../Controle/usuarioControle.php?function=alteraFoto" method="post" id="formFoto"
                      enctype="multipart/form-data">
                    <div class="file-field input-fiel">
                        <div>
                            <input autocomplete="off" type="file" class="file-chos" name="imagem" id="btnFile"
                                   accept=".jpg,.jpeg,.bmp,.png,.jfif,.svg,.webp,.gif" hidden>
                        </div>
                        <div class="file-path-wrapper">
                            <input autocomplete="off" class="file-path validate" name="imagem" type="text"
                                   placeholder="Selecione a foto"
                                   required hidden>
                        </div>
                    </div>
                    <input autocomplete="off" type="text" hidden name="SendCadImg">
                </form>

                <div class="col l6 s12 offset-l1">
                    <div class="hide-on-large-only">
                        <br>

                        <div class="row center" style="max-width: 100%;">
                            <!--                            <div class="row">-->
                            <!--                                <a class="btn waves-effect  corPadrao2"-->
                            <!--                                   href="../Tela/meusAgendamentos.php">Meus horários</a>-->
                            <!--                            </div>-->
                            <!--                           -->
                            <!--                            --><?php //if (isset($_SESSION['prestador'])) { ?>
                            <!--                                <a class="btn waves-effect  corPadrao2"-->
                            <!--                                   href="../Tela/registrarAusencia.php?id_usuario=-->
                            <?php //echo $logado->getId_usuario(); ?><!--">Registar-->
                            <!--                                    minha ausência</a>-->
                            <!--                            --><?php //} ?>
                        </div>

                        <div class="col l4 s12 horizontal-divider"></div>
                        <br>
                    </div>
                    <h5 class="bottom-sheet"><?php echo $logado->getNome(); ?></h5>
                    <p>Telefone: <?php echo $logado->getTelefone() ?></p>
                    <p>Email: <?php echo $logado->getEmail() ?></p>
                    <p>Data de nascimento: <?php echo $logado->getData_nascBarras() ?></p>
                    <p>CPF: <?php echo substr($logado->getCpf(), 0, 3) ?>.***.***-**</p>
                    <div class="row">
                        <div class="col s12">
                            <div class="switch">
                                Receber e-mail gerais.
                                <label class="right">
                                    Off
                                    <input type="checkbox"
                                           id="receber_email" name="receber_email" <?php echo $logado->getReceberEmail() == 1 ? "checked" : "" ?>>
                                    <span class="lever"></span>
                                    On
                                </label>
                            </div>
                            <div class="switch">
                                Receber e-mails críticos
                                <label class="right">
                                    Off
                                    <input type="checkbox"
                                           id="receber_email_sistema" name="receber_email_sistema" <?php echo $logado->getReceberEmailSistema() == 1 ? "checked" : "" ?>>
                                    <span class="lever"></span>
                                    On
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="center">
                        <a class="btn waves-effect  corPadrao2 modal-trigger <?php
                        if (isset($_GET['pulseDados'])) {
                            echo 'pulse-button';
                        }
                        ?>" href="#completaCadastro" id="linkcompleta">Alterar dados</a>
                        <a class="btn waves-effect corPadrao2 modal-trigger" href="#completaCadastro" id="linkSenhas">
                            Alterar senha
                        </a>
                    </div>
                </div>
            </div>


        </div>
    </div>

    <!--Modal editar-->
    <div class="modal" id="completaCadastro">

    </div>

    <!--Modal editar-->

</main>

<script>
    $(document).ready(function () {
        var modal = $('#completaCadastro');
        $('.modal').modal();
        $("#linkcompleta").click(function () {
            modal.text("");
            modal.load("./editarDadosUsuario.php", function () {
                M.updateTextFields();
                $("#cpf").mask('000.000.000-00');
                $("#dataNasc").mask('00/00/0000');
                $("#telefone").mask('(00) 00000-0000');
                $('.tooltipped').tooltip();
                $("#email").keydown(function () {
                    $("#mostrar").show();
                });
                $('#formUpdateTudo').submit(function () {
                    var retorno = true;
                    if ($("#cpf").val().length < 14 && $("#cpf").val().length != 0) {
                        retorno = false;
                        M.toast({html: "CPF Inválido!", classes: 'rounded'});
                    }
                    if ($("#telefone").val().length < 15 && $("#telefone").val().length != 0) {
                        retorno = false;
                        M.toast({html: "Telefone inválido!", classes: 'rounded'});

                    }
                    if ($("#dataNasc").val().length < 10 && $("#dataNasc").val().length != 0) {
                        M.toast({html: "Data Inválida!", classes: 'rounded'});
                        retorno = false;
                    } else {
                        if (!verificaData($("#dataNasc"))) {
                            retorno = false;
                        }
                    }
                    return retorno;
                });
            });
            return true;
        });
        $("#linkSenhas").click(function () {
            modal.text("");
            modal.load("./editarSenhaUsuario.php", function () {
                $("#formTrocaSenha").submit(function () {
                    resposta = true;
                    if ($("#senha1").val() != $("#senha2").val()) {
                        M.toast({html: "Senhas não coincidem!", classes: 'rounded'});
                        resposta = false;
                    } else {
                        let dados = $('#formTrocaSenha').serialize()
                        $.ajax({
                            url: '../Controle/usuarioControle.php?function=validatePassword',
                            method: 'post',
                            data: dados,
                            async: false,
                            success: function (response) {
                                if (response == 'false') {
                                    $('#senha1').attr('class', 'invalid')
                                    $('#senha2').val('')
                                    M.toast({html: "A senha não cumpre com os requisitos", classes: 'rounded'})
                                    resposta = false
                                }
                            }
                        })
                    }
                    return resposta
                });
            });
            return true;
        });

        $("#linkfoto").click(function () {
            M.updateTextFields();
            $('#btnFile').click();
            carregarFoto();
        });

        function carregarFoto() {
            const s = document.querySelector.bind(document);
            const previewImg = s('.prev-img');
            const fileChooser = s('.file-chos');

            fileChooser.onchange = e => {
                const fileToUpload = e.target.files.item(0);
                const reader = new FileReader();
                reader.onload = e => previewImg.src = e.target.result;
                reader.readAsDataURL(fileToUpload);
                $('#linkfoto').hide();
                $('#loader').show();
                $("#formFoto").submit();
            };
        }


        <?php
        if (isset($_GET['msg'])) {
        if ($_GET['msg'] == "senhaAlterada") {
        ?>M.toast({html: 'Senha alterada!', classes: 'rounded'})<?php
        }
        }
        ?>
    })
    ;
    $("#receber_email").change(function (){
        if($(this).is(':checked')){
            $.ajax({
                url: "../Controle/usuarioControle.php?function=disableReceberEmail&alter=1",
                success: function (data) {
                    addToast("Configuração alterada!");
                }
            })
        }else {
            $.ajax({
                url: "../Controle/usuarioControle.php?function=disableReceberEmail&alter=0",
                success: function (data) {
                    addToast("Configuração alterada!");
                }
            })
        }
    });
    $("#receber_email_sistema").click(function (e){
        // e.preventDefault();
        if($(this).is(':checked')){
            $.ajax({
                url: "../Controle/usuarioControle.php?function=disableReceberEmailSistema&alter=1",
                success: function (data) {
                    addToast("Configuração alterada!");
                }
            })
            return true;
        }else {
            if (confirm("Se desabilitar este envio, não receberá avisos sobre desligamento ou demais avisos críticos sobre o sistema!")) {
                $.ajax({
                    url: "../Controle/usuarioControle.php?function=disableReceberEmailSistema&alter=0",
                    success: function (data) {
                        addToast("Configuração alterada!");
                    }
                })
                return true;
            } else {
                $(this).attr("checked", true);
                return false;
            }
        }
    });

</script>
<?php
include_once '../Base/footer.php';
?>
</body>
</html>

