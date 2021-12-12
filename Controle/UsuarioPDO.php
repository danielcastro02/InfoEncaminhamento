<?php

namespace TCC\Controle;

use DateInterval;
use DateTime;
use TCC\Modelo\Endereco;
use TCC\Modelo\Notificacao;
use TCC\Modelo\Parametros;
use TCC\Modelo\Usuario;
use PDO;
use Ramsey\Uuid\Uuid;

class UsuarioPDO extends PDOBase
{
    /* inserir */

    function inserirUsuarioAdm()
    {
        $parametros = new Parametros();
        $usuario = new Usuario($_POST);
        $usuario->setSenha('');
        $usuario->setCpf("");
        if ($parametros->getMetodoAutenticacao() == 1) {
            $usuario->setTelefone("");
        } else {
            $usuario->setEmail("");
        }
        $usuario->setData_nasc('');
        $usuario->setPre_cadastro(1);
        if ($this->inserirUsuarioParametro($usuario)) {
            $this->addToast("Novo usuário cadastrado");
            header('location: ../Tela/listagemUsuario.php');
        } else {
            header('location: ../Tela/erroInterno.php');
        }
    }

    function jaEra30Dias($id_usuario)
    {
        $pdo = Conexao::getConexao();
        $stmt = $pdo->prepare("update usuario set novo_cadastro = 0 where id_usuario = :id_usuario");
        $stmt->bindValue(":id_usuario", $id_usuario);
        $stmt->execute();
        return true;
    }

    function registroUsuarioCompartilhamento($email)
    {
        $this->log("Entrou na função", 'logdousuariomaldito');
        $parametros = new Parametros();
        $notificacaoPDO = new NotificacaoPDO();
        $usuario = new Usuario();
        $pdo = Conexao::getConexao();
        $usuario->setSenha('');
        $usuario->setCpf("");
        if ($parametros->getMetodoAutenticacao() == 1) {
            $usuario->setTelefone("");
        }
//        else {
//            $usuario->setEmail('');
//        }
        $usuario->setEmail($email);
        $usuario->setData_nasc('');
        $usuario->setPre_cadastro(1);
        $stmt = $pdo->prepare("insert into usuario values(:id_usuario , '' , :senha , '' , :email , '' , '' , 'Img/Perfil/default.png' , '' ,'',default ,0, 1, 0, 1, 0, '', 0, 1, '', '', '', '', '', '', '' , 1 , 1, 1 , 0);");
        $senhamd5 = md5("");
        $this->log("1", "logdousuariomaldito");
        $stmt->bindValue(':id_usuario', Uuid::uuid4()->toString());
        $stmt->bindValue(':senha', $senhamd5);
        $stmt->bindValue(':email', $usuario->getEmail());
        if ($stmt->execute()) {
            $this->log("2", "logdousuariomaldito");

            $notificacaoPDO->novoUsuario($usuario);
//            if ($parametros->getMetodoAutenticacao() == 1) {
            $usuario = $this->selectUsuarioEmail($usuario->getEmail());
//            } else {
//                $usuario = $this->selectUsuarioTelefone($usuario->getTelefone());
//            }
            $usuario = new Usuario($usuario->fetch());
            return $usuario;
        } else {
            $this->log("3", "logdousuariomaldito");
            $this->log($email, "logdousuariomaldito");

            return false;
        }
    }

    function updatePagamento(Usuario $usuario)
    {
        $pdo = Conexao::getConexao();
        $stmt = $pdo->prepare("update usuario set
        cpf = :cpf,
        cep = :cep,
        rua = :rua,
        numero = :numero, 
        bairro = :bairro,
        complemento = :complemento,
        telefone = :telefone
        where id_usuario = :id_usuario");
        $stmt->bindValue(":cpf", $usuario->getCpf());
        $stmt->bindValue(":cep", $usuario->getCep());
        $stmt->bindValue(":rua", $usuario->getRua());
        $stmt->bindValue(":numero", $usuario->getNumero());
        $stmt->bindValue(":bairro", $usuario->getBairro());
        $stmt->bindValue(":complemento", $usuario->getComplemento());
        $stmt->bindValue(":telefone", $usuario->getTelefone());
        $stmt->bindValue(":id_usuario", $usuario->getId_usuario());
        $stmt->execute();

    }

    function inserirUsuarioCompletaCadastro()
    {
        $usuario = new Usuario($_POST);
        $usuario->setSenha($_POST['senha1']);
        if (filesize($_FILES['imagem']['tmp_name']) > 0) {
            if (filesize($_FILES['imagem']['tmp_name']) > 15000000) {
                $this->addToast("O tamanho máximo de arquivo é de 15MB");
                header("location: ../Tela/completaCadastro.php?id_usuario=" . $usuario->getId_usuario());
            } else {
                $nome_imagem = hash_file('md5', $_FILES['imagem']['tmp_name']);
                $ext = explode('.', $_FILES['imagem']['name']);
                $extensao = "." . $ext[(count($ext) - 1)];
                $extensao = strtolower($extensao);
                file_put_contents('./logodotipodafoto', $extensao);
                switch ($extensao) {
                    case '.jfif':
                    case '.jpeg':
                    case '.jpg':
                        imagewebp(imagecreatefromjpeg($_FILES['imagem']['tmp_name']), __DIR__ . '/../Img/Perfil/' . $nome_imagem . '.webp', 45);
                        break;
                    case '.svg':
                        move_uploaded_file($_FILES['imagem']['tmp_name'], __DIR__ . '/../Img/Perfil/' . $nome_imagem . '.svg');
                        break;
                    case '.png':
                        $img = imagecreatefrompng($_FILES['imagem']['tmp_name']);
                        imagepalettetotruecolor($img);
                        imagewebp($img, __DIR__ . '/../Img/Perfil/' . $nome_imagem . '.webp', 45);
                        break;
                    case '.webp':
                        imagewebp(imagecreatefromwebp($_FILES['imagem']['tmp_name']), __DIR__ . '/../Img/Perfil/' . $nome_imagem . '.webp', 45);
                        break;
                    case '.bmp':
                        imagewebp(imagecreatefromwbmp($_FILES['imagem']['tmp_name']), __DIR__ . '/../Img/Perfil/' . $nome_imagem . '.webp', 45);
                        break;
                }
                $usuario->setFoto('Img/Perfil/' . $nome_imagem . ($extensao == '.svg' ? ".svg" : ".webp"));
            }
        } else {
            $usuario->setFoto('Img/Perfil/default.png');
        }
        $parametros = new Parametros();
        $pdo = Conexao::getConexao();
        $stmt = $pdo->prepare("update usuario set nome = :nome, senha = :senha, cpf = :cpf, email = :email, telefone = :telefone, data_nasc = :data_nasc, foto = :foto, email_confirmado = 1, telefone_confirmado = :telefone_confirmado, administrador = 0, ativo = 1, pre_cadastro = 0 where id_usuario = :id_usuario;");
        $stmt->bindValue(":nome", $usuario->getNome());
        $stmt->bindValue(":senha", password_hash($usuario->getSenha(), PASSWORD_DEFAULT));
        $stmt->bindValue(":cpf", $usuario->getCpf());
        $stmt->bindValue(":email", $usuario->getEmail());
        $stmt->bindValue(":telefone", $usuario->getTelefone());
        $stmt->bindValue(":data_nasc", $usuario->getData_nasc());
        $stmt->bindValue(":foto", $usuario->getFoto());
        $stmt->bindValue(":telefone_confirmado", $parametros->getSms() == 1 ? 0 : 1);
        $stmt->bindValue(":id_usuario", $usuario->getId_usuario());
        if ($stmt->execute()) {
            $emailPDO = new EmailPDO();
            $emailPDO->novoUsuario($usuario);
            $emailPDO->emailBoasVindas($usuario);
            $stmt = $pdo->prepare("delete from codigoconfirmacao where id_usuario = :id_usuario and tipo = 'completa'");
            $stmt->bindValue(":id_usuario", $usuario->getId_usuario());
            $stmt->execute();
            $this->addToast("Seu cadastro foi completado com sucesso!");
//            echo $parametros->getSms();
            if ($parametros->getSms() == 0) {
                $_SESSION['logado'] = serialize($usuario);
                header("Location: ../index.php");
            } else {
                header("Location: ../Tela/codigoSMS.php");
            }
        }

    }

    function pesquisaMatricula($pesquisa)
    {
        $pdo = Conexao::getConexao();
        $stmt = $pdo->prepare("select * from usuario where ativo = 1 and deletado = 0 and (nome like :pesquisa or email like :pesquisa or telefone like :pesquisa)");
        $pesquisa = "%" . $pesquisa . "%";
        $stmt->bindValue(":pesquisa", $pesquisa);
        $stmt->bindValue(":pesquisa", $pesquisa);
        $stmt->bindValue(":pesquisa", $pesquisa);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }

    function inserirUsuario()
    {
        $usuario = new Usuario($_POST);
        $parametros = new Parametros();
        if ($usuario->getNome() == "" || $usuario->getNome() == null) {
            $this->addToast("Você precisa colocar seu nome!");
            header('location: ../Tela/registroUsuario.php');
            exit();
        }
        if ($usuario->getEmail() == "" || $usuario->getEmail() == null) {
            $this->addToast("Você precisa colocar seu E-mail!");
            header('location: ../Tela/registroUsuario.php');
            exit();
        }

        if (!strpos($usuario->getEmail(), "@iffarroupilha.edu.br")) {
            $this->addToast("Apenas professores do Iffar podem se cadastrar!");
            header('location: ../Tela/registroUsuario.php');
            exit();
        }

        if ($usuario->getTelefone() == "" || $usuario->getTelefone() == null) {
            $this->addToast("Você precisa colocar seu Telefone!");
            header('location: ../Tela/registroUsuario.php');
            exit();
        }

        if ($_POST['senha1'] == $_POST['senha2']) {
            $senhamd5 = password_hash($_POST['senha1'], PASSWORD_DEFAULT);
            $con = new Conexao();
            $pdo = $con->getConexao();

            //Caso o usuario ja tenha sido cadastrado ele vai ter que completar o cadastro
//                if ($this->verificaPreCadastroRegistro($usuario)) {
//                    header("Location: ../Tela/completaPorEmail.php");
//                    exit();
//                }

            $selectCpf = $this->selectUsuarioCpf($usuario->getCpf());
            if ($selectCpf && $usuario->getCpf() != '') {
                if ($selectCpf->rowCount() > 0) {
                    header('location: ../Tela/dadosJaCadastrados.php?msg=cpf');
                    exit();
                }
            }

            $selectTelefone = $this->selectUsuarioTelefone($usuario->getTelefone());
            if ($selectTelefone) {
                if ($selectTelefone->rowCount() > 0 && $usuario->getTelefone() != '') {
                    $usuario = new Usuario($selectTelefone->fetch());
                    $_SESSION['credencial'] = $usuario->getTelefone();
                    header('location: ../Tela/dadosJaCadastrados.php?msg=telefone');
                    exit();
                }
            }
            $selectEmail = $this->selectUsuarioEmail($usuario->getEmail());
            if ($selectEmail && $usuario->getEmail() != '') {
                if ($selectEmail->rowCount() > 0) {
                    $usuario = new Usuario($selectEmail->fetch());
                    if ($usuario->getPre_cadastro() == 0) {
                        $_SESSION['credencial'] = $usuario->getEmail();
                        header('location: ../Tela/dadosJaCadastrados.php?msg=email');
                        exit();
                    } else {
                        $usuarioInserido = new Usuario($_POST);
                        if ($_POST['senha1'] == $_POST['senha2']) {
                            $senhamd5 = password_hash($_POST['senha1'], PASSWORD_DEFAULT);
                            $stmt = $pdo->prepare("update usuario set senha = :senha, nome = :nome, telefone = :telefone, pre_cadastro = 0 where id_usuario = :id_usuario");
                            $stmt->bindValue(':nome', $usuarioInserido->getNome());
                            $stmt->bindValue(':senha', $senhamd5);
                            $stmt->bindValue(':id_usuario', $usuario->getId_usuario());
                            $stmt->bindValue(':telefone', "" . $usuarioInserido->getTelefone());
                            if ($stmt->execute()) {
                                $notificacaoPDO = new NotificacaoPDO();
                                if ($parametros->getMetodoAutenticacao() == 1) {
                                    $usuario = $this->selectUsuarioEmail($usuarioInserido->getEmail());
                                } else {
                                    $usuario = $this->selectUsuarioTelefone($usuarioInserido->getTelefone());
                                }
                                $usuario = new Usuario($usuario->fetch());
                                $notificacaoPDO->novoUsuario($usuario);
                                if ($parametros->getSms() == 1 && $parametros->getMetodoAutenticacao() == 2) {
                                    header('location: ../Tela/codigoSMS.php', TRUE);
                                    exit(0);
                                } else if ($parametros->getConfirmaEmail() == 1 && $parametros->getMetodoAutenticacao() == 1) {
                                    $emailPDO = new EmailPDO();
                                    $emailPDO->confirmaEmail($usuario->getEmail(), null, $usuario->getId_usuario());
                                    header('location: ../Tela/codigoEmail.php', TRUE);
                                    exit(0);
                                } else {
                                    $_SESSION['logado'] = serialize($usuario);
                                    header('location: ../index.php');
                                    exit(0);
                                }
                            } else {
                                header('location: ../Tela/login.php?msg=usuarioErroInsert');
                                exit(0);
                            }
                        }
                    }
                }
            }

            $stmt = $pdo->prepare("insert into usuario values(:id_usuario , :nome , :senha , :cpf , :email , :telefone , :data_nasc , 'Img/Perfil/default.png' , :token, :codigo_parceiro, default, :email_confirmado, :telefone_confirmado, 0, :ativo , 0 , '', 0 , 0 ,'', '', '', '', '', '', '' , 1 ,1 , 1 , 0);");
            $stmt->bindValue(':id_usuario', Uuid::uuid4()->toString());
            $stmt->bindValue(':nome', $usuario->getNome());
            $stmt->bindValue(':senha', $senhamd5);
            $stmt->bindValue(':cpf', $usuario->getCpf());
            $stmt->bindValue(':codigo_parceiro', $usuario->getCodigoParceiro());
            $stmt->bindValue(':email', $usuario->getEmail());
            $stmt->bindValue(':telefone', "" . $usuario->getTelefone());

            if ($parametros->getConfirmaEmail() == 1) {
                $stmt->bindValue(":email_confirmado", 0);
            } else {
                $stmt->bindValue(":email_confirmado", 1);
            }

            $stmt->bindValue(':telefone_confirmado', 1);

            if ($parametros->getConfirmaEmail() == 1 || $parametros->getSms() == 1) {
                $stmt->bindValue(":ativo", 0);
            } else {
                $stmt->bindValue(":ativo", 1);
            }


            if (isset($_POST['token'])) {
                $stmt->bindValue(":token", $usuario->getToken());
            } else {
                $stmt->bindValue(":token", "");
            }
            $stmt->bindValue(':data_nasc', $usuario->getData_banco());

            if ($stmt->execute()) {
                //                $this->enviaWats($usuario);
                $notificacaoPDO = new NotificacaoPDO();
                if ($parametros->getMetodoAutenticacao() == 1) {
                    $usuario = $this->selectUsuarioEmail($usuario->getEmail());
                } else {
                    $usuario = $this->selectUsuarioTelefone($usuario->getTelefone());
                }
                $usuario = new Usuario($usuario->fetch());
                $notificacaoPDO->novoUsuario($usuario);
                $emailPDO = new EmailPDO();
                $emailPDO->novoUsuario($usuario);

                if ($parametros->getConfirmaEmail() == 1 && $parametros->getMetodoAutenticacao() == 1) {
                    $emailPDO = new EmailPDO();
                    $emailPDO->confirmaEmail($usuario->getEmail(), null, $usuario->getId_usuario());
                    header('location: ../Tela/codigoEmail.php', TRUE);
                } else {
                    $_SESSION['logado'] = serialize($usuario);
                    header('location: ../index.php');
                }
            } else {
                header('location: ../index.php?msg=usuarioErroInsert');
            }
        } else {
            header('location: ../Tela/registroUsuario.php?msg=senhaerrada');
        }
    }

    function updateSetor()
    {
        $this->requerAdm();
        $pdo = Conexao::getConexao();
        $stmt = $pdo->prepare("update usuario set setor = :setor where id_usuario = :id_usuario");
        $stmt->bindValue(":id_usuario", $_POST["id_usuario"]);
        $stmt->bindValue(":setor", $_POST["setor"]);
        if ($stmt->execute()) {
            echo "true";
        } else {
            echo "Deu ruim";
        }
    }

    function selectToModal()
    {
        $pdo = Conexao::getConexao();
        $stmt = $pdo->prepare("select nome as nome, id_usuario as id from usuario where administrador < 2");
        $stmt->execute();
        $this->printJsonRaw($stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    function verificaPreCadastroRegistro(Usuario $usuario)
    {
        $pdo = Conexao::getConexao();
        $parametros = new Parametros();
        if ($parametros->getMetodoAutenticacao() == 1) {
            $stmt = $pdo->prepare("select * from usuario where email = :email and pre_cadastro = 1");
            $stmt->bindValue(":email", $usuario->getEmail());
        } else {
            $stmt = $pdo->prepare("select * from usuario where telefone = :telefone and pre_cadastro = 1");
            $stmt->bindValue(":telefone", $usuario->getTelefone());
        }
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function eliminaToken()
    {
        $pdo = Conexao::getConexao();
        $logado = new Usuario(unserialize($_SESSION['logado']));
        $stmt = $pdo->prepare("update usuario set token = '' where id_usuario = :id_usuario;");
        $stmt->bindValue(":id_usuario", $logado->getId_usuario());
        $stmt->execute();
        session_destroy();
        setcookie("user", '', time() + 1, '/', $_SERVER["HTTP_HOST"], true, true);
        setcookie("hashValidade", '', time() + 1, '/', $_SERVER["HTTP_HOST"], true, true);
    }

    function recuperaSenha()
    {
        $pesquisa = $_POST['usuario'];
        $con = new Conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare("select id_usuario, email from usuario where email like :email");
        $stmt->bindValue(":email", $pesquisa);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $usuario = new Usuario($stmt->fetch());
            $emailPDO = new EmailPDO();
            $emailPDO->recuperaSenha($usuario);
            header("location: ../Tela/codigoEmail.php?motivo=recuperacao");
        } else {
            header("location: ../Tela/recuperaSenha.php?msg=erro");
        }
    }

    function recuperaSenhaAPI()
    {
        $pesquisa = $_POST['usuario'];
        $con = new Conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare("select id_usuario, email from usuario where email like :email");
        $stmt->bindValue(":email", $pesquisa);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $usuario = new Usuario($stmt->fetch());
            $emailPDO = new EmailPDO();
            $emailPDO->recuperaSenha($usuario);
            echo('true');
        } else {
            echo('false');
        }
    }

    function getCpfId()
    {
        $con = new Conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select cpf, data_nasc, email from usuario where id_usuario = :id_usuario;');
        $stmt->bindValue(':id_usuario', $_GET['id_usuario']);
        $stmt->execute();
        $linha = $stmt->fetch();
        $usuario = new Usuario($linha);
        echo $usuario->getCpfPontuado() . ";" . $usuario->getData_nascBarras() . ';' . $usuario->getEmail();
    }

    function redefineSenha()
    {
        $con = new Conexao();
        $pdo = $con->getConexao();
        if ($_POST['senha1'] == $_POST['senha2']) {
            $novaSenha = password_hash($_POST['senha1'], PASSWORD_DEFAULT);
            $codigoConfirmacao = new CodigoconfirmacaoPDO();
            $id_usuario = $codigoConfirmacao->verificaCodigoRecuperaSenha($_POST['codigo'], $_POST['email']);
            if ($id_usuario) {
                $stmt = $pdo->prepare("update usuario set senha = :senha, email_confirmado = 1, ativo = 1 where id_usuario = :id_usuario;");
                $stmt->bindValue(":senha", $novaSenha);
                $stmt->bindValue(":id_usuario", $id_usuario);
                if ($stmt->execute()) {
                    $this->addToast("Senha redefinida!");
                    $usuario = new Usuario($this->selectUsuarioId_usuario($id_usuario)->fetch());
                    $_SESSION['logado'] = serialize($usuario);
                    header('location: ../Tela/login.php');
                } else {
                    $this->addToast("Troca de senha negada!");
                    $this->addToast("Tente recupera-la pelo email novamente");
                    header('location: ../Tela/login.php?msg=trocaNegada');
                }
            } else {
                $this->addToast("Troca de senha negada!");
                $this->addToast("Tente recupera-la pelo email novamente");
                header('location: ../Tela/login.php');
            }
        } else {
            $this->addToast("Senhas não coincidem!!");
            header('location: ../Tela/perfil.php?msg=senhasErradas');
        }
    }


    function verificaTelefone()
    {
        $usuario = new Usuario($_POST);
        $usuario->setTelefone(str_replace("(", "", $usuario->getTelefone()));
        $usuario->setTelefone(str_replace(" ", "", $usuario->getTelefone()));
        $usuario->setTelefone(str_replace(")", "", $usuario->getTelefone()));
        $usuario->setTelefone(str_replace("-", "", $usuario->getTelefone()));
        $selectTelefone = $this->selectUsuarioTelefone($usuario->getTelefone());
        if ($selectTelefone) {
            if ($selectTelefone->rowCount() > 0 && $usuario->getTelefone() != '') {
                echo 'true';
            } else {
                echo 'false';
            }
        } else {
            echo 'erro';
        }
    }

    function verificaEmailProfessor()
    {
        if (!strpos($_POST['email'], "@iffarroupilha.edu.br")) {
            echo 'true';
        } else {
            echo 'false';
        }
    }

    function verificaEmail()
    {
        if (isset($_SESSION['id_usuario'])) {
            $oCara = $this->selectUsuarioId_usuario($_SESSION['id_usuario']);
            $oCara = new Usuario($oCara->fetch());
            $selectTelefone = $this->selectUsuarioEmail($_POST['email']);
            if ($selectTelefone) {
                if ($selectTelefone->rowCount() > 0 && $_POST['email'] != '' && $_POST['email'] != $oCara->getEmail()) {
                    echo 'true';
                } else {
                    echo 'false';
                }
            } else {
                echo 'erro';
            }
        } else {
            echo 'erro';
        }
    }

    function inserirUsuarioParametro(Usuario $usuario, $senha1 = '', $senha2 = '')
    {
        $notificacaoPDO = new NotificacaoPDO();
        $parametros = new Parametros();

        if ($senha1 == $senha2) {
            $senhamd5 = password_hash($senha1, PASSWORD_DEFAULT);
            $pdo = Conexao::getConexao();
            $stmt = $pdo->prepare("insert into usuario values(:id_usuario , '' , :senha , :cpf , :email , :telefone , :data_nasc , 'Img/Perfil/default.png' , '' ,default ,:email_confirmado, 1, 0, 1, 0, '', 0, :preCadastro, '', '', '', '', '', '', '' , 1 ,1, 1 , 0);");
            $stmt->bindValue(':id_usuario', Uuid::uuid4()->toString());
            $stmt->bindValue(':senha', $senhamd5);
            $stmt->bindValue(':preCadastro', 1);
            $stmt->bindValue(':cpf', "" . $usuario->getCpf());
            $stmt->bindValue(':email', $usuario->getEmail());
            $stmt->bindValue(':telefone', "" . $usuario->getTelefone());
            $stmt->bindValue(':data_nasc', '2019-02-15');
            if ($parametros->getMetodoAutenticacao() == 1) {
                $stmt->bindValue(':email_confirmado', 0);
            } else {
                $stmt->bindValue(':email_confirmado', 1);
            }

            if ($stmt->execute()) {
                $notificacaoPDO->novoUsuario($usuario);
                if ($parametros->getMetodoAutenticacao() == 1) {
                    $usuario = $this->selectUsuarioEmail($usuario->getEmail());
                } else {
                    $usuario = $this->selectUsuarioTelefone($usuario->getTelefone());
                }
                $usuario = new Usuario($usuario->fetch());
                if ($parametros->getMetodoAutenticacao() == 1) {
                    $emailPDO = new EmailPDO();
                    $emailPDO->completaCadastro($usuario);
                } else {
                    //TODO Colocar algo pro sms caso o sms esteja ativo
                }
                return $usuario->getId_usuario();
            } else {
                return false;
            }
        } else {
            return "senhas";
        }
    }

    public function reenviaEmail()
    {
        $usuario = $this->selectUsuarioId_usuario($_SESSION['id_usuario']);
        unset($_SESSION['id_usuario']);
        $usuario = new Usuario($usuario->fetch());
        $emailPDO = new EmailPDO();
        $pdo = Conexao::getConexao();
        $stmt = $pdo->prepare("select codigo from codigoconfirmacao where id_usuario = :id_usuario and tipo = 'email'");
        $stmt->bindValue(':id_usuario', $usuario->getId_usuario());
        $stmt->execute();
        $linha = $stmt->fetch();
        $codigo = $linha[0];
        $emailPDO->confirmaEmail($usuario->getEmail(), $codigo, $usuario->getId_usuario());
        header('location: ../Tela/codigoEmail.php');
    }

    function codigoConfirmaRecuperaSenha()
    {
        $codigo = $_POST['codigo'];
        $id_usuario = $_SESSION['id_usuario'];
        $pdo = Conexao::getConexao();
        $stmt = $pdo->prepare("Select id_usuario from codigoconfirmacao where codigo = :codigo and tipo = 'recuperaSenha' and id_usuario = :id_usuario;");
        $stmt->bindValue(":codigo", $codigo);
        $stmt->bindValue(":id_usuario", $id_usuario);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $usuario = $this->selectUsuarioId_usuario($id_usuario);
            $usuario = new Usuario($usuario->fetch());
            header("location: ../Tela/redefineSenha.php?codigo=" . $codigo . "&email=" . $usuario->getEmail());
        }
    }

    function recuperaSenhaApp()
    {
        $pesquisa = $_POST['usuario'];
        $con = new Conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare("select id_usuario, token from usuario where email like :email");
        $stmt->bindValue(":email", $pesquisa);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $usuario = new Usuario($stmt->fetch());
            $codigo = mt_rand(1000, 99999);
            $pdo = Conexao::getConexao();
            $stmt = $pdo->prepare("insert into codigoconfirmacao values (default, :id_usuario , :codigo, 'recuperaSenha');");
            $stmt->bindValue(':id_usuario', $usuario->getId_usuario());
            $stmt->bindValue(':codigo', $codigo);
            $stmt->execute();
            $notificacao = new Notificacao();
            $notificacao->setDestinatario($usuario->getToken(), $usuario->getId_usuario());
            $notificacao->setTitle("Seu códio!");
            $notificacao->setBody($codigo . " Se você não solicitou este código entre em contato com contato@markeyvip.com.");
            $notificacao->send(true);
            $_SESSION['id_usuario'] = $usuario->getId_usuario();
            $this->addToast("Verifique as notificações do seu app!");
            header("location: ../Tela/codigoApp.php");
        } else {
            $this->addToast("Nenhum aplicativo esta associado a esta conta!");
            header("location: ../Tela/recuperaSenha.php?msg=erro");
        }
    }


    function selectUsuarioHasToken()
    {
        $pdo = Conexao::getConexao();
        $stmt = $pdo->prepare("select * from usuario where token != '' and token != 'null' and deletado = 0");
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }

    public
    function confirmaCadastro()
    {
        $con = new Conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('update usuario set ativo = 1, telefone_confirmado = 1 where id_usuario in ('
            . 'select id_usuario '
            . 'from codigoconfirmacao '
            . 'where codigo = :codigo) ;');
        $stmt->bindValue(":codigo", $_POST['codigo']);
        $stmt->execute();
        $stmt = $pdo->prepare("select * from usuario where id_usuario in (select id_usuario from codigoconfirmacao where codigo = :codigo);");
        $stmt->bindValue(":codigo", $_POST['codigo']);
        $stmt->execute();
        $usuario = new Usuario($stmt->fetch());
        $stmtDelete = $pdo->prepare('delete from codigoconfirmacao where codigo = :codigo;');
        $stmtDelete->bindValue(":codigo", $_POST['codigo']);
        if ($stmtDelete->execute()) {
            if (isset($_GET['semSenha'])) {
                $stmt = $pdo->prepare("update usuario set pre_cadastro = 0 where id_usuario = :id_usuario;");
                $stmtDelete->bindValue(":id_usuario", $usuario->getId_usuario());
                $stmt->execute();
                header("location: ../Tela/redefineSenha.php?primeiraSenha=1&codigo=" . $usuario->getId_usuario());
            } else {
                header('location: ../Tela/login.php');
            }
        } else {
            header("location: ../Tela/erroInterno.php?c");
        }
    }

    function confirmaEmail()
    {
        $cod = $_GET['codigo'];
        $con = new Conexao();
        $pdo = $con->getConexao();
        $usuario = $pdo->prepare("select * from usuario where id_usuario in (select id_usuario from codigoconfirmacao where codigo = :codigo)");
        $usuario->bindValue(":codigo", $cod);
        $usuario->execute();
        if ($usuario->rowCount() > 0) {
            $usuario = new Usuario($usuario->fetch());
            $stmt = $pdo->prepare('update usuario set ativo = 1 , email_confirmado = 1 where id_usuario in (select id_usuario from codigoconfirmacao where codigo = :codigo) ;');
            $stmt->bindValue(":codigo", $cod);
            if ($stmt->execute()) {
                $stmtDelete = $pdo->prepare('delete from codigoconfirmacao where codigo = :codigo;');
                $stmtDelete->bindValue(":codigo", $cod);
                if ($stmtDelete->execute()) {
                    $this->addToast("Seu email foi confirmado!");
                    $this->addToast("Entre para continuar...");
                    header('location: ../Tela/login.php');
                } else {
                    header('location: ../Tela/erroInterno.php');
                }
            } else {
                header('location: ../Tela/erroInterno.php?msg=Eroo');
            }
        } else {
            $this->addToast("Você já confirmou o seu email.");
            header('location: ../Tela/login.php');
        }
    }

    public
    function updateEmail()
    {
        $usuario = new Usuario($_POST);
        $usuario->setId_usuario($_SESSION['id_usuario']);
        $con = new Conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('update usuario set email = :email , email_confirmado = 0 where id_usuario = :id_usuario ;');
        $stmt->bindValue(":email", $usuario->getEmail());
        $stmt->bindValue(":id_usuario", $usuario->getId_usuario());
        $stmt->execute();
        $codigo = mt_rand(1000, 99999);
        $pdo = Conexao::getConexao();
        $stmt = $pdo->prepare("insert into codigoconfirmacao values (default, :id_usuario , :codigo , 'email');");
        $stmt->bindValue(':id_usuario', $usuario->getId_usuario());
        $stmt->bindValue(':codigo', $codigo);
        if (!$stmt->execute()) {
            header("location: ../Tela/erroInterno.php?insertCodigo");
            exit(0);
        } else {
            $emailPDO = new EmailPDO();
            $emailPDO->confirmaEmail($usuario->getEmail(), $codigo);
            header('location: ../Tela/codigoEmail.php');
        }
    }

    public
    function updateTelefone()
    {
        $usuario = new Usuario($_POST);
        $con = new Conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('update usuario set telefone = :telefone , telefone_confirmado = 0 where id_usuario = :id_usuario ;');
        $stmt->bindValue(":telefone", $usuario->getTelefone());
        $stmt->bindValue(":id_usuario", $usuario->getId_usuario());
        $stmt->execute();
        $codigo = mt_rand(1000, 99999);
        $pdo = Conexao::getConexao();
        $stmt = $pdo->prepare("insert into codigoconfirmacao values (default, :id_usuario , :codigo , 'telefone');");
        $stmt->bindValue(':id_usuario', $usuario->getId_usuario());
        $stmt->bindValue(':codigo', $codigo);
        if (!$stmt->execute()) {
            header("location: ../Tela/erroInterno.php?insertCodigo");
            exit(0);
        } else {
            header('location: ../Tela/codigoSMS.php');
        }
    }

    public
    function selectUsuario()
    {

        $con = new Conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from usuario order by nome;');
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }

    public
    function selectUsuarioId_usuario($id_usuario)
    {
        $con = new Conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from usuario where id_usuario = :id_usuario;');
        $stmt->bindValue(':id_usuario', $id_usuario);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }

    function selectUsuarioPublicId_usuario($id_usuario)
    {
        $con = new Conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select nome , email from usuario where id_usuario = :id_usuario;');
        $stmt->bindValue(':id_usuario', $id_usuario);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }

    public
    function selectUsuarioNome($nome)
    {
        $nome = "%" . $nome . "%";
        $con = new Conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from usuario where nome like :nome and deletado = 0;');
        $stmt->bindValue(':nome', $nome);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }

    public
    function pesquisaListagem($nome)
    {
        $nome = "%" . $nome . "%";
        $con = new Conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from usuario where (nome like :nome or telefone like :telefone or email like :email) and deletado = 0 ORDER BY nome;');
        $stmt->bindValue(':nome', $nome);
        $stmt->bindValue(':telefone', $nome);
        $stmt->bindValue(':email', $nome);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }

    public
    function selectUsuarioSenha($senha)
    {

        $con = new Conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from usuario where senha = :senha;');
        $stmt->bindValue(':senha', $senha);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }

    public
    function selectUsuarioCpf($cpf)
    {
        $con = new Conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from usuario where cpf = :cpf;');
        $stmt->bindValue(':cpf', $cpf);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }

    public
    function selectUsuarioEmail($email)
    {
        $con = new Conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from usuario where email = :email;');
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }

    public
    function selectUsuarioTelefone($telefone)
    {

        $con = new Conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from usuario where telefone = :telefone;');
        $stmt->bindValue(':telefone', $telefone);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }

    public
    function selectNome($id_usuario)
    {
        $con = new Conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select nome from usuario where id_usuario = :id_usuario;');
        $stmt->bindValue(':id_usuario', $id_usuario);
        $stmt->execute();
        while ($linha = $stmt->fetch()) {
            $usuario = new Usuario($linha);
        }
        return $usuario->getNome();
    }

    public
    function selectUsuarioDdata_nasc($ddata_nasc)
    {

        $con = new Conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from usuario where data_nasc = :ddata_nasc;');
        $stmt->bindValue(':ddata_nasc', $ddata_nasc);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }

    public
    function selectUsuarioFoto($foto)
    {

        $con = new Conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from usuario where foto = :foto;');
        $stmt->bindValue(':foto', $foto);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }

    public
    function selectUsuarioToken($token): Usuario
    {

        $con = new Conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from usuario where token = :foto;');
        $stmt->bindValue(':foto', $token);
        $stmt->execute();
        return new Usuario($stmt->fetch());
    }

    public
    function selectUsuarioAdministrador($administrador)
    {

        $con = new Conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from usuario where administrador = :administrador or administrador = 2;');
        $stmt->bindValue(':administrador', $administrador);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }


    public
    function selectUsuarioAtivo($ativo)
    {

        $con = new Conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from usuario where ativo = :ativo;');
        $stmt->bindValue(':ativo', $ativo);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt;
        } else {
            return false;
        }
    }

    public
    function updateSenha()
    {
        $logado = $this->getLogado();
        $con = new Conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('select * from usuario where id_usuario = :id_usuario');
        $stmt->bindValue(':id_usuario', $logado->getId_usuario());
        $stmt->execute();
        $logado = new Usuario($stmt->fetch());
        if ($_POST['senha1'] == $_POST['senha2']) {
            $novaSenha = password_hash($_POST['senha1'], PASSWORD_DEFAULT);
            if (password_verify($_POST['oldSenha'], $logado->getSenha()) || ($_POST['oldSenha'] == "" && $logado->getSenha() == "")) {
                $stmt = $pdo->prepare("update usuario set senha = :senha where id_usuario = :id_usuario;");
                $stmt->bindValue(":senha", $novaSenha);
                $stmt->bindValue(":id_usuario", $logado->getId_usuario());
                $stmt->execute();
                header('location: ../Tela/perfil.php?msg=senhaAlterada');
            } else {
                $this->addToast('Sua senha antiga não corresponde');
                header('location: ../Tela/perfil.php?msg=errouOld');
            }
        } else {
            header('location: ../Tela/perfil.php?msg=senhasErradas');
        }
    }

    public
    function updateUsuario()
    {
        $usuario = new Usuario($_POST);
        $logado = $this->getLogado();
        $usuarioAnterior = $this->selectUsuarioId_usuario($logado->getId_usuario());
        $usuarioAnterior = new Usuario($usuarioAnterior->fetch());
        $selectCpf = $this->selectUsuarioCpf($usuario->getCpf());
        if ($selectCpf && $usuario->getCpf() != '') {
            if ($selectCpf->rowCount() > 0) {
                $usuarioTeste = new Usuario($selectCpf->fetch());
                if ($usuarioTeste->getId_usuario() != $usuarioAnterior->getId_usuario()) {
                    header('location: ../Tela/dadosJaCadastrados.php?msg=cpf&update=1');
                    exit();
                }
            }
        }
        $selectTelefone = $this->selectUsuarioTelefone($usuario->getTelefone());
        if ($selectTelefone) {
            if ($selectTelefone->rowCount() > 0 && $usuario->getTelefone() != '') {
                $usuarioTeste = new Usuario($selectTelefone->fetch());
                if ($usuarioTeste->getId_usuario() != $usuarioAnterior->getId_usuario()) {
                    header('location: ../Tela/dadosJaCadastrados.php?msg=telefone&update=1');
                    exit();
                }
            }
        }
        $selectEmail = $this->selectUsuarioEmail($usuario->getEmail());
        if ($selectEmail && $usuario->getEmail() != '') {
            if ($selectEmail->rowCount() > 0) {
                $usuarioTeste = new Usuario($selectEmail->fetch());
                if ($usuarioTeste->getId_usuario() != $usuarioAnterior->getId_usuario()) {
                    header('location: ../Tela/dadosJaCadastrados.php?msg=email&update=1');
                    exit();
                }
            }
        }
        $con = new Conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('update usuario set nome = :nome , cpf = :cpf , email = :email , telefone = :telefone , data_nasc = :data_nasc , ativo = :ativo , email_confirmado = :email_confirmado , '
            . 'telefone_confirmado = :telefone_confirmado where id_usuario = :id_usuario;');
        $stmt->bindValue(':nome', $usuario->getNome());

        $stmt->bindValue(':cpf', $usuario->getCpf());

        $stmt->bindValue(':email', $usuario->getEmail());

        $stmt->bindValue(':telefone', $usuario->getTelefone());

        $stmt->bindValue(':data_nasc', $usuario->getData_banco());


        $verificaEmail = false;
        $verificaTelefone = false;
        $parametros = new Parametros();
        if ($parametros->getConfirmaEmail() == 1) {
            if ($usuario->getEmail() != $logado->getEmail() && $usuario->getEmail() != "") {

                $_SESSION['id_usuario'] = $logado->getId_usuario();
                $verificaEmail = true;
            }
        }
        if ($parametros->getSms() == 1) {
            if ($usuario->getTelefone() != $logado->getTelefone()) {

                $_SESSION['id_usuario'] = $logado->getId_usuario();
                $verificaTelefone = true;
            }
        }
        if (!$verificaEmail && !$verificaTelefone) {
            $stmt->bindValue(':ativo', 1);
            $stmt->bindValue(':email_confirmado', 1);
            $stmt->bindValue(':telefone_confirmado', 1);
        } else {
            if ($verificaEmail) {

                $stmt->bindValue(':email_confirmado', 0);
            } else {
                $stmt->bindValue(':email_confirmado', 1);
            }
            if ($verificaTelefone) {
                $stmt->bindValue(':telefone_confirmado', 0);
            } else {
                $stmt->bindValue(':telefone_confirmado', 1);
            }
            $stmt->bindValue(':ativo', 0);
        }

        $stmt->bindValue(':id_usuario', $logado->getId_usuario());

        if ($verificaEmail) {
            $emailPDO = new EmailPDO();
            $emailPDO->confirmaEmail($usuario->getEmail(), null, $logado->getId_usuario());
            session_write_close();
            session_start();
            session_destroy();
            setcookie("user", '', time() + 1, '/');
            setcookie("user", '', time() + 1, '/', $_SERVER["HTTP_HOST"], true, true);
            setcookie("ent", '', time() + 1, '/');
            setcookie("ent", '', time() + 1, '/', $_SERVER["HTTP_HOST"], true, true);
            setcookie("hashValidade", '', time() + 1, '/');
            setcookie("hashValidade", '', time() + 1, '/', $_SERVER["HTTP_HOST"], true, true);
            if ($verificaTelefone) {
                header('location: ../Tela/codigoSMS.php?msg=emailAlterado');
            } else {
                header('location: ../Tela/codigoEmail.php');
            }
        } else {
            if ($verificaTelefone) {
                session_destroy();
                setcookie("user", '', time() + 1, '/');
                setcookie("hashValidade", '', time() + 1, '/');
                header('location: ../Tela/codigoSMS.php');
                $stmt->execute();
                exit(0);
            }
            $stmt->execute();
            $usuario->setFoto($logado->getFoto());
            $usuario->setAdministrador($logado->getAdministrador());
            $logado->atualizar($_POST);
            $this->addToast('Dados alterados');
            header('location: ../Tela/perfil.php');
        }
        if (!$stmt->execute()) {
            header("location: ../Tela/erroInterno.php?msg=erroInsert");
        }
    }

    public
    function updateUsuarioDataNascCpf(Usuario $usuario)
    {
        $con = new Conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('update usuario set  cpf = :cpf , data_nasc = :data_nasc , email = :email where id_usuario = :id_usuario;');
        $stmt->bindValue(':cpf', $usuario->getCpf());
        $stmt->bindValue(':email', $usuario->getEmail());
        $stmt->bindValue(':data_nasc', $usuario->getData_banco());
        $stmt->bindValue(':id_usuario', $usuario->getId_usuario());
        return $stmt->execute();
    }

    public
    function deleteUsuario($definir)
    {
        $con = new Conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('update usuario set deletado = 1 where id_usuario = :definir ;');
        $stmt->bindValue(':definir', $definir);
        $stmt->execute();
        return $stmt->rowCount();
    }

    function deletar()
    {
        $logado = $this->getLogado();
        if ($logado->getAdministrador() == 0) {
            $this->addToast('Nível de administrador necessário!');
        } else {
            $this->deleteUsuario($_GET['id']);
            $this->addToast('Cliente excluído');
        }
        header('location: ../Tela/listagemUsuario.php');
    }


    /* login */
    function loginAppFace()
    {
        $id_face = $_GET['facebook_id'];
        $pdo = Conexao::getConexao();
        $stmt = $pdo->prepare("select * from usuario where facebook_id = :id");
        $stmt->bindValue(":id", $id_face);
        $stmt->execute();
        $usuario = new Usuario($stmt->fetch());
        $_SESSION['logado'] = serialize($usuario);
        header("location: ../index.php");
    }

//Bloco de funções do Login
    protected
    function compatibilidadeLogin()
    {
        if (isset($_GET['us'])) {
            if ($_GET['us'] == "") {
                echo 'erroSenha';
            }
            $_POST['usuario'] = $_GET['us'];
            $_POST['senha'] = $_GET['ps'];
            if ($_GET['url'] != "null") {
                $_POST['url'] = $_GET['url'];
            }
        }
        if (isset($_GET['url'])) {
            $_POST['url'] = $_GET['url'];
        }
    }

    protected
    function validacaoFormularioLogin()
    {
        if (isset($_POST['usuario'])) {
            if ($_POST['usuario'] == "") {
                return false;
            }
        } else {
            return false;
        }
        $_POST['usuario'] = str_replace("(", "", $_POST['usuario']);
        $_POST['usuario'] = str_replace(" ", "", $_POST['usuario']);
        $_POST['usuario'] = str_replace(")", "", $_POST['usuario']);
        $_POST['usuario'] = str_replace("-", "", $_POST['usuario']);
        return true;
    }

    protected
    function selectLogin()
    {
        $pdo = Conexao::getConexao();
        $stmt = $pdo->prepare("SELECT * FROM usuario WHERE email like :email or telefone = :telefone and senha <> ''");
        $stmt->bindValue(":email", "%" . $_POST['usuario'] . "%");
        $stmt->bindValue(":telefone", $_POST['usuario']);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $linha = $stmt->fetch();
            $usuario = new Usuario($linha);
            return $usuario;
        } else {
            return null;
        }
    }

    function disableReceberEmail()
    {
        $pdo = Conexao::getConexao();
        $stmt = $pdo->prepare("update usuario set receber_email = :receber where id_usuario = :id_usuario");
        $stmt->bindValue(":receber", $_GET['alter']);
        $stmt->bindValue(":id_usuario", $this->getLogado()->getId_usuario());
        $stmt->execute();
        $logado = $this->getLogado();
        $logado->setReceberEmail($_GET['alter']);
        $_SESSION['logado'] = serialize($logado);
    }

    function disableReceberEmailSistema()
    {
        $pdo = Conexao::getConexao();
        $stmt = $pdo->prepare("update usuario set receber_email_sistema = :receber where id_usuario = :id_usuario");
        $stmt->bindValue(":receber", $_GET['alter']);
        $stmt->bindValue(":id_usuario", $this->getLogado()->getId_usuario());
        $stmt->execute();
        $logado = $this->getLogado();
        $logado->setReceberEmailSistema($_GET['alter']);
        $_SESSION['logado'] = serialize($logado);
    }

    protected
    function verificaDados(Usuario $usuario)
    {
        $parametros = new Parametros();
        if ($parametros->getConfirmaEmail() == 1) {
            if ($usuario->getEmail_confirmado() == 0 || $usuario->getTelefone_confirmado() == 0) {
                $_SESSION['id_usuario'] = $usuario->getId_usuario();
                $email = ($usuario->getEmail_confirmado());
                if ($email == 0) {
                    return ('location: ../Tela/dadosNaoConfirmados.php?email=' . $email);
                } else {
                    return 'true';
                }
            }
        }
        return "true";
    }

    protected
    function verificaPreCadastro(Usuario $usuario)
    {
        if ($usuario->getPre_cadastro() == 0) {
            return true;
        } else {
            session_destroy();
            return false;
        }
    }

    protected
    function verificaDeletado(Usuario $usuario)
    {
        if ($usuario->getDeletado() == 0) {
            return true;
        } else {
            return false;
        }
    }

    protected
    function verificaAtivo(Usuario $usuario)
    {
        if ($usuario->getAtivo() == 1) {
            return true;
        } else {
            return false;

        }
    }

    function updateSenhaNewHash($senha, Usuario $usuario)
    {
        $pdo = Conexao::getConexao();
        $stmt = $pdo->prepare("update usuario set senha = :senha where id_usuario = :id_usuario");
        $stmt->bindValue(":senha", password_hash($senha, PASSWORD_DEFAULT));
        $stmt->bindValue(":id_usuario", $usuario->getId_usuario());
        $stmt->execute();
    }

    protected
    function verificaStatus(Usuario $usuario)
    {
        $senha = $_POST['senha'];
        $testeSenha = false;
        if (!password_verify($senha, $usuario->getSenha())) {
            if (md5($senha) == $usuario->getSenha() && $usuario->getSenha() != md5("")) {
                $this->updateSenhaNewHash($senha, $usuario);
                $testeSenha = true;
            }
        } else {
            $testeSenha = true;
        }
        return ($testeSenha && $usuario->getPre_cadastro() == 0 && $usuario->getSenha() != md5(""));
    }

    function loginByCookie()
    {
        $usuario = $this->selectUsuarioId_usuario($_COOKIE['user']);

        if ($usuario) {
            if (md5($_SERVER['REMOTE_ADDR']) == $_COOKIE['hashValidade']) {
                $usuario = new Usuario($usuario->fetch());
                $this->defineCookieAndSession($usuario);
                $this->log("Login realizado - " . $usuario->getNome(), "logados.txt");

            } else {
                session_destroy();
                setcookie("user", '', time() + 1, '/');
                setcookie("user", '', time() + 1, '/', $_SERVER["HTTP_HOST"], true, true);
                setcookie("ent", '', time() + 1, '/');
                setcookie("ent", '', time() + 1, '/', $_SERVER["HTTP_HOST"], true, true);
                setcookie("hashValidade", '', time() + 1, '/');
                setcookie("hashValidade", '', time() + 1, '/', $_SERVER["HTTP_HOST"], true, true);
            }
            if (isset($_GET['url'])) {
                header('location: ..' . $_GET['url']);
            } else {
                header("Location: ../index.php?logado=true");
            }
        } else {
            $this->logout();
        }
    }

    protected
    function defineCookieAndSession(Usuario $usuario)
    {
        session_write_close();
        ini_set('session.gc_maxlifetime', (3600 * 300));

// each client should remember their session id for EXACTLY 1 hour
        session_set_cookie_params(3600 * 300);
        session_start();
        $_SESSION['logado'] = serialize($usuario);
        $parametros = new Parametros();
        setcookie("user", $usuario->getId_usuario(), time() + (365 * 24 * 60 * 60), "/", $_SERVER["HTTP_HOST"], true, true);
        setcookie("hashValidade", md5($_SERVER['REMOTE_ADDR']), time() + (365 * 24 * 60 * 60), "/", $_SERVER["HTTP_HOST"], true, true);
//        setcookie("hashValidade", 'oedifrngjvwpegr', time() + (365 * 24 * 60 * 60), "/",  $_SERVER["HTTP_HOST"]);
    }


    function prabugar()
    {

        $this->addToast("destruiu");

        session_destroy();
    }

//Fim do bloco de funções do login

    function login()
    {
        $token = '';
        if (isset($_POST['token'])) {
            $token = $_POST['token'];
        }
        $parametros = new Parametros();
        //Para fins de compatibilidade, testar futuramente a possível remoção
        $this->compatibilidadeLogin();
        //Fim do bloco
        if ($this->validacaoFormularioLogin()) {
            $senha = $_POST['senha'];
            $usuario = $this->selectLogin();
            if ($usuario != null) {
                //Caso o usuario ja tenha sido cadastrado ele vai ter que completar o cadastro
                if ($this->verificaPreCadastroRegistro($usuario)) {
                    header("Location: ../Tela/completaPorEmail.php?local2");
                    exit();
                }
                if ($this->verificaStatus($usuario)) {
                    $dados = $this->verificaDados($usuario);
                    if ($dados == "true") {
                        if ($this->verificaAtivo($usuario)) {
                            if ($this->verificaDeletado($usuario)) {
                                if ($this->verificaPreCadastro($usuario)) {
                                    $this->log("Login realizado - " . $usuario->getNome(), "logados.txt");
                                    $this->defineCookieAndSession($usuario);
                                    if (isset($_POST['token'])) {
                                        $token = $_POST['token'];
                                        $this->updateToken($usuario->getId_usuario(), $_POST['token']);
                                    }
                                    if (isset($_POST['url'])) {
                                        header('location: ../' . $_POST['url']);
                                    } else {
                                        header("Location: ../index.php?logado=true");
                                    }

                                } else {
                                    session_start();
                                    $_SESSION['id_usuario_correcao'] = $usuario->getId_usuario();
                                    header('location: ../Tela/redefineSenha.php?primeiraSenha=1&primeiro&codigo=' . $usuario->getId_usuario());
                                    session_write_close();
                                    exit(0);
                                }
                            } else {
                                header('location: ../Tela/usuarioDeletado.php?id_usuario=' . $usuario->getId_usuario());
                                exit();
                            }
                        } else {
                            $_SESSION['id_usuario'] = $usuario->getId_usuario();
                            header('location: ../Tela/confirmaCadastro.php');
                        }
                    } else {
                        header($dados);
                        exit(0);
                    }
                } else {
                    if (!password_verify($senha, $usuario->getSenha())) {
                        header("Location: ../Tela/login.php?msg=erro&token=" . $token);
                    } else {
                        if ($parametros->getSms() == 0) {
                            if ($this->verificaPreCadastro($usuario)) {
                                header("location: ../Tela/completaPorEmail.php?local1");
                            } else {
                                session_start();
                                $_SESSION['id_usuario_correcao'] = $usuario->getId_usuario();
                                header("location: ../Tela/redefineSenha.php?primeiraSenha=1&segundo&codigo=" . $usuario->getId_usuario());
                                session_write_close();
                                exit(0);
                            }
                        } else {
                            header('location: ../Tela/codigoSMS.php?semSenha');
                        }
                        exit(0);
                    }
                }
            } else {
                header("Location: ../Tela/login.php?msg=erro&2&token=" . $token);
            }
        } else {
            $this->addToast("Não adianta tirar o required!");
            header("location: ../Tela/login.php");
            exit(0);
        }
    }

    function updateToken($id_usuario, $token)
    {
        $con = new Conexao();
        $pdo = $con->getConexao();
        $stmt = $pdo->prepare('update usuario set token = :token  where id_usuario = :id_usuario;');
        $stmt->bindValue(':token', $token);
        $stmt->bindValue(':id_usuario', $id_usuario);
        return $stmt->execute();
    }

//A! A! A! A! Stay alive stay alive
    function stayAlive()
    {
        if (isset($_SESSION['entidade']) and isset($_SESSION['logado']) and isset($_SESSION['permissao'])) {
            echo 'true';
        } else {
            echo "false";
        }
    }

    function logout()
    {
        session_destroy();
        setcookie("user", '', time() + 1, '/');
        setcookie("user", '', time() + 1, '/', $_SERVER["HTTP_HOST"], true, true);
        setcookie("ent", '', time() + 1, '/');
        setcookie("ent", '', time() + 1, '/', $_SERVER["HTTP_HOST"], true, true);

        setcookie("hashValidade", '', time() + 1, '/');
        setcookie("hashValidade", '', time() + 1, '/', $_SERVER["HTTP_HOST"]);
        header('location: ../Tela/login.php');
    }

    /* login */

    public
    function alteraFoto()
    {
        if (filesize($_FILES['imagem']['tmp_name']) > 15000000) {
            $this->addToast("O tamanho máximo de arquivo é de 15MB");
            header("location: ../Tela/perfil.php");
        } else {
            $fatorReducao = 5;
            $tamanho = filesize($_FILES['imagem']['tmp_name']);
            $qualidade = (100000000 - ($tamanho * $fatorReducao)) / 1000000;
            if ($qualidade < 5) {
                $qualidade = 5;
            }
            $us = new Usuario(unserialize($_SESSION['logado']));
            $antiga = $us->getFoto();

            //Receber os dados do formulÃ¡rio
            $nome_imagem = hash_file('md5', $_FILES['imagem']['tmp_name']);
            $ext = explode('.', $_FILES['imagem']['name']);
            $extensao = "." . $ext[(count($ext) - 1)];
            $extensao = strtolower($extensao);
            file_put_contents('./logodotipodafoto', $extensao);
            switch ($extensao) {
                case '.jfif':
                case '.jpeg':
                case '.jpg':
                    imagewebp(imagecreatefromjpeg($_FILES['imagem']['tmp_name']), __DIR__ . '/../Img/Perfil/' . $nome_imagem . '.webp', $qualidade);
                    break;
                case '.svg':
                    move_uploaded_file($_FILES['imagem']['tmp_name'], __DIR__ . '/../Img/Perfil/' . $nome_imagem . '.svg');
                    break;
                case '.gif':
                    move_uploaded_file($_FILES['imagem']['tmp_name'], __DIR__ . '/../Img/Perfil/' . $nome_imagem . '.gif');
                    break;
                case '.png':
                    $img = imagecreatefrompng($_FILES['imagem']['tmp_name']);
                    imagepalettetotruecolor($img);
                    imagewebp($img, __DIR__ . '/../Img/Perfil/' . $nome_imagem . '.webp', $qualidade);
                    break;
                case '.webp':
                    imagewebp(imagecreatefromwebp($_FILES['imagem']['tmp_name']), __DIR__ . '/../Img/Perfil/' . $nome_imagem . '.webp', $qualidade);
                    break;
                case '.bmp':
                    imagewebp(imagecreatefromwbmp($_FILES['imagem']['tmp_name']), __DIR__ . '/../Img/Perfil/' . $nome_imagem . '.webp', $qualidade);
                    break;
            }
            $Conexao = new Conexao();
            $pdo = $Conexao->getConexao();
            $stmt = $pdo->prepare("update usuario set foto = :imagem , is_foto_url = 0 where id_usuario = :id");
            $stmt->bindValue(':id', $us->getId_usuario());
            $stmt->bindValue(':imagem', 'Img/Perfil/' . $nome_imagem . ($extensao == '.svg' ? ".svg" : ($extensao == '.gif' ? ".gif" : ".webp")));


            //Verificar se os dados foram inseridos com sucesso
            if ($stmt->execute()) {
                $us->setFoto('Img/Perfil/' . $nome_imagem . ($extensao == '.svg' ? ".svg" : ($extensao == '.gif' ? ".gif" : ".webp")));

                if ($antiga != 'Img/Perfil/default.png' && $antiga != $us->getFoto()) {
                    if ($us->getIs_foto_url() != 1) {
                        unlink('../' . $antiga);
                    }
                }
                $us->setIs_foto_url(0);
                $_SESSION['logado'] = serialize($us);
                header('Location: ../Tela/perfil.php');
            } else {
                header('Location: ../Tela/perfil.php?msg=erro1');
            }
        }
    }

    public
    function removeAdm()
    {
        $this->requerAdm();
        $con = new Conexao();
        $pdo = $con->getConexao();
        $usuario = $this->selectUsuarioId_usuario($_GET['id']);
        $usuario = new Usuario($usuario->fetch());
        if ($usuario->getAdministrador() == 2) {
            $stmt = $pdo->prepare('select count(id_usuario) from usuario where administrador = 1');
            $stmt->execute();
            $linha = $stmt->fetch();
            if ($linha[0] > 1) {
                $stmt = $pdo->prepare('update usuario set administrador = 0 where id_usuario = :definir ;');
                $stmt->bindValue(':definir', $_GET['id']);
                $stmt->execute();
                $logado = $this->getLogado();
                if ($logado->getId_usuario() == $_GET['id']) {
                    $logado->setAdministrador(0);
                    $_SESSION['logado'] = serialize($logado);
                }
                $this->addToast('Status administrador removido');
                header('location: ../Tela/detalhesUsuario.php?id_usuario=' . $_GET['id']);
            } else {
                $this->addToast("Você é o ultimo administrador do sistema!");
                header('location: ../Tela/detalhesUsuario.php?id_usuario=' . $_GET['id'] . '&msg=unicoAdm');
            }
            $this->addToast("Eu criei você!");
            header('location: ../Tela/detalhesUsuario.php?id_usuario=' . $_GET['id'] . '&msg=unicoAdm');
        }
    }

    public
    function tornarAdm()
    {
        $this->requerAdm();
        $pdo = Conexao::getConexao();
        $stmt = $pdo->prepare('update usuario set administrador = 1 where id_usuario = :definir ;');
        $stmt->bindValue(':definir', $_GET['id']);
        $stmt->execute();
        $this->addToast('Status administrador adicionador');
        header('location: ../Tela/detalhesUsuario.php?id_usuario=' . $_GET['id']);
    }

    public function iserirEnredecoUsuario()
    {
        $id_usuario = $_POST['id_usuario'];
        $endereco = new Endereco($_POST);
        $pdo = Conexao::getConexao();
        $stmt = $pdo->prepare('update usuario set cep = :cep, estado = :estado, cidade = :cidade, bairro = :bairro, rua = :rua, numero = :numero, complemento = :complemento where id_usuario = :id_usuario');
        $stmt->bindValue(':cep', $endereco->getCep());
        $stmt->bindValue(':estado', $endereco->getEstado());
        $stmt->bindValue(':cidade', $endereco->getCidade());
        $stmt->bindValue(':bairro', $endereco->getBairro());
        $stmt->bindValue(':rua', $endereco->getRua());
        $stmt->bindValue(':numero', $endereco->getNumero());
        $stmt->bindValue(':complemento', $endereco->getComplemento());
        $stmt->bindValue(':id_usuario', $id_usuario);
        if ($stmt->execute()) {
            $this->addToast('Endereço cadastrado com sucesso!');
//            header('Location: ../index.php');
        } else {
            $this->addToast('Erro ao cadastrar endereço');
//            header('Location: ../index.php');
        }
    }

    /* chave */

    function selectNovosUsuarios()
    {
        $hoje = new DateTime();
        $hoje = $hoje->sub(new DateInterval("P7D"));
        $pdo = Conexao::getConexao();
        $stmt = $pdo->prepare("select * from usuario where data_cadastro > :data order by data_cadastro desc");
        $stmt->bindValue(":data", $hoje->format("Y-m-d"));
        $stmt->execute();
        return $stmt;
    }


    function validatePassword()
    {
        $password = $_POST['senha1'];
        $rule = '/^(?=.*\d).{8,}$/';
        if (preg_match($rule, $password, $matches, PREG_OFFSET_CAPTURE, 0)) {
            echo 'true';
        } else {
            echo 'false';
        }
    }

    function novosUsuariosSum()
    {
        $hoje = new DateTime();
        $hoje = $hoje->sub(new DateInterval('P7D'));
        $pdo = Conexao::getConexao();
        $stmt = $pdo->prepare('SELECT count(id_usuario) as soma FROM usuario WHERE data_cadastro > :data');
        $stmt->bindValue(':data', $hoje->format('Y-m-d'));
        $stmt->execute();
        $linha = $stmt->fetch();
        $retorno = $linha['soma'];
        if ($retorno == NUll) {
            echo 0;
        } else {
            echo $retorno;
        }
    }

    public function selectDestinatariosBroadcast($prioridade = 0)
    {
        $pdo = Conexao::getConexao();
        if ($prioridade == 0) {
            $stmt = $pdo->prepare("select id_usuario from usuario where email_confirmado = 1 and email not like '%teste%' and email not in (select email from emaillistanegra) and receber_email = 1");
        } else {
            $stmt = $pdo->prepare("select id_usuario from usuario where email_confirmado = 1 and email not like '%teste%' and email not in (select email from emaillistanegra)");
        }
        $stmt->execute();
        return $stmt;
    }
}
