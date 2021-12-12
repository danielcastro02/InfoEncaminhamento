<?php
require_once "../vendor/autoload.php";
if (!isset($_SESSION)) {
    session_start();
}
include_once "../Base/requerLogin.php";

use TCC\Controle\ChamadoPDO;
use TCC\Controle\EntidadePDO;
use TCC\Controle\MensagemPDO;
use TCC\Controle\UsuarioPDO;
use TCC\Modelo\Chamado;
use TCC\Modelo\Entidade;
use TCC\Modelo\Mensagem;
use TCC\Modelo\Parametros;
use TCC\Modelo\Usuario;

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <?php
    include_once '../Base/header.php';
    $parametros = new Parametros();
    ?>
    <title><?php echo $parametros->getNome_empresa(); ?></title>
<body class="homeimg">
<?php
include_once '../Base/iNav.php';
$usuarioPDO = new UsuarioPDO();
$chamadoPDO = new ChamadoPDO();
$entidadePDO = new EntidadePDO();
$logado = $usuarioPDO->getLogado();
$chamados = $chamadoPDO->selectByIdChamado($_GET['id_chamado']);
$chamado = new Chamado($chamados->fetch());
$usuario = $usuarioPDO->selectUsuarioId_usuario($chamado->getIdUsuario());
$usuario = new Usuario($usuario->fetch());
$responsavel = $usuarioPDO->selectUsuarioId_usuario($chamado->getIdResponsavel());
if($responsavel){
    $responsavel = new Usuario($responsavel->fetch());
}else{
    $responsavel = new Usuario();
}
$entidade = $entidadePDO->selectIdEntidade($chamado->getIdEntidade());
if($entidade){
    $entidade = new Entidade($entidade->fetch());
}

?>
<main>

    <div class="row">
        <div class="col s12 offset-m1 m10 card">
            <div class="center">
                <?php if ($responsavel->getAdministrador() == 2) { ?>
                    <a class="btn corPadrao3" style="position: absolute;left: .75rem;"  href="../Tela/chamadosAtivos.php" >
                        <i class="material-icons white-text">keyboard_arrow_left</i>
                    </a>
                <?php
                }?>

                <h5>Chamado de: <?php echo $chamado->getTipoText() ?></h5>
            </div>
            <div class="row left-align">
                <div class="col s12">
                    <p>Descrição: <?php echo $chamado->getDescricao() ?></p>
                    <p>Aberto em: <?php echo $chamado->getHoraFormated() ?></p>
                    <?php if ($logado->getAdministrador() == 2) { ?>
                        <p>Tela: <?php echo $chamado->getTela() ?></p>
                        <p>Entidade: <?php echo $entidade?$entidade->getNome():"Não especificado" ?></p>
                        <p>Usuário: <?php echo $usuario->getNome(); ?></p>
                        <p>Email: <?php echo $usuario->getEmail(); ?></p>
                        <p>Telefone: <?php echo $usuario->getTelefoneMascarado(); ?></p>
                        <a href="detalhesUsuario.php?id_usuario=<?php echo $usuario->getId_usuario() ?>"
                           class="btn corPadrao2">Perfil</a>
                    <?php } ?>
                    <?php if ($chamado->getStatus() == Chamado::ST_ABERTO) { ?>
                        <a href="../Controle/chamadoControle.php?function=fechaChamado&id_chamado=<?php echo $chamado->getIdChamado() ?>" class="btn corPadrao2">Fechar
                            Chamado</a>
                    <?php } else { ?>
                        <a href="../Controle/chamadoControle.php?function=abreChamado&id_chamado=<?php echo $chamado->getIdChamado() ?>" class="btn corPadrao2">Reabrir
                            Chamado</a>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <div class="row horizontal-divider"></div>
            <div class="row" style="margin-bottom: 0">
                <div class="center"><h5>Mensagens</h5></div>
                <div class="col s12" style="overflow-y: scroll; max-height: 300px;">
                    <?php
                    $mensagemPDO = new MensagemPDO();
                    $stmt = $mensagemPDO->selectMensagemIdChamado($chamado->getIdChamado());
                    if ($stmt) {
                        while ($linha = $stmt->fetch()) {
                            $mensagem = new Mensagem($linha);
                            $usuarioMensagem = $usuarioPDO->selectUsuarioId_usuario($mensagem->getIdUsuario());
                            $usuarioMensagem = new Usuario($usuarioMensagem->fetch());
                            ?>
                            <div class="row">
                                <div class="col s12">
                                    <p class="card-title" style="font-size: 20px">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <div style="display: flex; align-items: center;">
                                            <div class="diviComFotoPerfil" style="background-image: url('<?php echo($usuarioMensagem->getIs_foto_url() == 1 ? $usuarioMensagem->getFoto() : '../' . $usuarioMensagem->getFoto()); ?>');
                                                    width: 30px;
                                                    height: 30px;
                                                    position: relative">
                                            </div>
                                            <span style="margin-left: 8px;;"><?php echo $usuarioMensagem->getNome(); ?></span>
                                        </div>
                                        <span class="right"><?php echo $mensagem->getHoraFormated(); ?></span>
                                    </div>
                                    </p>
                                    <p><?php echo $mensagem->getMensagem(); ?></p>
                                </div>
                            </div>
                            <div class="horizontal-divider"></div>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="divider" tabindex="-1"></div>
            <div class="row">
                <form class="col s12" method="post" action="../Controle/mensagemControle.php?function=inserirMensagem">
                    <div class="row">
                        <div class="col s10 m11 l11 input-field">
                            <input autocomplete="off" hidden name="id_chamado" value="<?php echo $chamado->getIdChamado() ?>">
                            <textarea class="materialize-textarea" name="mensagem" id="mensagem"></textarea>
                            <label for="mensagem">Mensagem</label>
                        </div>
                        <div class="input-field" style="position: absolute; right: .75rem">
                            <button type="submit" class="btn corPadrao2 <?= $chamado->getStatus() == Chamado::ST_FECHADO ? 'disabled' : '' ?>">
                                <i class="material-icons">send</i>
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>

</main>

<script>
</script>
<?php
include_once '../Base/footer.php';
?>

</body>
</html>

