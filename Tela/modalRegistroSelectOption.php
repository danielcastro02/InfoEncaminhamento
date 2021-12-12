<?php
if (!isset($_SESSION)) {
    session_start();
}
include_once '../Base/requerLogin.php';
?>
<div class="modal-content" style="padding-bottom: 0">
    <div>
        <h5 class="textoCorPadrao2 center" id="titleModalRegistroOption">Cadastrar Turma</h5>
        <div class="divider"></div>
        <form method="POST" id="formSelectOption">
            <div class="row">
                <input autocomplete="off" type="text" name="id_option" hidden id="idSelectOption"/>

                <div class="input-field col s12">
                    <input autocomplete="off" type="text" name="texto" required class="required" id="textoSelectOption"/>
                    <label for="textoSelectOption">Nome</label>
                </div>
                <div class="center divBtn">
                    <a href="#!" class="btn corPadrao3 btnFooter" id="voltarModalSelectOption">
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
    class ModalRegistroSelectOption {
        titlemodal
        texto
        setor
        tipo
        classChipAtt
        idLabel
        idAtt
        modalRefer

        constructor() {
            const mainContext = this

            $('#formSelectOption').submit(function (e) {
                e.preventDefault()
                initLoader()
                const dados = $("#formSelectOption").serialize() + '&setor=' + mainContext.setor + '&tipo=' + mainContext.tipo

                $.ajax({
                    data : dados,
                    url : "../Controle/selectOptionControle.php?function=insert",
                    type : "post",
                    success : function (response){
                        if (Object.keys(response).length !== 0) {
                            addToast("Registro criado")
                            $(mainContext.idAtt).val(response.id_option)
                            const data = [
                                {
                                    tag: response.texto
                                }
                            ]
                            mainContext.att(data, mainContext.classChipAtt)
                            $(mainContext.idLabel).addClass('labelAtiva')
                            $(mainContext.modalRefer).modal('close')
                            closeLoader()
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

            $('#voltarModalSelectOption').click(function () {
                $(mainContext.modalRefer).modal('close')
            })
        }

        att(data, chipDiv) {
            $(chipDiv).chips({
                data: data,
                limit: 1,
                minLength: 1
            })
        }

        clear() {
            $('#formSelectOption').trigger("reset")
        }

        setTitle(titleModal) {
            this.titlemodal = titleModal
            $('#titleModalRegistroOption').html(titleModal)
        }

        focusTextoInput() {
            $('#textoSelectOption').focus()
        }
    }

</script>
