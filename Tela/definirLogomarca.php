<?php
include_once '../Base/requerAdm.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="cache-control" content="no-cache" />
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

            <div class="row">
                <?php if(isset($_GET['tipo'])){
                    if($_GET['tipo']== 'destaques'){
                        $action = '../Controle/parametrosControle.php?function=alteraDestaque';
                    }else{
                        $action = '../Controle/parametrosControle.php?function=alteraLogo';
                    }
                }else{
                    $action = '../Controle/parametrosControle.php?function=alteraLogo';
                } ?>
                <form class="col s12" action="<?php echo $action; ?>" method="post"  enctype="multipart/form-data">
                    <input autocomplete="off" type="file" class="file-chos" id="btnFile" name="imagem" accept=".jpg,.jpeg,.bmp,.png,.jfif,.svg,.webp,.gif" hidden required="true">
                    <input autocomplete="off" class="file-path validate" type="text" hidden="true">
                    <div class="row center" style="margin-top: 20px;">
                        <h5>Pré Visualização</h5>
                        <img  class="prev-img" style="
                              max-height: 200px;
                              width: auto;
                              background-size: cover;
                              background-position: center;
                              background-repeat: no-repeat;
                              ">
                    </div>
                    <div class="row center">
                        <a id="selecionaFoto" href="#!" class="btn waves-effect  corPadrao2">Selecionar</a>
                        <script>
                            $("#selecionaFoto").click(function () {
                                $("#btnFile").click();
                            });
                        </script>
                    </div>
                    <div class="row center">
                        <a href="./editarParametros.php" class="modal-close waves-effect waves-green btn waves-effect  corPadrao3">Cancelar</a>
                        <button type="submit" name="SendCadImg" value="true" class="btn waves-effect corPadrao2">Confirmar</button>
                    </div>
                </form>

            </div>

            <script>


                const previewImg = $('.prev-img');
                const fileChooser = $('.file-chos');

                fileChooser.onchange = e => {
                    const fileToUpload = e.target.files.item(0);
                    const reader = new FileReader();

                    // evento disparado quando o reader terminar de ler 
                    reader.onload = e => previewImg.src = e.target.result;

                    // solicita ao reader que leia o arquivo 
                    // transformando-o para DataURL. 
                    // Isso disparará o evento reader.onload.
                    reader.readAsDataURL(fileToUpload);
                };
            </script>

        </main>
        <?php
        include_once '../Base/footer.php';
        ?>
    </body>
</html>

