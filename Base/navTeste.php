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
?>

<div class="navbar-fixed">
    <nav class="nav-extended">
        <div class="nav-wrapper" style="width: 100vw; margin-left: auto; margin-right: auto;">

            <a href="#" data-target="slide-out" class="sidenav-trigger">
                <i class="material-icons white-text">menu</i>
            </a>
    </nav>
</div>

<!--SidNavBar que deve se tornar padrão-->

<ul id="slide-out" class="sidenav sidenav-fixed">
    <li>
        <div class="" style="background-color: #06022B; max-height: 45px;">
            <img src="<?php echo $pontos ?>Img/TCC-04-ALVO.svg"
                 style="float: left; max-width: 250px; max-height: 45px; margin-left: 8px; color: white">
            <span style="margin-left: 10px; font-size: 20px; color: white">Financeira<b>mente</b></span>
        </div>
    </li>
    <li class="no-padding">
        <ul class="collapsible collapsible-accordion">
            <li>
                <a class="waves-effect black-text collapsible-header anime" x="0" href="#!">
                    <i class="material-icons changeColor" style="color: black; font-size: 1.5rem">home</i>
                    Inicio
                </a>
            </li>
            <li>
                <a class="waves-effect black-text anime" x="0" href="#!">
                    <i class="material-icons giraEmudaCor" style="color: black; font-size: 1.5rem">swap_horiz</i>
                    Movimentações
                </a>
            </li>
            <li>
                <a class="waves-effect black-text collapsible-header anime" x="0" href="#!">
                    <i class="material-icons changeColor" style="color: black; font-size: 1.5rem">show_chart</i>
                    Relatorios
                </a>
            </li>
            <li>
                <a class="waves-effect black-text collapsible-header anime" x="0" href="#!">
                    <i class="material-icons giraEmudaCor" style="color: black; font-size: 1.5rem">settings</i>
                    Configurações
                </a>
            </li>
            <!--    Essa li abrange a fução de collapsible, é importante ter a função em java scrit para fazer a seta girar e da classe-->
            <!--    animi (na folha css), anime e a propriedade "x"-->

            <li>
                <a class="waves-effect black-text collapsible-header anime" x="0" href="#!">
                    <i class="material-icons changeColor" style="color: black; font-size: 1.5rem">help_outline</i>
                    Sobre
                    <i class="large material-icons right animi black-text">arrow_drop_down</i>
                </a>

                <div class="collapsible-body">
                    <ul>
                        <li><a href="#!">Conheça nossos cursos</a></li>
                        <li><a href="#!">Politica de Privacidade</a></li>
                    </ul>
                </div>
            </li>
        </ul>
    </li>
    <li>
        <div class="divider"></div>
    </li>

    <!-- <li><a class="subheader">TCC todos os direitos reservados © 2020 FinanceirameneApp</a></li>-->
    <li style="margin-top: 25px; position:fixed; bottom: 60px; width: 100%"><a class="waves-effect black-text" href="#!">
            <i class="material-icons black-text" style="font-size: 1.5rem">power_settings_new</i>Sair
        </a>
    </li>
</ul>

<script>

    $('.sidenav').sidenav();
    $('.collapsible').collapsible();

    $('.dropdown-trigger').dropdown({
        coverTrigger: false
    });
    //$('#modal25').modal();
    //$('#modalSair').modal();
    //var instanceASDF = M.Modal.getInstance(document.getElementById('modal25'));
    <?php
    //if (($logado->getEmail() == null || "") && (!isset($_SESSION['ignore_null_mail']))) {
    //    echo "instanceASDF.open();";
    //    $_SESSION['ignore_null_mail'] = 'true';
    //}
    ?>
    $(".anime").each(function () {
        if ($(this).attr("x") == 1) {
            $(this).children(".animi").attr("style", "transform: rotate(180deg); color: black;");
            $(this).children(".giraEmudaCor").attr("style", "color: #0F8F00; font-size: 1.5rem; transform: rotate(180deg);");
            $(this).children(".changeColor").attr("style", "color: black; font-size: 1.5rem");
        }

    });

    $(".anime").click(function () {
        if ($(this).attr("x") == 0) {
            $(".anime").attr("x", "0");
            $(".animi").attr("style", "transform: rotate(0deg); color: black;");
            $(".changeColor").attr("style", "color: black; font-size: 1.5rem;");
            $(".giraEmudaCor").attr("style", "color: black; font-size: 1.5rem; transform: rotate(0deg);");

            $(this).children(".changeColor").attr("style", "color: #0F8F00; font-size: 1.5rem");
            $(this).children(".giraEmudaCor").attr("style", "color: #0F8F00; font-size: 1.6rem; transform: rotate(180deg);");
            $(this).children(".animi").attr("style", "transform: rotate(180deg);");
            $(this).attr("x", "1");
        } else {
            $(this).children(".giraEmudaCor").attr("style", "color: black; font-size: 1.5rem; transform: rotate(0deg);");
            $(this).children(".changeColor").attr("style", "color: black; font-size: 1.5rem");
            $(this).children(".animi").attr("style", "transform: rotate(0deg); color: black;");
            $(this).attr("x", "0");
        }
    });
try{
    if (interfaceAndroid != undefined) {
        $('.btSair').click(function () {
            $.ajax({url: '<?php echo $pontos ?>Controle/usuarioControle.php?function=eliminaToken'});
            interfaceAndroid.logOut();
        });
    }
    }catch (e){
        console.log("N é android...")
    }
</script>