<?php
require_once "../vendor/autoload.php";

use TCC\Controle\UsuarioPDO;
use TCC\Modelo\Usuario;

$usuarioPDO = new UsuarioPDO();
$stmt = $usuarioPDO->pesquisaListagem($_GET['pesquisa']);

if ($stmt) {
    while ($linha = $stmt->fetch()) {
        $usuario = new Usuario($linha);
        if ($usuario->getDeletado() != 1) {
            ?>
            <tr>
                <td class="center" data-title="Nome"><?php echo $usuario->getNome() ?></td>
                <td class="center cpf" data-title="CPF"><?php echo $usuario->getCpf(); ?></td>
                <td class="center" data-title="Email"><?php echo $usuario->getEmail() ?></td>
                <td class="center telefone" data-title="Telefone"><?php echo $usuario->getTelefone() ?></td>
                <td class="center">
                    <a class='btn waves-effect  corPadrao2' href='../Tela/detalhesUsuario.php?id_usuario=<?php echo $usuario->getId_usuario() ?>'>Ver Perfil</a>
                </td>
                <td class="center" data-title="Excluir">
                    <a class="btn waves-effect  red darken-2" href="#!" onclick="excluir('<?= $usuario->getId_usuario() ?>')"><i class="material-icons">delete</i></a>
                </td>
            </tr>
            
            
            <?php
        }
    }
}
?>