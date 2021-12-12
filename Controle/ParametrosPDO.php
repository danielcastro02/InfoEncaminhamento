<?php
namespace TCC\Controle;

use Exception;
use TCC\Modelo\Parametros;

class ParametrosPDO extends PDOBase
{

    public function update()
    {
        $parametros = new Parametros();
        $parametros->atualizar($_POST);
        $parametros->save();
        echo "<script>javascript:history.go(-1);</script>";

    }

    function updateEmail(){
        $this->update();
    }


    function updateNotificacao()
    {
        $parametros = new Parametros();
        $parametros->atualizar($_POST);
        if (isset($_POST['envia_notificacao'])) {
            $parametros->setEnvia_notificacao(1);
        } else {
            $parametros->setEnvia_notificacao(0);
        }
        $parametros->save();
        echo "<script>javascript:history.go(-1);</script>";
    }

    function updateChat()
    {
        $parametros = new Parametros();
        $parametros->atualizar($_POST);
        if (isset($_POST['active_chat'])) {
            $parametros->setActiveChat(1);
        } else {
            $parametros->setActiveChat(0);
        }
        $parametros->save();
        echo "<script>javascript:history.go(-1);</script>";
    }

    function removeDestaque()
    {
        $parametros = new Parametros();
        $parametros->setDestaque_personalizado(0);
        $destaque = $parametros->getImagem_destaque();
        unlink("../" . $destaque);
        $parametros->setImagem_destaque("");
        $parametros->save();
        $this->addToast("Imagem destaque removida");
        header("Location: ../Tela/configuracoesAvancadas.php");
    }

    function updateGeral()
    {
        $parametros = new Parametros();
        $parametros->atualizar($_POST);
        $con = new Conexao();
        $horas = explode(":", $_POST['horasCancelamento']);
        $parametros->setTempo_cancelamento('P' . $_POST['diasCancelamento'] . "DT" . $horas[0] . 'H' . $horas[1] . 'M' . $horas[2] . 'S');
        $parametros->setConfirma_agendamento(isset($_POST['confirma_agendamento']) ? 1 : 0);
        $parametros->setCheckin(isset($_POST['checkin']) ? 1 : 0);
        $parametros->setConfirmaEmail(isset($_POST['confirma_email']) ? 1 : 0);
        $parametros->setSms((isset($_POST['sms']) ? 1 : 0));
        $parametros->save();
        header('location: ../Tela/configuracoesAvancadas.php?msg=parametrosAtualizados');
    }

    function updatePagamento()
    {
        $parametros = new Parametros();
        $parametros->atualizar($_POST);
        if (isset($_POST['ativa_pagamento'])) {
            $parametros->setAtiva_pagamento(1);
        } else {
            $parametros->setAtiva_pagamento(0);
        }
        $parametros->save();
        echo "<script>javascript:history.go(-1);</script>";
    }

    function updateQrLink()
    {
        $parametros = new Parametros();
        $parametros->atualizar($_POST);
        if ($_FILES['qr_app']['name'] != null) {
            $nomeImg = md5_file($_FILES['qr_app']['tmp_name']);
            $ext = explode('.', $_FILES['qr_app']['name']);
            $extensao = "." . $ext[(count($ext) - 1)];
            $extensao = strtolower($extensao);
            move_uploaded_file($_FILES['qr_app']['tmp_name'], "../Img/" . $nomeImg . $extensao);
            $parametros->setQrApp("/Img/" . $nomeImg . $extensao);
        }
        $parametros->save();
        header("location: ../Tela/configuracoesAvancadas.php");


    }

    public function alteraLogo()
    {
        if (filesize($_FILES['imagem']['tmp_name']) > 15000000) {
            $this->addToast("O tamanho máximo de arquivo é de 15MB");
            header("location: ../Tela/configuracoesAvancadas.php");
        } else {
            $fatorReducao = 6;
            $tamanho = filesize($_FILES['imagem']['tmp_name']);
            $qualidade = (100000000 - ($tamanho * $fatorReducao)) / 1000000;
            if ($qualidade < 5) {
                $qualidade = 5;
            }
            $parametros = new Parametros();
            $SendCadImg = filter_input(INPUT_POST, 'SendCadImg', FILTER_SANITIZE_STRING);
            //Receber os dados do formulÃ¡rio
            $antiga = $parametros->getLogo();
            $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
            $nome_imagem = hash_file('md5', $_FILES['imagem']['tmp_name']);
            //Inserir no BD
            $ext = explode('.', $_FILES['imagem']['name']);
            $extensao = "." . $ext[(count($ext) - 1)];
            $parametros->setIs_foto(1);
            $parametros->setLogo('Img/' . $nome_imagem . ($extensao == '.svg' ? ".svg" : ($extensao == ".gif" ? ".gif" : ".webp")));
            $parametros->save();
            switch ($extensao) {
                case '.jpeg':
                case '.jfif':
                case '.jpg':
                    imagewebp(imagecreatefromjpeg($_FILES['imagem']['tmp_name']), __DIR__ . '/../Img/' . $nome_imagem . '.webp', $qualidade);
                    break;
                case '.svg':
                    move_uploaded_file($_FILES['imagem']['tmp_name'], __DIR__ . '/../Img/' . $nome_imagem . '.svg');
                    break;
                case '.gif':
                    move_uploaded_file($_FILES['imagem']['tmp_name'], __DIR__ . '/../Img/' . $nome_imagem . '.gif');
                    break;
                case '.png':
                    $img = imagecreatefrompng($_FILES['imagem']['tmp_name']);
                    imagepalettetotruecolor($img);
                    imagewebp($img, __DIR__ . '/../Img/' . $nome_imagem . '.webp', $qualidade);
                    break;
                case '.webp':
                    imagewebp(imagecreatefromwebp($_FILES['imagem']['tmp_name']), __DIR__ . '/../Img/' . $nome_imagem . '.webp', $qualidade);
                    break;
                case '.bmp':
                    imagewebp(imagecreatefromwbmp($_FILES['imagem']['tmp_name']), __DIR__ . '/../Img/' . $nome_imagem . '.webp', $qualidade);
                    break;
            }
            //Verificar se os dados foram inseridos com sucesso
            if (realpath("../" . $antiga) && $antiga != $nome_imagem . ".webp") {
                header('Location: ../Tela/configuracoesAvancadas.php');
            }else{
                echo "deu ruim";
            }
        }
    }

    public
    function alteraDestaque()
    {
        if (filesize($_FILES['imagem']['tmp_name']) > 15000000) {
            $this->addToast("O tamanho máximo de arquivo é de 15MB");
            header("location: ../Tela/configuracoesAvancadas.php");
        } else {
            $fatorReducao = 2;
            $tamanho = filesize($_FILES['imagem']['tmp_name']);
            $qualidade = (100000000 - ($tamanho * $fatorReducao)) / 1000000;
            if ($qualidade < 5) {
                $qualidade = 5;
            }
            $parametros = new Parametros();
            $SendCadImg = filter_input(INPUT_POST, 'SendCadImg', FILTER_SANITIZE_STRING);
            //Receber os dados do formulÃ¡rio
            $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
            $nome_imagem = hash_file('md5', $_FILES['imagem']['tmp_name']);
            //Inserir no BD
            $ext = explode('.', $_FILES['imagem']['name']);
            $extensao = "." . $ext[(count($ext) - 1)];
            $extensao = strtolower($extensao);
            $conexao = new Conexao();
            $parametros->setImagem_destaque('Img/' . $nome_imagem . ($extensao == '.svg' ? ".svg" : ($extensao == ".gif" ? ".gif" : ".webp")));
            $parametros->setDestaque_personalizado(1);
            $parametros->save();
            //Verificar se os dados foram inseridos com sucesso
            //DiretÃ³rio onde o arquivo vai ser salvo
            $diretorio = '../Img/' . $nome_imagem . '.webp';
            try {
                switch ($extensao) {
                    case '.jpeg':
                    case '.jfif':
                    case '.jpg':
                        imagewebp(imagecreatefromjpeg($_FILES['imagem']['tmp_name']), __DIR__ . '/../Img/' . $nome_imagem . '.webp', $qualidade);
                        break;
                    case '.svg':
                        move_uploaded_file($_FILES['imagem']['tmp_name'], __DIR__ . '/../Img/' . $nome_imagem . '.svg');
                        break;
                    case '.gif':
                        move_uploaded_file($_FILES['imagem']['tmp_name'], __DIR__ . '/../Img/' . $nome_imagem . '.gif');
                        break;
                    case '.png':
                        $img = imagecreatefrompng($_FILES['imagem']['tmp_name']);
                        imagepalettetotruecolor($img);
                        imagewebp($img, __DIR__ . '/../Img/' . $nome_imagem . '.webp', $qualidade);
                        break;
                    case '.webp':
                        imagewebp(imagecreatefromwebp($_FILES['imagem']['tmp_name']), __DIR__ . '/../Img/' . $nome_imagem . '.webp', $qualidade);
                        break;
                    case '.bmp':
                        imagewebp(imagecreatefromwbmp($_FILES['imagem']['tmp_name']), __DIR__ . '/../Img/' . $nome_imagem . '.webp', $qualidade);
                        break;
                }
                header('Location: ../Tela/configuracoesAvancadas.php');
            } catch (Exception $e) {
                header('Location: ../Tela/configuracoesAvancadas.php?msg=erroImagem');
            }
        }
    }

    function updateAutenticacao()
    {
        $parametros = new Parametros();
        if (isset($_POST['metodo_autenticacao'])) {
            $parametros->setMetodoAutenticacao(1);
        } else {
            $parametros->setMetodoAutenticacao(2);
        }
        $parametros->save();
        header("location: ../Tela/configuracoesAvancadas.php");
    }

    public function removeLogo()
    {
        $parametros = new Parametros();
        unlink('../' . $parametros->getLogo());
        $parametros->setLogo("");
        $parametros->setIs_foto(0);
        $parametros->save();
        header('Location: ../Tela/configuracoesAvancadas.php');
    }

}
