<?php
require_once "../vendor/autoload.php";

include_once '../Base/requerAdm.php';

use TCC\Modelo\Parametros;

$parametros = new Parametros();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php
    include_once '../Base/header.php';
    ?>
    <title><?php echo $parametros->getNome_empresa(); ?></title>

</head>
<body>
<?php
include_once '../Base/iNav.php';
?>
<main>
    <div class="row">
        <div class="col s12 container center">
            <form action="../Controle/parametrosControle.php?function=update" method="POST">

                <div class="row">
                    <div class="col s12 container center">
                        <div class="row">
                            <h5>Configurações do Site</h5>
                            <div class="col s12 l4">
                                <div class="col s12 l10 offset-l1 card">
                                    <h5>Nome do projeto</h5>
                                    <div class="row">
                                        <div class="col s12 input-field">
                                            <input autocomplete="off" id="nome_empresa" type="text"
                                                   value="<?php echo $parametros->getNome_empresa(); ?>"
                                                   name="nome_empresa"/>
                                        </div>
                                        <div class="col s12">
                                            <?php
                                            if ($parametros->getIs_foto() == 1) {
                                                ?>
                                                <a class="btn waves-effect  corPadrao2" id="removeLogo"
                                                   href="../Controle/parametrosControle.php?function=removeLogo">Remover
                                                    logo</a>
                                                <?php
                                            } else {
                                                ?>
                                                <a class="btn waves-effect  corPadrao2" href="./definirLogomarca.php">Definir
                                                    uma logo</a>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col s12 l4 ">
                                <div class="col s12 l10 offset-l1 card">
                                    <h5>Seu contato</h5>
                                    <div class="col s12  input-field">
                                        <input autocomplete="off" id="emailContato" type="email" required
                                               class="required"
                                               value="<?php echo $parametros->getEmailContato(); ?>"
                                               name="emailContato"/>
                                        <label for="emailContato">E-mail de contato</label>
                                    </div>
                                    <div class="col s12  input-field">
                                        <input autocomplete="off" id="telefones" type="text"
                                               value="<?php echo $parametros->getTelefones(); ?>" name="telefones"/>
                                        <label for="telefones">Telefones de contato</label>
                                    </div>
                                    <br>
                                </div>
                            </div>
                            <div class="col s12 l4">
                                <div class="col s12 l10 offset-l1 card">
                                    <h5>Onde você está?</h5>
                                    <div class="col s12  input-field">
                                        <input autocomplete="off" id="ruaNumero" type="text"
                                               value="<?php echo $parametros->getRuaNumero(); ?>" name="ruaNumero"/>
                                        <label for="telefones">Rua e Número</label>
                                    </div>
                                    <div class="col s12  input-field">
                                        <input autocomplete="off" id="cidade" type="text"
                                               value="<?php echo $parametros->getCidade(); ?>"
                                               name="cidade"/>
                                        <label for="cidade">Cidade</label>
                                    </div>
                                    <div class="col s12  input-field">
                                        <input autocomplete="off" id="estado" type="text"
                                               value="<?php echo $parametros->getEstado(); ?>"
                                               name="estado"/>
                                        <label for="estado">Estado (Pode ser Sigla)</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row center">
                            <a class="btn waves-effect  corPadrao3" href='../index.php'>Cancelar</a>
                            <button type="submit" class="btn waves-effect corPadrao2 ">Confirmar</button>
                        </div>
                    </div>
                </div>
            </form>
            <div class="row">
                <form action="../Controle/parametrosControle.php?function=updateEmail" method="POST">
                    <div class="col s12 l8">
                        <div class="col s12 l10 offset-l1 card">
                            <h5>Configurações E-mail</h5>
                            <div class="col s6 input-field">
                                <div class="switch">
                                    <span class="left teal-text">Confirmação de E-mail:</span>
                                    <label class="right">
                                        Off
                                        <input autocomplete="off" type="checkbox"
                                               name="confirma_email"
                                               value="1"<?php echo $parametros->getConfirmaEmail() == 1 ? 'checked' : ''; ?>>
                                        <span class="lever"></span>
                                        On
                                    </label>
                                </div>
                            </div>

                            <div class="col s6  input-field">
                                <input autocomplete="off" id="estado" type="text"
                                       value="<?php echo $parametros->getSmtpServer(); ?>"
                                       name="smtp_server"/>
                                <label for="estado">Servidor SMTP</label>
                            </div>
                            <div class="col s6  input-field">
                                <input autocomplete="off" id="estado" type="text"
                                       value="<?php echo $parametros->getSmtpUser(); ?>"
                                       name="smtp_user"/>
                                <label for="estado">Usuário SMTP</label>
                            </div>
                            <div class="col s6  input-field">
                                <input autocomplete="off" id="estado" type="text"
                                       value="<?php echo $parametros->getSmtpPassword(); ?>"
                                       name="smtp_password"/>
                                <label for="estado">Senha SMTP</label>
                            </div>
                            <div class="col s6  input-field">
                                <input autocomplete="off" id="estado" type="text"
                                       value="<?php echo $parametros->getSmtpCrypt(); ?>"
                                       name="smtp_crypt"/>
                                <label for="estado">Criptografia SMTP</label>
                            </div>
                            <div class="col s6  input-field">
                                <input autocomplete="off" id="estado" type="text"
                                       value="<?php echo $parametros->getSmtpPorta(); ?>"
                                       name="smtp_porta"/>
                                <label for="estado">Porta SMTP</label>
                            </div>
                            <div class="col s6  input-field">
                                <input autocomplete="off" id="estado" type="text"
                                       value="<?php echo $parametros->getSmtpRemetente(); ?>"
                                       name="smtp_remetente"/>
                                <label for="estado">Email remetente</label>
                            </div>


                            <div class="row">
                                <button type="submit" class="btn waves-effect white-text corPadrao2">Confirmar</button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="col s12 l4">
                    <form action="../Controle/parametrosControle.php?function=update" method="post">
                        <div class="col s12 l10 offset-l1 card">
                            <div class="row center">
                                <h5>Banco de dados</h5>
                            </div>
                            <div class="row">
                                <div class="col s12 input-field">
                                    <input autocomplete="off" type="text" name="firebase_topic" id="firebase_topic"
                                           value="<?php echo $parametros->getFirebaseTopic() ?>" hidden>
                                </div>
                                <div class="col s12 input-field">
                                    <input autocomplete="off" type="text" name="nome_db" id="nome_db"
                                           value="<?php echo $parametros->getNomeDb() ?>">
                                    <label for="nome_db">Nome DB</label>
                                </div>
                            </div>
                            <div class="row">
                                <button class="btn corPadrao2">Confirmar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</main>
<script>
    $("#removeLogo").click(function () {
        return confirm("Tem certeza que deseja remover sua logo?");
    });
    $("#removeDestaque").click(function () {
        return confirm("Tem certeza que deseja remover Imagem de destaque da tela inicial?");
    });
    $("select").formSelect();
    $("#botaodocapeta").click(function () {
        if (confirm("Isso vai recupar os parametros do banco e pode dar muito problema, você realmente quer fazer isso?")) {
            if (confirm("Tem certeza?????")) {
                if (confirm("Absoluta???")) {
                    if (confirm("LUUUCAAAS?????????")) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    return false
                }
            } else {
                return false;
            }
        } else {
            return false
        }
    });
</script>
<?php
include_once '../Base/footer.php';
?>
</body>
</html>