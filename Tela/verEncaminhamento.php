<?php
if(!isset($_SESSION)){
    session_start();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <?php
    include_once '../Base/header.php';

    use TCC\Controle\EncaminhamentoPDO;
    use TCC\Modelo\Encaminhamento;
    use TCC\Modelo\Parametros;

    $parametros = new Parametros();
    ?>
    <title><?php echo $parametros->getNome_empresa(); ?></title>
<body class="homeimg">
<style>
    p{
        padding: 3px;
        margin: 1px;
    }
</style>
<?php
include_once '../Base/iNav.php';
$encaminhamentoPDO = new EncaminhamentoPDO();
$encaminhamento = $encaminhamentoPDO->selectObjectByIdEncaminhamento($_GET['id_encaminhamento']);

?>
<main>
    <div class="row">
        <div class="col s10 offset-l1 card">
            <div class="row">
                <h5 class="center"><?php echo $encaminhamento->getSetor()==Encaminhamento::SET_CAE?"Encaminhamento Disciplinar":"Encaminhamento Pedagógico"; ?></h5>
                <div class="col s6">
                    <p>Aluno: <?= $encaminhamento->getAluno()->getNome() ?></p>
                    <p>Apelido: <?= $encaminhamento->getAluno()->getApelido() ?></p>
                    <p>Turma: <?= $encaminhamento->getAluno()->getTurma()->getTexto() ?></p>
                </div>
                <div class="col s6">
                    <p>Motivo do Encaminhamento: <?= $encaminhamento->getMotivo()->getTexto() ?></p>
                    <p>Medida tomada: <?= $encaminhamento->getRecurso()->getTexto() ?></p>
                    <p>Sugestão para resolução: <?= $encaminhamento->getSugestao()->getTexto() ?></p>
                </div>
                <div class="col s10">
                    <p class="bold">Relato:</p>
                    <p><?= $encaminhamento->getRelato() ?></p>
                </div>
                <div class="col s2 input-field">
                    <select id="selectStatus">
                        <option value="<?= Encaminhamento::STT_ABERTO ?>" <?= $encaminhamento->getStatus() == Encaminhamento::STT_ABERTO?'selected':'' ?>>Aberto</option>
                        <option value="<?= Encaminhamento::STT_ATENDENDO ?>" <?= $encaminhamento->getStatus() == Encaminhamento::STT_ATENDENDO?'selected':'' ?>>Em atendimento</option>
                        <option value="<?= Encaminhamento::STT_RESOLVIDO ?>" <?= $encaminhamento->getStatus() == Encaminhamento::STT_RESOLVIDO?'selected':'' ?>>Resolvido</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <h5 class="center">Diálogo</h5>
                <div class="col s12 grey lighten-5" style="overflow-y: scroll; max-height: 300px;" id="dislogoBox">

                </div>
                <div class="col s12 input-field">
                    <textarea name="resposta" id="resposta" class="materialize-textarea"></textarea>
                    <label for="resposta">Escrever mensagem</label>
                    <a href="#!" id="sendResposta" class="btn corPadrao2 right">Enviar</a>
                </div>
            </div>
        </div>
    </div>
</main>
<?php
include_once '../Base/footer.php';
?>

<script>
    $("#telefone").mask("(00) 00000-0000");

    $("#selectStatus").change(function (){
        $.ajax({
            url: "../Controle/encaminhamentoControle.php?function=updateStatus",
            data:
                {
                    id_encaminhamento: "<?= $_GET['id_encaminhamento'] ?>",
                    status: $("#selectStatus").val()
                },
            type : 'post',
            success: function(data){
                addToast("Status atualizado!");
            }
        });
    });

    $("#sendResposta").click(function (){
        $.ajax({
            type: 'post',
            url : "../Controle/respostaControle.php?function=inserir",
            data:{
                id_encaminhamento: "<?= $_GET['id_encaminhamento'] ?>",
                resposta: $("#resposta").val()
            },
            success : function (data){
                console.log(data);
                atualizaDialogo();
                $("#resposta").val("")
                M.updateTextFields();
            }
        })
    })
    function atualizaDialogo(rolar = true){
        $("#dislogoBox").load("../Componentes/dialogoEncaminhamento.php?id_encaminhamento=<?= $_GET['id_encaminhamento'] ?>" , function(){
            if(rolar) {
                var div = $('#dislogoBox');
                div.prop("scrollTop", div.prop("scrollHeight"));
            }
        })
    }
    atualizaDialogo();
    setInterval(function (){atualizaDialogo(false)} , 5000);

</script>
</body>
</html>
