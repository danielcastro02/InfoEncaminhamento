/**
 *
 * @param json
 * @param classClick
 * @returns {string}
 */
function collectionModal(json, classClick = '') {
    let collection =
        "<ul class='collection collectionAlunoModal'>" +
            ":li" +
        "</ul>"

    collection = collection.replace(":li", collectionLi(json, classClick))

    return collection
}

function collectionLi(json, classClick) {
    let allLi = ""

    json.forEach((obj) => {
        let li =
            "<li style='position: relative' id=':id' class='collection-item clicar-item :classClick'>" +
                ":name" +
            "</li>"

        li = li.replace(":id", obj.id)
            .replace(":name", obj.nome)
            .replace(":classClick", classClick)

        allLi += li
    })

    return allLi
}