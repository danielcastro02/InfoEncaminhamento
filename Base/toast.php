<?php
if (!isset($_SESSION)) {
    session_start();
}

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

if (isset($_SESSION['toast'])) {
    $cont = 1;
    foreach ($_SESSION['toast'] as $toast) {
        ?>
        <script>
            setTimeout(function () {
                addToast("<?= $toast ?>");
            }, (<?= $cont ?> ) * 500)
        </script>
        <?php
        $cont++;
        unset($_SESSION['toast']);
    }
}

?>
<script>
    $.ajax(
        {
            url: "<?php echo $pontos;?>Controle/PDOBaseControle.php?function=getToasts",
            type: "GET",
            success: function (data) {
                if (data.toasts) {
                    for (let i = 0; i < data.size; i++) {
                        setTimeout(function () {
                            addToast(data.texts[i]);
                        }, (i + 1) * 500)
                    }
                }
            }
        }
    );
</script>
