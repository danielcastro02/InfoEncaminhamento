<?php
if(!isset($_SESSION)){
    session_start();
}
require_once "../Base/requerLogin.php";
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <?php
    include_once '../Base/header.php';

    use TCC\Modelo\Encaminhamento;
    use TCC\Modelo\Parametros;
    use TCC\Modelo\Usuario;

    $parametros = new Parametros();
    $logado = new Usuario(unserialize($_SESSION["logado"]));
    ?>
    <title><?php echo $parametros->getNome_empresa(); ?></title>
<body class="homeimg">

<?php
include_once '../Base/iNav.php';

?>
<main>
    <div class="row">
        <div class="col s10 offset-l1 card">
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
                                <div class="col m4 s12 no-padding">
                                    <div class="input-field col s12">
                                        <div class="chips chipsSugestao chips-initial backgroundChipCLiFor"
                                             style="position: relative; margin-top: 0; margin-bottom: 0;">
                                        </div>
                                        <input autocomplete="off" type="text" name="id_sugestao" hidden id="idSugestao"/>
                                        <label for="idSugestao" id="labelSugestao">Sugestão</label>
                                    </div>
                                </div>
                                <?php
                                if($logado->getAdministrador()>0){
                                ?>
                                <div class="col m4 s12 no-padding">
                                    <div class="input-field col s12">
                                        <div class="chips chipsServidor chips-initial backgroundChipCLiFor"
                                             style="position: relative; margin-top: 0; margin-bottom: 0;">
                                        </div>
                                        <input autocomplete="off" type="text" name="id_servidor" hidden id="idServidor"/>
                                        <label for="idServidor" id="labelServidor">Servidor</label>
                                    </div>
                                </div>
                                <?php
                                }
                                ?>
                                <div class="col m4 s12 input-field">
                                    <input name="disciplina" id="disciplina" class="materialize-textarea" type="text" />
                                    <label for="disciplina">Disciplina</label>
                                </div>
                                <div class="col s4 input-field">
                                    <textarea name="pesquisa" id="relato" class="materialize-textarea" type="text"></textarea>
                                    <label for="relato">Pesquisa livre</label>
                                </div>
                                <div class="col s4 input-field">
                                    <select id="selectStatus" name="setor">
                                        <option value="0">Setor</option>
                                        <option value="<?= Encaminhamento::SET_CAE ?>">CAE</option>
                                        <option value="<?= Encaminhamento::SET_PEDAGOGICO ?>">Pedagogico</option>
                                    </select>
                                </div>
                                <div class="col s4 input-field">
                                    <select id="selectStatus" name="status">
                                        <option value="0">Status</option>
                                        <option value="<?= Encaminhamento::STT_ABERTO ?>">Aberto</option>
                                        <option value="<?= Encaminhamento::STT_ATENDENDO ?>">Em atendimento</option>
                                        <option value="<?= Encaminhamento::STT_RESOLVIDO ?>">Resolvido</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row center divBtn">
                                <a id="linkBackForm" class="btn corPadrao3" href="#!">
                                    <i class="material-icons left">keyboard_arrow_left</i>
                                    Voltar
                                </a>
                                <a id="linkSubmitForm" href="#!" class="btn corPadrao2">
                                    <i class="material-icons right">done</i>
                                    Buscar
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
                            <div class="input-field col s12 center">
                                <i class="material-icons prefix">search</i>
                                <input autocomplete="off" type="text" class="validate" id="inputBuscaAluno">
                                <label for="inputBuscaAluno">Pesquisar</label>
                            </div>

                        </div>
                        <div id="resultAluno">
                            <div id="loaderAluno" class="progress">
                                <div class="indeterminate"></div>
                            </div>
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
                            <div class="input-field col s12 center">
                                <i class="material-icons prefix">search</i>
                                <input autocomplete="off" type="text" class="validate" id="inputBuscaMotivo">
                                <label for="inputBuscaMotivo">Pesquisar</label>
                            </div>
                        </div>
                        <div id="resultMotivo">
                            <div id="loaderMotivo" class="progress">
                                <div class="indeterminate"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--    Modal para selacao do Servidor -->
            <div id="modalServidor" class="modal bottom-sheet modalSheetMaior">
                <div class="modal-content">
                    <i class="material-icons modal-close iconeModalDetail">close</i>
                    <div class="row">
                        <div class="divPadrao">
                            <div class="input-field col s12 center">
                                <i class="material-icons prefix">search</i>
                                <input autocomplete="off" type="text" class="validate" id="inputBuscaMotivo">
                                <label for="inputBuscaServidor">Pesquisar</label>
                            </div>
                        </div>
                        <div id="resultServidor">
                            <div id="loaderServidor" class="progress">
                                <div class="indeterminate"></div>
                            </div>
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
                            <div class="input-field col s12 center">
                                <i class="material-icons prefix">search</i>
                                <input autocomplete="off" type="text" class="validate" id="inputBuscaRecurso">
                                <label for="inputBuscaRecurso">Pesquisar</label>
                            </div>
                        </div>
                        <div id="resultRecurso">
                            <div id="loaderRecurso" class="progress">
                                <div class="indeterminate"></div>
                            </div>
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
                            <div class="input-field col s12 center">
                                <i class="material-icons prefix">search</i>
                                <input autocomplete="off" type="text" class="validate" id="inputBuscaSugestao">
                                <label for="inputBuscaSugestao">Pesquisar</label>
                            </div>
                        </div>
                        <div id="resultSugestao">
                            <div id="loaderSugestao" class="progress">
                                <div class="indeterminate"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script src="../Componentes/collectionModal.js?v=1"></script>
            <script src="../Componentes/listEncaminhamentos.js"></script>

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

                $('.modal').modal({
                    onOpenEnd: function () { // Callback for Modal open
                        isOpen = true
                    },
                    onCloseEnd: function () { // Callback for Modal close
                        isOpen = false
                    }
                })

                $(document).ready(function(){
                    createDatePicker($("#dataOcorrencia"))
                    $('select').formSelect()
                })

                $('#idMotivo').click(function (){
                    getMotivoOption()
                })

                $('.chipsMotivo').click(function () {
                    getMotivoOption()
                })

                function getMotivoOption() {
                    $('#labelMotivo').removeClass('labelAtiva')
                    att([], '.chipsMotivo')

                    $.ajax({
                        url: '../Controle/selectOptionControle.php?function=selectToModal',
                        method: 'post',
                        data: {
                            tipo: 1,
                            setor: setor
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

                $('.chipsServidor').click(function () {
                    getServidorOption()
                })

                function getServidorOption() {
                    $('#labelServidor').removeClass('labelAtiva')
                    att([], '.chipsServidor')

                    $.ajax({
                        url: '../Controle/usuarioControle.php?function=selectToModal',
                        method: 'post',
                        data: {
                            tipo: 1,
                            setor: setor
                        },
                        success: function (response) {
                            $('#loaderServidor').hide()
                            if (response.length > 0) {
                                $('#resultServidor').html(collectionModal(response, 'clicarItemServidor'))
                                $('.clicarItemServidor').click(function () {
                                    $('#idServidor').val($(this).attr('id'))
                                    const data = [
                                        {
                                            tag: $(this).html()
                                        }
                                    ]
                                    att(data, '.chipsServidor')
                                    $('#labelServidor').addClass('labelAtiva')
                                    $('#modalServidor').modal('close')
                                })
                            } else {
                                $('#resultServidor').html('<div class="textoSemRetorno">Nenhum dado encontrado.</div>')
                            }
                        }
                    })

                    $('#modalServidor').modal('open')
                }
                
                $('#idSugestao').click(function (){
                    getSugestaoOption()
                })

                $('.chipsSugestao').click(function () {
                    getSugestaoOption()
                })

                function getSugestaoOption() {
                    $('#labelSugestao').removeClass('labelAtiva')
                    att([], '.chipsSugestao')

                    $.ajax({
                        url: '../Controle/selectOptionControle.php?function=selectToModal',
                        method: 'post',
                        data: {
                            tipo: 2,
                            setor: setor
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

                function getRecursoOption() {
                    $('#labelRecurso').removeClass('labelAtiva')
                    att([], '.chipsRecurso')

                    $.ajax({
                        url: '../Controle/selectOptionControle.php?function=selectToModal',
                        method: 'post',
                        data: {
                            tipo: 3,
                            setor: setor
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

                function getAlunoOption(busca = '') {
                    $('#labelAluno').removeClass('labelAtiva')
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
                        const dados = $("#formEncaminhamento").serialize()
                        const dadosObj = $("#formEncaminhamento").serializeArray()
                        submitFunction(dados, dadosObj)
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
                var verifyFieldsRequired = () => {
                    let retorno = true
                    $('.requiredProdutoForm').each(function () {
                        if (!$(this).val()) {
                            retorno = false
                        }
                    })
                    return retorno
                }

                function submitFunction(){
                    $(".containerListCuston").show()
                    $('#loaderEncaminhamentos').show()

                    $.ajax({
                        url: '../Controle/encaminhamentoControle.php?function=selectTolistagemByPesquisa',
                        method: 'post',
                        data: $("#formEncaminhamento").serialize(),
                        success: function (response) {
                            $('#loaderEncaminhamentos').hide()
                            console.warn(response)
                            if (response.length > 0) {
                                $('#divEncaminhamentos').html(listEncaminhamentos(response , 2))
                            } else {
                                $('#divEncaminhamentos').html('<div class="textoSemRetorno">Nenhum dado encontrado.</div>')
                            }
                        }
                    })
                }

                init(submitFunction);

            </script>
        </div>
    </div>
    <div class="row containerListCuston" style="display: none">
        <div class="card col s12">
            <div class="divider" style="margin-bottom: 0"></div>
            <div id="loaderEncaminhamentos" class="preloader-wrapper big active"
                 style="left: calc(50% - 32px); top: calc(50% - 32px);">
                <div class="spinner-layer spinner-blue-only">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="gap-patch">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <div id="divEncaminhamentos">
            </div>
        </div>
    </div>

</main>
<?php
include_once '../Base/footer.php';
?>

<script>

</script>
</body>
</html>
