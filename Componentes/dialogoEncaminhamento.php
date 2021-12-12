<?php
require_once "../vendor/autoload.php";
use TCC\Controle\RespostaPDO;
use TCC\Controle\UsuarioPDO;
use TCC\Modelo\Resposta;
use TCC\Modelo\Usuario;

$usuarioPDO = new UsuarioPDO();
$respostaPDO = new RespostaPDO();
$stmt = $respostaPDO->selectByIdEncaminhamento($_GET['id_encaminhamento']);
if ($stmt) {
    while ($linha = $stmt->fetch()) {
        $resposta = new Resposta($linha);
        $usuarioMensagem = $usuarioPDO->selectUsuarioId_usuario($resposta->getIdServidor());
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
                    <span class="right"><?php echo $resposta->getHoraFormated(); ?></span>
                </div>
                </p>
                <p><?php echo $resposta->getResposta(); ?></p>
            </div>
        </div>
        <div class="horizontal-divider"></div>
        <?php
    }
}
?>