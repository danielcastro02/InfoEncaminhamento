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
if (isset($_SESSION)) {
    ?>

    <div id="modalSugestao" class="modal">
        <div class="modal-content">
            <h4>Chamado de Suporte</h4>
            <form method="post" action="#!" id="formSugetao">
                <div class="row">
                    <input autocomplete="off" type="text" hidden name="tela" value="<?php echo $_SERVER['REQUEST_URI'] ?>">
                    <div class="col s12 input-field">
                        <select name="tipo" id="tipo" required class="required">
                            <option value="0" disabled selected>Selecione uma opção</option>
                            <option value="2">Suporte Técnico</option>
                            <option value="3">Dúvidas gerais</option>
                            <option value="4">Fazer uma sugestão</option>
                        </select>
                        <label for="tipo">Tipo</label>
                    </div>
                    <div class="col s12 input-field">
                        <textarea name="descricao" id="descricaoModal" class="materialize-textarea required" required ></textarea>
                        <label for="descricaoModal">Descreva seu problema</label>
                    </div>
                    <div class="col s12">
                        <p>*Quando respondermos você receberá um e-mail, independente das suas configurações.</p>
                    </div>
                </div>
            </form>
        </div>

        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-red btn red">Cancelar</a>
            <a href="#!" id="linkFormSugestao" class="waves-effect waves-orange btn corPadrao2">Enviar</a>
        </div>
    </div>

    <div id="modalSucesso" class="modal">
        <div class="modal-content">
            <h4>Chamado aberto</h4>
            <p>Acesse "Meus chamados" no menu para acompanhar seus chamados ou adicionar mais informações.</p>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-green btn-flat">Ok</a>
        </div>
    </div>

    <script>
            $('.modal').modal();
            $("#btnReporte").click(function (){
               $("#modalSugestao").modal('open');
            });
        $("#linkFormSugestao").click(function () {
            if($('#descricaoModal').val() == '' || $('#tipo').val() == null){
                M.toast({html: "Por favor preencha todos os campos selecionaveis!", classes: 'rounded'});
            } else {
                var dados = $("#formSugetao").serialize();
                initLoader();
                $.ajax({
                    url: "<?php echo $pontos ?>Controle/chamadoControle.php?function=registroChamado",
                    data: dados,
                    type: 'post',
                    success: function (data) {
                        closeLoader();
                        if (data == 'true') {
                            $('#modalSugestao').modal('close');
                            $("#modalSucesso").modal("open");
                            $("#descricaoModal").val("");
                            $("#descricaoModal").html("");
                        }
                    }
                });
            }

        });

        $("select").formSelect();

    </script>
    <?php
}
?>