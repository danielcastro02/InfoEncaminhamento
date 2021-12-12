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

use TCC\Modelo\Parametros;
use TCC\Modelo\Usuario;
$logado = new Usuario(unserialize($_SESSION['logado']));
?>
<style>
    header, main, footer, .preFooter {
        padding-left: 245px;
    }

    html {
        max-width: 100vw;
    }

    @media only screen and (max-width: 992px) {
        header, main, footer, .preFooter {
            padding-left: 0px;
        }
    }

    /*!*Muda a cor do icone do select na nav*!*/
    /*.select-wrapper .caret{*/
    /*    fill: #fff !important;*/
    /*}*/
    /*Muda a cor do que esta escrito dentro do campo selected*/
    .mudaCor .select-wrapper input.select-dropdown {
        color: white !important;
    }

    .alteraAlturaSelect .dropdown-content.select-dropdown {
        max-height: 267px;
    }
</style>
<div class="navbar-fixed evitarEstouro" style="max-height: 45px; max-width: 100%">
    <!--    <div class="hide-on-large-only" style="width: 100%; height: 15px; background-color: #d80800; color: white;">-->
    <!--        Esta entidade esta suspensa, você não poderá registrar nenhum dado.-->
    <!--    </div>-->
    <!--    <div class="hide-on-med-and-down" style="margin-left: 245px;line-height: 15px; font-size: 15px; height: 15px; background-color: #db6a21; color: white;">-->
    <!--        Esta entidade esta suspensa, você não poderá registrar nenhum dado.-->
    <!--    </div>-->
    <nav class="nav-extended evitarEstouro corPadrao2" style="max-height: 45px; max-width: 100vw !important">
        <a href="#" data-target="slide-out" class="sidenav-trigger" style="height: 45px;">
            <i class="material-icons white-text">menu</i>
        </a>
        <ul id="ulAesquerda" class="left">
            <li>
                <div class="input-field input-field-ajustes alteraAlturaSelect">
                </div>
            </li>
        </ul>

        <!--            ul com o a foto e nome de quem esta logado, tambem é um dropdown-->
        <ul class="right">
            <li>
                <div style="position: relative;">
                    <a href="#" class='dropdown-trigger black-text iconeFotoNav' data-target='dropPessoal'>
                        <div class="left-align diviComFotoPerfil fotoPerfil"
                             style="background-color: white ;background-image: url('<?php echo($logado->getIs_foto_url() == 1 ? $logado->getFoto() : $pontos . $logado->getFoto()); ?>');">
                        </div>
                    </a>
                </div>

                <!--                    O dropdown referente-->
                <ul id="dropPessoal" class="dropdown-content">
                    <li><a href="<?php echo $pontos; ?>Tela/perfil.php" class="black-text">Meu perfil</a></li>
                    <li class="divider" tabindex="-1"></li>
                    <li><a id="btnReporte" href="#!" class="black-text"><i class="material-icons left">support</i>Abrir
                            Chamado</a>
                    </li>
                    <li><a href="<?php echo $pontos . 'Tela/chamados.php' ?>" class="black-text"><i
                                    class="material-icons left">support</i> Meus chamados</a></li>
                    <li>
                        <a class="waves-effect black-text"
                           href="<?php echo $pontos ?>Controle/usuarioControle.php?function=logout">
                            <i class="material-icons black-text" style="font-size: 1.5rem">power_settings_new</i>
                            Sair
                        </a>
                    </li>
                </ul>

            </li>
        </ul>
    </nav>
</div>
<!--SidNavBar que deve se tornar padrão-->

<ul id="slide-out" class="sidenav sidenav-fixed">
    <li>
        <div style="background-color: #ffffff; max-height: 55px; max-width: 245px; overflow: hidden">
            <a href="<?php echo $pontos ?>index.php">
                <img class="" style="height: 55px; width: auto; padding-top: 4px; padding-left: 5px;" src="<?php echo $pontos ?>Img/logoIffar.png">
            </a>
        </div>
    </li>
    <li class="no-padding">
        <ul class="collapsible">
            <li class="destaque">
                <a class="destaqueLinha waves-effect black-text collapsible-header anime" x="0"
                   href="<?php echo $pontos ?>index.php">
                    <i class="material-icons changeColor" style="color: black; font-size: 1.5rem">home</i>
                    Inicio
                </a>
            </li>
            <li class="destaque">
                <a class="destaqueLinha waves-effect black-text collapsible-header anime" x="0"
                   href="<?php echo $pontos . 'Tela/pesquisa.php' ?>">
                    <i class="material-icons changeColor" style="color: black; font-size: 1.5rem">search</i>
                    Pesquisa
                </a>
            </li>

        </ul>
    </li>
    <li>
        <div class="divider"></div>
    </li>
    <!-- <li><a class="subheader">TCC todos os direitos reservados © 2020 FinanceirameneApp</a></li>-->
    <li class="linhaDobtSair hide">
        <a class="waves-effect black-text" href="<?php echo $pontos ?>Controle/usuarioControle.php?function=logout">
            <i class="material-icons black-text" style="font-size: 1.5rem">power_settings_new</i>
            Sair
        </a>
    </li>

</ul>

<script>
    <?php
    if(isset($_SESSION['entidade'])){
    ?>
    <?php
    }
    ?>
    $('.fixed-action-btn').floatingActionButton({
        hoverEnabled: false
    });

    $('.tooltippede').tooltip({
        position: 'left'
    });
    $('.selectNav').formSelect();
    $('.sidenav').sidenav();
    $('.collapsible').collapsible();

    $('.dropdown-trigger').dropdown({
        coverTrigger: false
    });
    <?php
    //if (($logado->getEmail() == null || "") && (!isset($_SESSION['ignore_null_mail']))) {
    //    echo "instanceASDF.open();";
    //    $_SESSION['ignore_null_mail'] = 'true';
    //}
    ?>
    $(".gira").click(function () {
        if ($(this).attr("x") == 0) {
            $(this).children(".soGira").attr("style", "transform: rotate(180deg)");
            $(this).attr("x", "1");
        } else {
            $(this).children(".soGira").attr("style", "transform: rotate(0deg)");
            $(this).attr("x", "0");
        }
    });

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

    // Faz a animação do floating btn
    $(".animacao").click(function () {
        if ($(this).attr("x") == 0) {
            $(this).attr("x", "0");
            $(".giraEmudaCorFloating").attr("style", "font-size: 1.5625rem; transform: rotate(0deg);");

            $(this).children(".giraEmudaCorFloating").attr("style", "font-size: 1.6625rem; transform: rotate(180deg);");
            $(this).attr("x", "1");
        } else {
            $(this).children(".giraEmudaCorFloating").attr("style", "font-size: 1.5625rem; transform: rotate(0deg);");
            $(this).attr("x", "0");
        }
    });

    try {
        if (interfaceAndroid != undefined) {
            $('.btSair').click(function () {
                $.ajax({url: '<?php echo $pontos ?>Controle/usuarioControle.php?function=eliminaToken'});
                interfaceAndroid.logOut();
            });
        }
    } catch (e) {
        // console.log("N é android...")
    }

</script>