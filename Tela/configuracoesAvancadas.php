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
                                    <h5>Identificação do seu negócio</h5>
                                    <p>Este é o nome que vai aparecer na tela inicial e na barra de navegação.</p>
                                    <div class="row">
                                        <div class="col s12 input-field">
                                            <input autocomplete="off" id="nome_empresa" type="text"
                                                   value="<?php echo $parametros->getNome_empresa(); ?>"
                                                   name="nome_empresa"/>
                                            <label for="nome_empresa">Nome do seu negócio</label>
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
                                        <input autocomplete="off" id="emailContato" type="email" required class="required"
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
                                        <input autocomplete="off" id="cidade" type="text" value="<?php echo $parametros->getCidade(); ?>"
                                               name="cidade"/>
                                        <label for="cidade">Cidade</label>
                                    </div>
                                    <div class="col s12  input-field">
                                        <input autocomplete="off" id="estado" type="text" value="<?php echo $parametros->getEstado(); ?>"
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
            </form>
            <div class="row">

                <div class="col s12 l4">
                    <div class="col s12 l10 offset-l1 card">
                        <h5>Configurações de Notificação</h5>
                        <form action="../Controle/parametrosControle.php?function=updateNotificacao" method="POST">
                            <div class="col s12 input-field">

                                <div class="switch">
                                    <span class="left teal-text">Envio de Notificações:</span>
                                    <label class="right">
                                        Off
                                        <input autocomplete="off" type="checkbox"
                                               name="envia_notificacao"
                                               value="1" <?php echo $parametros->getEnviarNotificacao() == 1 ? 'checked' : ''; ?>>
                                        <span class="lever"></span>
                                        On
                                    </label>
                                </div>

                            </div>
                            <div class="col s12 input-field">
                                <input autocomplete="off" name="app_token" value="<?php echo $parametros->getAppToken() ?>" type="password"
                                       id="appToken"/>
                                <label for="appToken">Token do aplicativo:</label>
                            </div>
                            <div class="row">
                                <button type="submit" class="btn waves-effect  corPadrao2">Confirmar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row">
                <form action="../Controle/parametrosControle.php?function=updateGeral" method="POST">
                    <div class="col s12 l4">
                        <div class="col s12 l10 offset-l1 card">
                            <h5>Configurações gerais</h5>
                            <div class="col s12 input-field">
                                <div class="switch">
                                    <span class="left teal-text">Envio de SMS:</span>
                                    <label class="right">
                                        Off
                                        <input autocomplete="off" type="checkbox"
                                               name="sms"
                                               value="1"<?php echo $parametros->getSms() == 1 ? 'checked' : ''; ?>>
                                        <span class="lever"></span>
                                        On
                                    </label>
                                </div>
                            </div>
                            <div class="col s12 input-field">
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
                                <h5>Firebase</h5>
                            </div>
                            <div class="row">
                                <div class="col s12 input-field">
                                    <input autocomplete="off" type="text" name="firebase_topic" id="firebase_topic"
                                           value="<?php echo $parametros->getFirebaseTopic() ?>">
                                    <label for="firebase_topic">Firebase Topic</label>
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
                <div class="col s12 l4">
                    <div class="col s12 l10 offset-l1 card">
                        <div class="row center">
                            <h5>Chat</h5>
                        </div>

                        <form action="../Controle/parametrosControle.php?function=updateChat" method="post">
                            <div class="row">
                                <div class="col s12 input-field">
                                    <div class="switch">
                                        <span class="left teal-text">Ativar chat:</span>
                                        <label class="right">
                                            Off
                                            <input autocomplete="off" type="checkbox"
                                                   name="active_chat" <?php echo $parametros->getActiveChat() == 1 ? 'checked' : ''; ?>
                                                   value="1">
                                            <span class="lever"></span>
                                            On
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <button class="btn corPadrao2" type="submit">Confirmar</button>
                            </div>
                        </form>
                        <form action="../Controle/parametrosControle.php?function=updateAutenticacao" method="post">
                            <div class="row">
                                <div class="col s12 input-field">
                                    <div class="switch">
                                        <span class="left teal-text">Metodo de autenticação:</span>
                                        <label class="right">
                                            Telefone
                                            <input autocomplete="off" type="checkbox"
                                                   name="metodo_autenticacao" <?php echo $parametros->getMetodoAutenticacao() == 1 ? 'checked' : ''; ?>
                                                   value="1">
                                            <span class="lever"></span>
                                            E-mail
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <button class="btn corPadrao2" type="submit">Confirmar</button>
                            </div>
                        </form>


                    </div>
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