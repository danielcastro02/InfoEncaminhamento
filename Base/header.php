<?php
//Define em que nivel de pasta estamos para fazer include de qualquer lugar
$pontos = "";
if(!isset($_SESSION)){
    session_start();
}
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
require_once $pontos."vendor/autoload.php";

use TCC\Controle\UsuarioPDO;
use TCC\Modelo\Parametros;
$parametros = new Parametros();

$usuarioPDO = new UsuarioPDO();

//numeruzinho da versão pra att o cache
$numeruzinho = 81;
?>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="UTF-8">
<link rel="stylesheet" href="<?php echo $pontos; ?>css/materialize.css?v=<?php echo $numeruzinho; ?>">
<link rel="stylesheet" href="<?php echo $pontos; ?>css/custom.css?v=<?php echo $numeruzinho; ?>">
<link rel="stylesheet" href="<?php echo $pontos; ?>css/fieldsetCustom.css?v=<?php echo $numeruzinho; ?>">
<link rel="stylesheet" href="<?php echo $pontos; ?>css/listCustom.css?v=<?php echo $numeruzinho; ?>">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<script type="text/javascript" src="<?php echo $pontos; ?>js/jquery-3.3.1.min.js?v=<?php echo $numeruzinho; ?>"></script>
<script type="text/javascript" src="<?php echo $pontos; ?>js/materialize.js?v=<?php echo $numeruzinho; ?>"></script>
<script type="text/javascript" src="<?php echo $pontos; ?>js/chart.bundle.min.js?v=<?php echo $numeruzinho; ?>" ></script>
<script type="text/javascript" src="<?php echo $pontos; ?>js/mascaras.js?v=<?php echo $numeruzinho; ?>" ></script>
<script type="text/javascript" src="<?php echo $pontos; ?>js/jquery.maskMoney.js?v=<?php echo $numeruzinho; ?>" ></script>
<script type="text/javascript" src="<?php echo $pontos; ?>js/jquery.textfill.min.js?v=<?php echo $numeruzinho; ?>" ></script>
<script type="text/javascript" src="<?php echo $pontos; ?>js/helpers.js?v=<?php echo $numeruzinho; ?>" ></script>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<link rel="icon" href="../Img/fivIcon.png" />
<link rel="stylesheet" href="<?php echo $pontos; ?>css/listCustom.css?v=<?php echo $numeruzinho; ?>">

<?php
include_once $pontos."Base/toast.php";
include_once $pontos."Base/logPosition.php";

?>

<script type="text/javascript">
    var isIE = /*@cc_on!@*/!!document.documentMode;
    if(isIE == true){
        window.location.href = "<?php echo $pontos; ?>Tela/internetExplorer.php";
    }
    </script>
