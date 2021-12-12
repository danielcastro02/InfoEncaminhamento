<?php
require_once "../vendor/autoload.php";

include_once "../Base/requerAdm.php";
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

    use TCC\Controle\UsuarioPDO;
    use TCC\Modelo\Encaminhamento;
    use TCC\Modelo\Parametros;
    use TCC\Modelo\Usuario;

    $parametros = new Parametros();

    ?>
    <title><?php echo $parametros->getNome_empresa(); ?></title>
<body class="homeimg">
<?php
include_once '../Base/iNav.php';
?>
<main>

    <?php
    $usuarioPDO = new UsuarioPDO();
    $usuario = $usuarioPDO->selectUsuarioId_usuario($_GET['id_usuario']);
    $usuario = new Usuario($usuario->fetch());
    ?>
    <div class="row">
        <div class="col s12 m10 l10 offset-l1 offset-m1 card">
            <div class="row">
                <div class="col s12 m3 l3">
                    <div style="margin: auto;margin-top: 20px;" class="circle">
                        <img class=" prev-img fotoPerfil center" width="150" height="150"
                             src="<?php echo $usuario->getIs_foto_url() == 1 ? $usuario->getFoto() : "../" . $usuario->getFoto() ?>">
                    </div>
                </div>
                <div class="col s12 m9 l9">
                    <h4><?php echo $usuario->getNome() ?></h4>
                    <p>Telefone: <?php echo $usuario->getTelefone() ?></p>
                    <p>Email: <?php echo $usuario->getEmail() ?></p>
                    <p>Data de nascimento: <?php echo $usuario->getData_nascBarras() ?></p>
                    <p>CPF: <?php echo $usuario->getCpf(); ?></p>
                </div>
            </div>
            <div class="row center">
                <div class="col s12">
                    <div class="row center">
                        <div class="col s6">
                        <?php
                        if ($usuario->getAdministrador() > 1) {
                            ?>
                            <a href="../Controle/usuarioControle.php?function=removeAdm&id=<?php echo $usuario->getId_usuario() ?>"
                               class="btn corPadrao3">Remover Administrador</a>
                            <?php
                        } else {
                            ?>
                            <a href="../Controle/usuarioControle.php?function=tornarAdm<?php echo $usuario->getId_usuario() ?>"
                               class="btn corPadrao3">Tornar Administrador</a>
                            <?php
                        }
                        ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s6">
                            <select name="setor" id="setor">
                                <option value="<?= Encaminhamento::SET_CAE ?>" <?= $usuario->getSetor() == Encaminhamento::SET_CAE ? "selected" : "" ?>>CAE</option>
                                <option value="<?= Encaminhamento::SET_PEDAGOGICO ?>" <?= $usuario->getSetor() == Encaminhamento::SET_PEDAGOGICO ? "selected" : "" ?>>PEDAGOGICO</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row center">
                <a href="./listagemUsuario.php" class="btn corPadrao3">Voltar</a>
            </div>
        </div>
    </div>
</main>
<?php
include_once '../Base/footer.php';
?>
</body>
</html>
<script>
    // Script para fazer o toggle do descrição

    $("#setor").change(function () {
        $.ajax({
            url: "../Controle/usuarioControle.php?function=updateSetor",
            type: "post",
            data: {
                setor: $("#setor").val(),
                id_usuario: "<?= $usuario->getId_usuario()?>"
            },
            success: function (data) {
                addToast("Ta mudado!")
            }
        })
    });

    $('.abrirDescricao').click(function () {
        var x = $(this).attr('x');
        $('.infoPrincipal').each(function () {
            if (x == $(this).attr('x')) {
                $(this).slideToggle();
            }
        });
        $('.maisDetalhes').each(function () {
            if (x == $(this).attr('x')) {
                $(this).slideToggle();
            }
        });
    });
</script>

