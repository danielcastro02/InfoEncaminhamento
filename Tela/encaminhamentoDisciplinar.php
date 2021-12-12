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
    use TCC\Modelo\Parametros;
    $parametros = new Parametros();
    ?>
    <title><?php echo $parametros->getNome_empresa(); ?></title>

<body class="homeimg">
<?php
include_once '../Base/iNav.php';
?>
<main>
    <div class="row divCardLS">
        <div id="divEncaminhamento" class="card col s12" style="border-radius: 2px">
        </div>
    </div>
</main>
<?php
include_once '../Base/footer.php';
?>

<script>
    $(document).ready(() => {
        $('#divEncaminhamento').load('../../Componentes/formEncaminhamento.php', () => {
            init(submitEncaminhamento)
            M.updateTextFields()
        })
    })

    function submitEncaminhamento (dados, dadosObj) {
        initLoader()
        $.ajax({
            data : dados + '&setor=1',
            url : "../Controle/encaminhamentoControle.php?function=insert",
            type : "post",
            success : function (response){
                if (response !== false) {
                    console.warn(response)
                    addToast("Registro criado")
                    closeLoader()
                    window.location.href = "../index.php";
                    return null
                } else {
                    addToast("Erro ao registrar.")
                }
            },
            error: function (request, status, error) {
                closeLoader()
                addToast("Erro ao registrar.")
                console.error(request.responseText, error);
            }
        })

        return null
    }
</script>
</body>
</html>
