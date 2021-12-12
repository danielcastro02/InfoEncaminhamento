<?php
if (!isset($_SESSION)) {
    session_start();
}
include_once '../Base/requerLogin.php';
?>
<div class="modal-content" style="padding-bottom: 0">
    <div>
        <h5 class="textoCorPadrao2 center">Cadastrar Aluno</h5>
        <div class="divider"></div>
        <form method="POST" id="formAluno">
            <div class="row">
                <div class="input-field col s12">
                    <input autocomplete="off" type="text" name="nome" required class="required" id="nome">
                    <label for="nome">Nome completo</label>
                </div>
                <div class="input-field col s12">
                    <input autocomplete="off" type="text" name="apelido" id="apelido">
                    <label for="apelido">Apelido</label>
                </div>
                <div class="col s12 no-padding">
                    <div class="input-field col s12">
                        <div class="chips chipsTurma chips-initial backgroundChipCLiFor"
                             style="position: relative; margin-top: 0; margin-bottom: 0;">
                        </div>
                        <input autocomplete="off" type="text" name="id_turma" hidden id="idTurma"/>
                        <label for="idTurma" id="labelTurma">Turma</label>
                    </div>
                </div>
                <div class="center divBtn">
                    <a href="#!" class="btn corPadrao3 btnFooter" id="voltarModalAluno">
                        <i class="material-icons left">keyboard_arrow_left</i>
                        Voltar
                    </a>
                    <button class="corPadrao2 btn btnFooter" type="submit">
                        <i class="material-icons right">done</i>
                        Salvar
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    $("#formAluno").submit(function (e) {
        e.preventDefault()
        initLoader()
        $.ajax({
            data : $("#formAluno").serialize(),
            url : "../Controle/alunoControle.php?function=insert",
            type : "post",
            success : function (response){
                if (Object.keys(response).length !== 0) {
                    console.warn(response)
                    addToast("Registro criado")
                    closeLoader()
                    $('#modalTurma').modal('close')
                    $('#idAluno').val(response.id)
                    const data = [
                        {
                            tag: response.nome
                        }
                    ]
                    att(data, '.chipsAluno')
                    $('#labelAluno').addClass('labelAtiva')
                    $('#modalRegistroAluno').modal('close')
                } else {
                    closeLoader()
                    addToast("Erro ao registrar.")
                }
            },
            error: function (request, status, error) {
                closeLoader()
                addToast("Erro ao registrar.")
                console.error(request.responseText, error);
            }
        })
    })

    $('#voltarModalAluno').click(function () {
        $("#modalRegistroAluno").modal('close');
    })

    $('#idTurma').click(function (){
        getTurmaOption()
    })

    $('.chipsTurma').click(function () {
        getTurmaOption()
    })

    $('#inputBuscaTurma').keyup(function () {
        getTurmaOption($('#inputBuscaTurma').val())
    })

    function getTurmaOption(busca = '') {
        $('#inputBuscaTurma').val()
        $('#loaderTurma').show()
        $('#labelTurma').removeClass('labelAtiva')
        $('#idTurma').val('')
        att([], '.chipsTurma')

        $.ajax({
            url: '../Controle/selectOptionControle.php?function=selectTurmaToModal',
            method: 'post',
            data: {
                busca: busca
            },
            success: function (response) {
                $('#loaderTurma').hide()
                if (response.length > 0) {
                    $('#resultTurma').html(collectionModal(response, 'clicarItemTurma'))
                    $('.clicarItemTurma').click(function () {
                        $('#idTurma').val($(this).attr('id'))
                        const data = [
                            {
                                tag: $(this).html()
                            }
                        ]
                        att(data, '.chipsTurma')
                        $('#labelTurma').addClass('labelAtiva')
                        $('#modalTurma').modal('close')
                    })
                } else {
                    $('#resultTurma').html('<div class="textoSemRetorno">Nenhum dado encontrado.</div>')
                }
            }
        })

        $('#modalTurma').modal('open')
    }
</script>
