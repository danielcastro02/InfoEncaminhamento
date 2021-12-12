<?php
if (!isset($_SESSION)) {
    session_start();
}
require_once "../vendor/autoload.php";
?>
<div>
    <div class="col s12">
        <h4 class="textoCorPadrao2 center">
            Registro
        </h4>
        <div class="divider"></div>
        <form id="formEncaminhamento" method="POST">
            <div class="row" style="margin-bottom: 0; padding: 0 .75rem;">
                <div class="row">
                    <div class="col m6 s12 no-padding">
                        <div class="input-field col s12">
                            <div class="chips chipsAluno chips-initial backgroundChipCLiFor"
                                 style="position: relative; margin-top: 0; margin-bottom: 0;">
                            </div>
                            <input autocomplete="off" type="text" name="id_aluno" hidden required id="idAluno"/>
                            <label for="idAluno" id="labelAluno">Aluno</label>
                        </div>
                    </div>
                    <div class="col m6 s12 input-field">
                        <input autocomplete="off" type="text" name="data_ocorrencia" id="dataOcorrencia" class="datepicker required">
                        <label for="dataOcorrencia">Data Ocorrência</label>
                    </div>
                    <div class="col m4 s12 input-field" style="margin-bottom: 0">
                        <select name="frequencia" id="frequencia">
                            <option value="" disabled selected>Selecione uma opção</option>
                            <option value="1">Diariamente</option>
                            <option value="2">Semanalmente</option>
                            <option value="3">Mensalmente</option>
                            <option value="4">Única vez</option>
                        </select>
                        <label for="frequencia">Frequência </label>
                    </div>
                    <div class="col m4 s12 no-padding">
                        <div class="input-field col s12">
                            <div class="chips chipsMotivo chips-initial backgroundChipCLiFor"
                                 style="position: relative; margin-top: 0; margin-bottom: 0;">
                            </div>
                            <input autocomplete="off" type="text" name="id_motivo" hidden id="idMotivo"/>
                            <label for="idMotivo" id="labelMotivo">Motivo</label>
                        </div>
                    </div>
                    <div class="col m4 s12 no-padding">
                        <div class="input-field col s12">
                            <div class="chips chipsRecurso chips-initial backgroundChipCLiFor"
                                 style="position: relative; margin-top: 0; margin-bottom: 0;">
                            </div>
                            <input autocomplete="off" type="text" name="id_recurso" hidden id="idRecurso"/>
                            <label for="idRecurso" id="labelRecurso">Recurso Utilizado</label>
                        </div>
                    </div>
                    <div class="col m6 s12 no-padding">
                        <div class="input-field col s12">
                            <div class="chips chipsSugestao chips-initial backgroundChipCLiFor"
                                 style="position: relative; margin-top: 0; margin-bottom: 0;">
                            </div>
                            <input autocomplete="off" type="text" name="id_sugestao" hidden id="idSugestao"/>
                            <label for="idSugestao" id="labelSugestao">Sugestão</label>
                        </div>
                    </div>
                    <div class="col m6 s12 input-field">
                        <input name="disciplina" id="disciplina" class="materialize-textarea" type="text" />
                        <label for="disciplina">Disciplina</label>
                    </div>
                    <div class="col s12 input-field">
                        <textarea name="relato" id="relato" class="materialize-textarea" type="text"></textarea>
                        <label for="relato">Descrição da Ocorrência</label>
                    </div>
                </div>
                <div class="row center divBtn">
                    <a id="linkBackForm" class="btn corPadrao3" href="#!">
                        <i class="material-icons left">keyboard_arrow_left</i>
                        Voltar
                    </a>
                    <a id="linkSubmitForm" href="#!" class="btn corPadrao2">
                        <i class="material-icons right">done</i>
                        Confirmar
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!--    Modal para selacao do Aluno -->
<div id="modalAluno" class="modal bottom-sheet modalSheetMaior">
    <div class="modal-content">
        <i class="material-icons modal-close iconeModalDetail">close</i>
        <div class="row">
            <div class="divPadrao">
                <div class="input-field col s10 center">
                    <i class="material-icons prefix">search</i>
                    <input autocomplete="off" type="text" class="validate" id="inputBuscaAluno">
                    <label for="inputBuscaAluno">Pesquisar</label>
                </div>
                <!-- TODO inplementar a função de cadastra mais pra frente-->
                <div class="input-field col right" style="margin-bottom: 0; margin: auto;">
                    <div class="waves-effect waves-light btnCadastroAluno btn modal-close green darken-2 modal-trigger">
                        <i class="material-icons left iconBtnAddCategoria">add</i>
                        <span class="hide-on-small-and-down">Novo</span>
                    </div>
                </div>
            </div>
            <div id="loaderAluno" class="progress">
                <div class="indeterminate"></div>
            </div>
            <div id="resultAluno">
            </div>
        </div>
    </div>
</div>

<div id="modalRegistroAluno" class="modal">

</div>

<!-- Modal geral usado para cadastro das options-->
<div id="modalRegistroSelectOption" class="modal">

</div>

<!--    Modal para selacao da turma -->
<div id="modalTurma" class="modal bottom-sheet modalSheetMaior">
    <div class="modal-content">
        <i class="material-icons modal-close iconeModalDetail">close</i>
        <div class="row">
            <div class="divPadrao">
                <div class="input-field col s10 center">
                    <i class="material-icons prefix">search</i>
                    <input autocomplete="off" type="text" class="validate" id="inputBuscaTurma">
                    <label for="inputBuscaTurma">Pesquisar</label>
                </div>
                <div class="input-field col right" style="margin-bottom: 0; margin: auto;">
                    <div class="waves-effect waves-light btnCadastroTurma btn modal-close green darken-2 modal-trigger">
                        <i class="material-icons left iconBtnAddCategoria">add</i>
                        <span class="hide-on-small-and-down">Novo</span>
                    </div>
                </div>
            </div>
            <div id="loaderTurma" class="progress">
                <div class="indeterminate"></div>
            </div>
            <div id="resultTurma">
            </div>
        </div>
    </div>
</div>

<!--    Modal para selacao do Motivo -->
<div id="modalMotivo" class="modal bottom-sheet modalSheetMaior">
    <div class="modal-content">
        <i class="material-icons modal-close iconeModalDetail">close</i>
        <div class="row">
            <div class="divPadrao">
                <div class="input-field col s10 center">
                    <i class="material-icons prefix">search</i>
                    <input autocomplete="off" type="text" class="validate" id="inputBuscaMotivo">
                    <label for="inputBuscaMotivo">Pesquisar</label>
                </div>
                <div class="input-field col right" style="margin-bottom: 0; margin: auto;">
                    <div class="waves-effect waves-light btnCadastroMotivo btn modal-close green darken-2 modal-trigger">
                        <i class="material-icons left iconBtnAddCategoria">add</i>
                        <span class="hide-on-small-and-down">Novo</span>
                    </div>
                </div>
            </div>
            <div id="loaderMotivo" class="progress">
                <div class="indeterminate"></div>
            </div>
            <div id="resultMotivo">
            </div>
        </div>
    </div>
</div>

<!--    Modal para selacao do Recurso -->
<div id="modalRecurso" class="modal bottom-sheet modalSheetMaior">
    <div class="modal-content">
        <i class="material-icons modal-close iconeModalDetail">close</i>
        <div class="row">
            <div class="divPadrao">
                <div class="input-field col s10 center">
                    <i class="material-icons prefix">search</i>
                    <input autocomplete="off" type="text" class="validate" id="inputBuscaRecurso">
                    <label for="inputBuscaRecurso">Pesquisar</label>
                </div>
                <div class="input-field col right" style="margin-bottom: 0; margin: auto;">
                    <div class="waves-effect waves-light btnCadastroRecurso btn modal-close green darken-2 modal-trigger">
                        <i class="material-icons left iconBtnAddCategoria">add</i>
                        <span class="hide-on-small-and-down">Novo</span>
                    </div>
                </div>
            </div>
            <div id="loaderRecurso" class="progress">
                <div class="indeterminate"></div>
            </div>
            <div id="resultRecurso">
            </div>
        </div>
    </div>
</div>

<!--    Modal para selacao da Sugestão -->
<div id="modalSugestao" class="modal bottom-sheet modalSheetMaior">
    <div class="modal-content">
        <i class="material-icons modal-close iconeModalDetail">close</i>
        <div class="row">
            <div class="divPadrao">
                <div class="input-field col s10 center">
                    <i class="material-icons prefix">search</i>
                    <input autocomplete="off" type="text" class="validate" id="inputBuscaSugestao">
                    <label for="inputBuscaSugestao">Pesquisar</label>
                </div>
                <div class="input-field col right" style="margin-bottom: 0; margin: auto;">
                    <div class="waves-effect waves-light btnCadastroSugestao btn modal-close green darken-2 modal-trigger">
                        <i class="material-icons left iconBtnAddCategoria">add</i>
                        <span class="hide-on-small-and-down">Novo</span>
                    </div>
                </div>
            </div>
            <div id="loaderSugestao" class="progress">
                <div class="indeterminate"></div>
            </div>
            <div id="resultSugestao">
            </div>
        </div>
    </div>
</div>
<script src="../Componentes/collectionModal.js?v=1"></script>
<script>
    const urlParams = new URLSearchParams(window.location.href).toString()
    const setor = urlParams.match(/Pedagogico/)
        ? 1
        : urlParams.match(/Disciplinar/)
            ? 2
            : 1

    // Verifica se algum modal esta aberto e caso esteja impede que a pagina volte e fecha o modal
    // caso não ai ele volta a pagina normalmente
    isOpen = false
    history.pushState(null, null, document.URL)
    window.addEventListener('popstate', function () {
        if (isOpen) {
            history.pushState(null, null, document.URL)
            $('.modal').modal('close')
        }
    })

    $(document).ready(function(){
        createDatePicker($("#dataOcorrencia"))
        $('select').formSelect()
        $('.modal').modal({
            onOpenEnd: function () { // Callback for Modal open
                isOpen = true
            },
            onCloseEnd: function () { // Callback for Modal close
                isOpen = false
            }
        })
    })

    $('#idMotivo').click(function (){
        getMotivoOption()
    })

    $('.chipsMotivo').click(function () {
        getMotivoOption()
    })

    $('#inputBuscaMotivo').keyup(function () {
        getMotivoOption($('#inputBuscaMotivo').val())
    })

    function getMotivoOption(busca = '') {
        $('#inputBuscaMotivo').val()
        $('#loaderMotivo').show()
        $('#labelMotivo').removeClass('labelAtiva')
        $('#idMotivo').val('')
        att([], '.chipsMotivo')

        $.ajax({
            url: '../Controle/selectOptionControle.php?function=selectToModal',
            method: 'post',
            data: {
                tipo: 1,
                setor: setor,
                busca: busca
            },
            success: function (response) {
                $('#loaderMotivo').hide()
                if (response.length > 0) {
                    $('#resultMotivo').html(collectionModal(response, 'clicarItemMotivo'))
                    $('.clicarItemMotivo').click(function () {
                        $('#idMotivo').val($(this).attr('id'))
                        const data = [
                            {
                                tag: $(this).html()
                            }
                        ]
                        att(data, '.chipsMotivo')
                        $('#labelMotivo').addClass('labelAtiva')
                        $('#modalMotivo').modal('close')
                    })
                } else {
                    $('#resultMotivo').html('<div class="textoSemRetorno">Nenhum dado encontrado.</div>')
                }
            }
        })

        $('#modalMotivo').modal('open')
    }

    $('#idSugestao').click(function (){
        getSugestaoOption()
    })

    $('.chipsSugestao').click(function () {
        getSugestaoOption()
    })

    $('#inputBuscaSugestao').keyup(function () {
        getSugestaoOption($('#inputBuscaSugestao').val())
    })

    function getSugestaoOption(busca = '') {
        $('#inputBuscaSugestao').val()
        $('#loaderSugestao').show()
        $('#labelSugestao').removeClass('labelAtiva')
        $('#idSugestao').val('')
        att([], '.chipsSugestao')

        $.ajax({
            url: '../Controle/selectOptionControle.php?function=selectToModal',
            method: 'post',
            data: {
                tipo: 2,
                setor: setor,
                busca: busca
            },
            success: function (response) {
                $('#loaderSugestao').hide()
                if (response.length > 0) {
                    $('#resultSugestao').html(collectionModal(response, 'clicarItemSugestao'))
                    $('.clicarItemSugestao').click(function () {
                        $('#idSugestao').val($(this).attr('id'))
                        const data = [
                            {
                                tag: $(this).html()
                            }
                        ]
                        att(data, '.chipsSugestao')
                        $('#labelSugestao').addClass('labelAtiva')
                        $('#modalSugestao').modal('close')
                    })
                } else {
                    $('#resultSugestao').html('<div class="textoSemRetorno">Nenhum dado encontrado.</div>')
                }
            }
        })

        $('#modalSugestao').modal('open')
    }

    $('#idRecurso').click(function (){
        getRecursoOption()
    })

    $('.chipsRecurso').click(function () {
        getRecursoOption()
    })

    $('#inputBuscaRecurso').keyup(function () {
        getRecursoOption($('#inputBuscaRecurso').val())
    })

    function getRecursoOption(busca = '') {
        $('#inputBuscaRecurso').val()
        $('#loaderRecurso').show()
        $('#labelRecurso').removeClass('labelAtiva')
        $('#idRecurso').val('')
        att([], '.chipsRecurso')

        $.ajax({
            url: '../Controle/selectOptionControle.php?function=selectToModal',
            method: 'post',
            data: {
                tipo: 3,
                setor: setor,
                busca: busca
            },
            success: function (response) {
                $('#loaderRecurso').hide()
                if (response.length > 0) {
                    $('#resultRecurso').html(collectionModal(response, 'clicarItemRecurso'))
                    $('.clicarItemRecurso').click(function () {
                        $('#idRecurso').val($(this).attr('id'))
                        const data = [
                            {
                                tag: $(this).html()
                            }
                        ]
                        att(data, '.chipsRecurso')
                        $('#labelRecurso').addClass('labelAtiva')
                        $('#modalRecurso').modal('close')
                    })
                } else {
                    $('#resultRecurso').html('<div class="textoSemRetorno">Nenhum dado encontrado.</div>')
                }
            }
        })
        $('#modalRecurso').modal('open')
    }

    $('#idAluno').click(function (){
        getAlunoOption('')
    })

    $('.chipsAluno').click(function () {
        getAlunoOption('')
    })

    $('#inputBuscaAluno').keyup(function () {
        getAlunoOption($('#inputBuscaAluno').val())
    })

    function getAlunoOption(busca = '') {
        $('#inputBuscaAluno').val()
        $('#loaderAluno').show()
        $('#labelAluno').removeClass('labelAtiva')
        $('#idAluno').val('')
        att([], '.chipsAluno')

        $.ajax({
            url: '../Controle/alunoControle.php?function=selectToModal',
            method: 'post',
            data: {
                busca: busca
            },
            success: function (response) {
                $('#loaderAluno').hide()
                if (response.length > 0) {
                    $('#resultAluno').html(collectionModal(response, 'clicarItemAluno'))
                    $('.clicarItemAluno').click(function () {
                        $('#idAluno').val($(this).attr('id'))
                        const data = [
                            {
                                tag: $(this).html()
                            }
                        ]
                        att(data, '.chipsAluno')
                        $('#labelAluno').addClass('labelAtiva')
                        $('#modalAluno').modal('close')
                    })
                } else {
                    $('#resultAluno').html('<div class="textoSemRetorno">Nenhum dado encontrado.</div>')
                }
            }
        })

        $('#modalAluno').modal('open')
    }

    $('.btnCadastroAluno').click(function (e) {
        initLoader()
        $('#modalRegistroAluno').load('./modalRegistroAluno.php', function () {
            closeLoader()
            $('#modalRegistroAluno').modal('open')
            M.updateTextFields()
        })
    })

    // Aqui é feito o loading e intancia principal do modal de registro das option
    // São elas: Motivo, Sugestão, Recurso e turma.
    $('#modalRegistroSelectOption').load('./modalRegistroSelectOption.php', function () {
        modalRegitroSelectOption = new ModalRegistroSelectOption()
    })

    $('.btnCadastroMotivo').click(function (e) {
        initLoader()
        $('#modalRegistroSelectOption').modal('open')
        modalRegitroSelectOption.setTitle('Cadastro Motivo')
        modalRegitroSelectOption.tipo = 1
        modalRegitroSelectOption.setor = setor
        modalRegitroSelectOption.idAtt = '#idMotivo'
        modalRegitroSelectOption.classChipAtt = '.chipsMotivo'
        modalRegitroSelectOption.idLabel = '#labelMotivo'
        modalRegitroSelectOption.modalRefer = '#modalRegistroSelectOption'
        M.updateTextFields()
        modalRegitroSelectOption.clear()
        modalRegitroSelectOption.focusTextoInput()
        closeLoader()
    })

    $('.btnCadastroSugestao').click(function (e) {
        initLoader()
        $('#modalRegistroSelectOption').modal('open')
        modalRegitroSelectOption.setTitle('Cadastro Sugestão')
        modalRegitroSelectOption.tipo = 2
        modalRegitroSelectOption.setor = setor
        modalRegitroSelectOption.idAtt = '#idSugestao'
        modalRegitroSelectOption.classChipAtt = '.chipsSugestao'
        modalRegitroSelectOption.idLabel = '#labelSugestao'
        modalRegitroSelectOption.modalRefer = '#modalRegistroSelectOption'
        M.updateTextFields()
        modalRegitroSelectOption.clear()
        modalRegitroSelectOption.focusTextoInput()
        closeLoader()
    })

    $('.btnCadastroRecurso').click(function (e) {
        initLoader()
        $('#modalRegistroSelectOption').modal('open')
        modalRegitroSelectOption.setTitle('Cadastro Recurso Utilizado')
        modalRegitroSelectOption.tipo = 3
        modalRegitroSelectOption.setor = setor
        modalRegitroSelectOption.idAtt = '#idRecurso'
        modalRegitroSelectOption.classChipAtt = '.chipsRecurso'
        modalRegitroSelectOption.idLabel = '#labelRecurso'
        modalRegitroSelectOption.modalRefer = '#modalRegistroSelectOption'
        M.updateTextFields()
        modalRegitroSelectOption.clear()
        modalRegitroSelectOption.focusTextoInput()
        closeLoader()
    })

    $('.btnCadastroTurma').click(function (e) {
        initLoader()
        $('#modalRegistroSelectOption').modal('open')
        modalRegitroSelectOption.setTitle('Cadastro Turma')
        modalRegitroSelectOption.tipo = 4
        modalRegitroSelectOption.setor = setor
        modalRegitroSelectOption.idAtt = '#idTurma'
        modalRegitroSelectOption.classChipAtt = '.chipsTurma'
        modalRegitroSelectOption.idLabel = '#labelTurma'
        modalRegitroSelectOption.modalRefer = '#modalRegistroSelectOption'
        M.updateTextFields()
        modalRegitroSelectOption.clear()
        modalRegitroSelectOption.focusTextoInput()
        closeLoader()
    })

    function att(data, chipDiv) {
        $(chipDiv).chips({
            data: data,
            limit: 1,
            minLength: 1
        })
    }

    /**
     * @param {function} submitFunction - Recebe uma função que sera
     * executada quando o botão de submit for chamado, e repassa
     * os dados do form serializados.
     * @param {function} backFunction - Recebe uma função que sera
     * executada quando o botão de voltar for chamado.
     */
    function init(submitFunction, backFunction = null) {
        $("#linkSubmitForm").click(e => {
            e.preventDefault()
            // if (verifyFieldsRequired()) {
                const dados = $("#formEncaminhamento").serialize()
                const dadosObj = $("#formEncaminhamento").serializeArray()
                submitFunction(dados, dadosObj)
            // } else {
            //     addToast('Por favor preencha todos os campos obrigatórios.')
            // }
        })

        $("#linkBackForm").click(e => {
            if (backFunction === null) {
                window.location.href = document.referrer
            } else {
                backFunction()
            }
        })
    }

    /**
     * Verifica os campos que devem ser obrigatorios
     * @returns {boolean}
     */
    const verifyFieldsRequired = () => {
        let retorno = true
        $('.requiredProdutoForm').each(function () {
            if (!$(this).val()) {
                retorno = false
            }
        })
        return retorno
    }
</script>