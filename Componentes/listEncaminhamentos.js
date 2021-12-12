const STT_ABERTO = '1'
const STT_ATENDENDO = '2'
const STT_RESOLVIDO = '3'

function listEncaminhamentos(json , nivel = 1) {
    let collection =
        "<ul class='collection'>" +
            ":li" +
        "</ul>"

    collection = collection.replace(":li", montLi(json, nivel))

    return collection
}

function montLi(json , nivel) {
    console.warn(json)

    let allLi = ""

    json.forEach((obj) => {
        let li =
            "<li class='collection-item avatar' style='padding-left: 20px !important; min-height: 140px !important;'>" +
                "<div class='divWraperDiferentinha col s12' style='max-height: fit-content !important;'>" +
                    "<p class='left-align card-title' style='margin-bottom: 2px; font-size: 20px'>" +
                        "Aluno: :nomeAluno" +
                    "</p>" +
                    "<p class='left-align' style='line-height: 1.2; width: 50%; margin-left: 3px; max-height: 29px; white-space: nowrap; overflow: hidden; text-overflow:ellipsis'>" +
                        "Relato: :relato" +
                    "</p>" +
                    "<p class='left-align' style='line-height: 1.2; margin-left: 3px; width: 50%; white-space: nowrap; overflow: hidden; text-overflow:ellipsis'>" +
                        "Motivo: :motivo" +
                    "</p>" +
                    "<p class='left-align' style='line-height: 1.2; margin-left: 3px; width: 50%'>" +
                        "Aberto em: :dataAbertura" +
                    "</p>" +
                    "<p class='left-align' style='line-height: 1.2; margin-left: 3px; width: 50%'>" +
                        "Data da Ocorrência: :dataOcorrencia" +
                    "</p>" +
                    "<span class='left new badge orange' style='margin-left: 1px; margin-top: 2px' data-badge-caption=''>" +
                        ":status" +
                    "</span>" +
                "</div>" +
                "<a href='"+(nivel===1?".":"..")+"/Tela/verEncaminhamento.php?id_encaminhamento=:idEncaminhamento' class='itemListUsuario segundoItem'>" +
                    "<i class='material-icons textoCorPadrao2'>assignment</i>" +
                "</a>" +
            "</li>"

        li = li.replace(":nomeAluno", obj.nome)
            .replace(":relato", obj.relato)
            .replace(":motivo", obj.motivo)
            .replace(":dataAbertura", obj.data_aberto)
            .replace(":dataOcorrencia", obj.data_ocorrencia)
            .replace(":status", textStatus(obj.status))
            .replace(":idEncaminhamento", obj.id)

        allLi += li
    })

    return allLi
}

const textStatus = (status) => {
    return status === STT_ABERTO
        ? 'Aberto'
        : status === STT_ATENDENDO
            ? 'Atendendo'
            : status === STT_RESOLVIDO
                ? 'Resolvido'
                : 'Não definido'
}