<?php
require_once "../vendor/autoload.php";

if (!isset($_SESSION)) {
    session_start();
}
include_once "../Base/requerGodMode.php";

use TCC\Controle\ChamadoPDO;
use TCC\Controle\UsuarioPDO;
use TCC\Modelo\Chamado;
use TCC\Modelo\Parametros;
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
$logado = $usuarioPDO->getLogado();
$chamados = $chamadoPDO->selectAtivos();

?>
<main>
    <div class="row containerListCuston">
        <div class="card col s12">
            <br>
            <div class="rowMeu">
                <a href="javascript:location.href = document.referrer;" class="btn corPadrao3 btnFooter">
                    <i class="material-icons left">keyboard_arrow_left</i>
                    Voltar
                </a>
            </div>
            <h4 class="textoCorPadrao2 center"><b>Seus chamados</b></h4>
            <div class="row center col s12">
                <ul class="collection" id="corpoCollapsible">
                    <?php
                    if ($chamados) {
                        while ($linha = $chamados->fetch()) {
                            $chamado = new Chamado($linha);
                            ?>
                            <li class="collection-item avatar" style="padding-left: 20px !important; min-height: 125px !important;">
                                <div class="divWraperDiferentinha col">
                                <p class="left-align card-title" style="margin-bottom: 2px; font-size: 20px">Tipo: <?php echo $chamado->getTipoText() ?></p>
                                <p class="left-align" style="line-height: 1; min-height: 16px; margin-left: 3px; max-height: 29px; overflow: hidden; text-overflow:ellipsis">Descrição: <?php echo $chamado->getDescricao() ?></p>
                                <p class="left-align" style="margin-left: 3px">Aberto em: <?php echo $chamado->getHoraFormated() ?></p>
                                <?php
                                if ($chamado->getStatus()==Chamado::ST_ABERTO) {
                                    ?>
                                    <span class="left new badge orange" style="margin-left: 1px" data-badge-caption="">Aberto</span>
                                    <?php
                                } else {
                                    ?>
                                    <span class="left new badge green" style="margin-left: 1px" data-badge-caption="">Fechado</span>
                                    <?php
                                }
                                ?>
                                </div>
                                <a href="./verChamado.php?id_chamado=<?php echo $chamado->getIdChamado() ?>"
                                   class="itemListUsuario primeiroItem"><i
                                        class="material-icons textoCorPadrao2">assignment</i></a>
                                <a href="#!" id_chamado="<?php echo $chamado->getIdChamado() ?>"
                                   class=" modal-trigger itemListUsuario deletaProduto segundoItem"><i
                                        class="material-icons red-text text-darken-2">clear</i></a>

                            </li>
                            <?php
                        }
                    } else { ?>
                        <div class="card-title center" style="padding: 8px 0">
                            Nenhum chamado cadastrado
                        </div>
                        <?php
                    }
                    ?>

                </ul>
            </div>
        </div>
</main>

<script>
    $('.modal').modal();
    $('select').formSelect();

</script>
<?php
include_once '../Base/footer.php';
?>

</body>
</html>

