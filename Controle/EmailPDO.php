<?php

namespace TCC\Controle;


use Exception;
use TCC\Modelo\Chamado;
use TCC\Modelo\DestinatarioEmail;
use TCC\Modelo\Email;
use TCC\Modelo\EmailBroadcast;
use TCC\Modelo\Parametros;
use TCC\Modelo\Usuario;
use Ramsey\Uuid\Uuid;

class EmailPDO extends PDOBase
{

    private $parametros;
    private $contGeral = 0;

    public function __construct()
    {
        parent::__construct();
        $this->parametros = new Parametros();
    }


    function pagamentoFalho()
    {
        $usuarioPDO = new UsuarioPDO();
        $parametros = new Parametros();
        $logado = new Usuario(unserialize($_SESSION['logado']));
        $destinatarios = $usuarioPDO->selectUsuarioAdministrador(2);
        $email = new Email();
        if ($destinatarios) {
            while ($linha = $destinatarios->fetch()) {
                $usuario2 = new Usuario($linha);
                $email->addDestinatario($usuario2->getEmail(), $usuario2->getNome());
            }

            $email->setAssunto("Pagamento falhou!");
            $email->setTituloModeP("Pagamento falhou!");
            $email->setMensagemModeP("Atenção, é necessário olhar os logs e entrar em contato com o cliente! Se não sabe do que se trata este email, não se preocupe em resolver!
<br><br>Nome: " . $logado->getNome() . "<br>" .
                "Email: " . $logado->getEmail() . "<br>" .
                "Telefone: " . $logado->getTelefone() . "<br>" .
                "Servidor: " . $parametros->getServer()
            );
            $email->enviar();
        }
    }

    function chamadoReaberto($id_chamado)
    {
        $chamadoPDO = new ChamadoPDO();
        $chamado = $chamadoPDO->selectByIdChamado($id_chamado);
        $chamado = new Chamado($chamado->fetch());
        $usuarioPDO = new UsuarioPDO();
        $usuario = $usuarioPDO->selectUsuarioId_usuario($chamado->getIdResponsavel());
        $usuario = new Usuario($usuario->fetch());
        $email = new Email();
        $email->addDestinatario($usuario->getEmail(), $usuario->getNome());
        $email->setAssunto("Chamado Re-aberto");
        $parametros = new Parametros();
        $email->setTituloModeP($chamado->getDescricao());
        $email->setMensagemModeP("<p><a href='" . $parametros->getServer() . "/Tela/verChamado.php?id_chamado=" . $chamado->getIdChamado() . "'>Acessar Chamado</a></p>");
        $email->enviar();
    }

    function erroJsonPN($response, $postfields)
    {
        $email = new Email();
        $email->addDestinatario("dev@financeirametne.app");
        $caminho = "../Repo/JSONErros/" . Uuid::uuid4()->toString() . ".json";
        file_put_contents($caminho, $postfields);
        $email->setAssunto("Hummmm deu ruim");
        $email->setTituloModeP("Deu erro no json lá...");
        $email->setMensagemModeP("<p>" . $response . "</p><p>" . $caminho . "</p>");
        $email->enviar();

    }

    function novoUsuario(Usuario $usuario)
    {
        $usuarioPDO = new UsuarioPDO();
        $parametros = new Parametros();
        $destinatarios = $usuarioPDO->selectUsuarioAdministrador(2);
        $email = new Email();
        if ($destinatarios) {
            while ($linha = $destinatarios->fetch()) {
                $usuario2 = new Usuario($linha);
                $email->addDestinatario($usuario2->getEmail(), $usuario2->getNome());
            }

            $email->setAssunto("Novo usuário");
            $email->setTituloModeP("Novo usuário!");
            $email->setMensagemModeP("Nome: " . $usuario->getNome() . "<br>" .
                "Email: " . $usuario->getEmail() . "<br>" .

                "Telefone: " . $usuario->getTelefone() . "<br>" .
                "Codigo do Parceiro: " . $usuario->getCodigoParceiro() . "<br>" .
                "Servidor: " . $parametros->getServer()
            );
            $email->enviar();
        }

    }

    function newChamado(Chamado $chamado)
    {
        $usuarioPDO = new UsuarioPDO();
        $parametros = new Parametros();
        $email = new Email();
        $stmtUsusario = $usuarioPDO->selectUsuarioAdministrador('1');
        while ($linha = $stmtUsusario->fetch()) {
            $usuario = new Usuario($linha);
            if ($usuario->getEmail() != "") {
                $email->addDestinatario($usuario->getEmail());
            }
        }
        $email->setAssunto("Novo chamado!");
        $email->setTituloModeP("Novo Chamado!");
        $email->setMensagemModeP("Atenção, novo chamado -> " . $chamado->getTipoText() . "<br>
Hora: " . $chamado->getHoraFormated() . "<br>
Usuario: " . $this->getLogado()->getNome() . "<br>
Site: " . $parametros->getServer() . "<br>
Tela: " . $chamado->getTela() . "<br>
Descrição: " . $chamado->getDescricao() . "<br>
<b>Não responda este email, esta não é a forma de responder o cliente, acesse no site, God mode->Chamados ativos!</b>
<p><a href='" . $parametros->getServer() . "/Tela/verChamado.php?id_chamado=" . $chamado->getIdChamado() . "'></a></p>");
        $email->enviar(0, 1, 0);
    }


    function compartilhaEntidadeCompleteCadastro(Usuarioentidade $usuarioentidade)
    {
        $usuarioPDO = new UsuarioPDO();
        $usuario = $usuarioPDO->selectUsuarioId_usuario($usuarioentidade->getIdUsuario());
        $convidador = $usuarioPDO->getLogado();
        $usuario = new Usuario($usuario->fetch());
        $codigo = mt_rand(1000, 99999);
        $pdo = conexao::getConexao();
        $stmt = $pdo->prepare("insert into codigoconfirmacao values (:id_codigo, :id_usuario , :codigo, 'completa');");
        $stmt->bindValue(':id_codigo', Uuid::uuid4()->toString());
        $stmt->bindValue(':id_usuario', $usuarioentidade->getIdUsuario());
        $stmt->bindValue(':codigo', $codigo);
        $stmt->execute();
        $server = $_SERVER['HTTP_HOST'];
        $email = new Email();
        if($usuario->getNome() != ""){
            $email->setAssunto("Convite para colaborar");
            $email->addDestinatario($usuario->getEmail());
            $conteudoHTML = "
            <p>Olá, você recebeu acesso a um controle financeiro de " . $convidador->getNome() . "</p>
            <p>Acesse o " . htmlentities("Link para completar cadastro:") . ".<a href='http://" . $server . "/Tela/completaCadastro.php?codigo=" . $codigo . "&compart=" . $usuarioentidade->getIdUsuarioentidade() . "'>sistema</a> para aceitar o convite!</p>
        ";
            $email->setTituloModeP("Olá");
        }else{
            $email->setAssunto("Completar cadastro");
            $email->addDestinatario($usuario->getEmail());
            $conteudoHTML = "
            <p>Olá, você foi convidado para acessar nosso sistema por " . $convidador->getNome() . "</p>
            <p>Por favor " . htmlentities("Link para completar cadastro:") . ".<a href='http://" . $server . "/Tela/completaCadastro.php?codigo=" . $codigo . "&compart=" . $usuarioentidade->getIdUsuarioentidade() . "'>clique aqui</a> para completar seu cadastro e aceitar o convite!</p>
        ";
            $email->setTituloModeP("Olá");
        }
        $email->setMensagemModeP($conteudoHTML);
        $email->enviar(false, true);
    }

    function addDestinatariosByModule($module, Email $email)
    {
        //Adicionar usuários ao email de acordo com o módulo que possuem.
    }

    function emailDiarias(Entidade $entidade, Usuario $usuario)
    {
        $email = new Email();
        $email->addDestinatario($usuario->getEmail(), $usuario->getNome());
        $email->setAssunto("Diárias acabando!");
        $email->setTituloModeP("Diárias acabando!");
        $email->setMensagemModeP("Olá, seu controle com nome " . $entidade->getNome() . ", tem apenas mais " . $entidade->getDiarias() . " dias restantes, 
        por favor acesse o sistema para verificar a situação e manter seu controle disponível!");
        $email->enviar(0, 1);
    }


    function addBroadcast(Email $email, $prioridade = 0)
    {
        $pdo = Conexao::getConexao();
        if ($prioridade == 0) {
            $stmt = $pdo->prepare("select * from usuario where email_confirmado = 1 and deletado = 0 and ativo = 1 and receber_email = 1 and receber_email_sistema = 1");
        } else {
            $stmt = $pdo->prepare("select * from usuario where email_confirmado = 1 and deletado = 0 and ativo = 1 and receber_email_sistema = 1");
        }
        $stmt->execute();
        $cont = 0;
        while ($linha = $stmt->fetch()) {
            $email->addDestinatario($linha["email"], $linha['nome']);
            $cont++;
            $this->contGeral++;
            if ($cont > 40) {
                $email->enviar(false, true);
                $email = new Email();
                $email->setAssunto($_POST['assunto']);
                $email->setTituloModeP($_POST['assunto']);
                $email->setMensagemModeP($_POST['conteudo']);
                $cont = 0;
            }
        }
        return $email;

    }

    function mailSend()
    {
        set_time_limit(0);
        $this->log("Envio iniciado!", "logEnvioEmMassa.log");
        $email = new Email();
        $email->setAssunto($_POST['assunto']);
        $email->setTituloModeP($_POST['assunto']);
        $email->setMensagemModeP($_POST['conteudo']);
        $pdo = Conexao::getConexao();
        if (isset($_POST['prioridade'])) {
            $prioridade = 1;
        } else {
            $prioridade = 0;
        }
        switch ($_POST['tipo']) {
            case 0:
                $stmt = $pdo->prepare("select * from newsletter;");
                $stmt->execute();
                $cont = 0;
                while ($linha = $stmt->fetch()) {
                    $email->addDestinatario($linha["email"], $linha['nome']);
                    $cont++;
                    if ($cont > 13) {
                        sleep(5);
                        $email->enviar(false, true);
                        $email = new Email();
                        $email->setAssunto($_POST['assunto']);
                        $email->setTituloModeP($_POST['assunto']);
                        $email->setMensagemModeP($_POST['conteudo']);
                        $cont = 0;
                    }
                }
                break;
            case 3:
            case 1:
                switch ($_POST['modulo']) {
                    case 0:
                        $email = $this->addBroadcast($email, $prioridade);
                        break;
                    case 1:
//                        $this->addDestinatariosByModule( , $email);
                        break;
                    case 2:
                        break;
                }
                break;

        }
        $email->enviar(false);
        $this->log("Enviados " . $this->contGeral . " emails", "logEnvioEmMassa.log");
        $this->log("--------------------------------------------------------------------", "logEnvioEmMassa.log");
        header("location: ../Tela/mailSender.php");
    }

    function starEnvio()
    {
        $pdo = Conexao::getConexao();
        $emailBoadcastPDO = new EmailBroadcastPDO();
        $destinatarioEmailPDO = new DestinatarioEmailPDO();
        $emails = $emailBoadcastPDO->selectEmailPendente();
        if ($emails) {
            while ($linha = $emails->fetch()) {
                $emailBoadcast = new EmailBroadcast($linha);
                $this->log("Envio iniciado [" . $emailBoadcast->getAssunto() . "]!", "logEnvioEmMassa.log");
                $email = new Email();
                $email->setAssunto($emailBoadcast->getAssunto());
                $email->setTituloModeP($emailBoadcast->getAssunto());
                $email->setMensagemModeP($emailBoadcast->getConteudo());
                $destinatarios = $pdo->prepare("select u.* , d.id_destinatarioemail as id_destinatario
                                                        from usuario as u inner join destinatarioemail as d 
                                                            on d.id_usuario = u.id_usuario 
                                                        where d.status = :status");
                $destinatarios->bindValue(":status" , DestinatarioEmail::ST_PENDENTE);
                $destinatarios->execute();
                $cont = 0;
                $enviados = [];
                while ($destinatario = $destinatarios->fetch()) {
                    if ($cont < 20) {
                        $usuario = new Usuario($destinatario);
                        $email->addDestinatario($usuario->getEmail(), $usuario->getNome());
                        $enviados[] = $destinatario["id_destinatario"];
                        $this->log("Adicionado: ". $usuario->getNome() . " - " . $usuario->getEmail() , "logEnvioEmMassa.log");
                        $cont++;
                    } else {
                        $this->log("[TENTANDO ENVIAR]" , "logEnvioEmMassa.log");

                        if ($email->enviar()) {
                            $this->log("[ENVIO BEM SUCEDIDO]" , "logEnvioEmMassa.log");

                            $destinatarioEmailPDO->updateEnviados($enviados);
                            $enviados = [];
                            $cont = 0;
                            $email = new Email();
                            $email->setAssunto($emailBoadcast->getAssunto());
                            $email->setTituloModeP($emailBoadcast->getAssunto());
                            $email->setMensagemModeP($emailBoadcast->getConteudo());
                        } else {
                            $this->log("Falha no envio - PARANDO" , "logEnvioEmMassa.log");
                            exit(0);
                        }
                    }
                }
                if ($email->enviar()) {
                    $destinatarioEmailPDO->updateEnviados($enviados);
                    $this->log("[ENVIO BEM SUCEDIDO]", "logEnvioEmMassa.log");
                } else {
                    $this->log("Falha no envio - PARANDO" , "logEnvioEmMassa.log");
                    exit(0);
                }

            }
        }
    }

    function broadCast()
    {
        $id_email = $this->insertEmailBroadcast();
        $this->inserirDestinatariosBroadcast($id_email);
        header("location: ../Tela/gerenciaEmailMassa.php");
    }


    function inserirDestinatariosBroadcast($id_email)
    {
        $usuarioPDO = new UsuarioPDO();
        $usuarios = $usuarioPDO->selectDestinatariosBroadcast();
        while ($linha = $usuarios->fetch()) {
            $destinatarioBroadcast = new DestinatarioEmail($linha);
            $destinatarioBroadcast->setIdUsuario($linha['id_usuario']);
            $destinatarioBroadcast->setIdEmail($id_email);
            $destinatarioBroadcast->setStatus(DestinatarioEmail::ST_PENDENTE);
            $destinatarioBroadcast->inserir($destinatarioBroadcast);
        }

    }

    function insertEmailBroadcast()
    {
        $email = new EmailBroadcast();
        $email->setAssunto($_POST['assunto']);
        $email->setConteudo($_POST['conteudo']);
        $email->setPrioridade(isset($_POST['prioridade']) ? 1 : 0);
        $email->inserir($email);
        return $email->getIdEmail();

    }


    function compartilhaEntidade(Usuarioentidade $usuarioentidade)
    {
        $usuarioPDO = new UsuarioPDO();
        $usuario = $usuarioPDO->selectUsuarioId_usuario($usuarioentidade->getIdUsuario());
        $convidador = $usuarioPDO->getLogado();
        $usuario = new Usuario($usuario->fetch());
        $server = $_SERVER['HTTP_HOST'];
        $server == 'localhost' ? $server = $server . '/MarkeyVip' : $server = $server;
        $email = new Email();
        $email->setAssunto("Completar cadastro");
        $email->addDestinatario($usuario->getEmail());
        $conteudoHTML = "
            <p>Olá, você foi convidado para acessar nosso sistema por " . $convidador->getNome() . "</p>
            <p>Acesse o site " . htmlentities("Link para completar cadastro:") . ".<a href='https://" . $server . "//Controle/entidadeControle.php?function=defineEntidade&id_entidade=" . $usuarioentidade->getIdEntidade() . "'>clicando aqui</a> para aceitar o convite!</p>
        ";
        $email->setTituloModeP("Olá");
        $email->setMensagemModeP($conteudoHTML);
        $email->enviar(false, true);
    }

    function usuarioDeletado()
    {
        $usuarioPDO = new UsuarioPDO();
        $remetente = $_POST['remetente'];
        $mensagem = $_POST['mensagem'];
        $id_usuario = $_POST['id_usuario'];
        $stmtUs = $usuarioPDO->selectUsuarioId_usuario($id_usuario);
        $userDeletado = new Usuario($stmtUs->fetch());
        $conteudoHTML = "<p>O usuário " . $userDeletado->getNome() . ", CPF: " . $userDeletado->getCpfPontuado() . " Telefone: " . $userDeletado->getTelefoneMascarado() . " entrou em contato sobre seu usuário estar deletado, com a segunte mensagem:</p>"
            . "<p>" . $mensagem . "</p>";
        $email = new Email();
        $stmtUsusario = $usuarioPDO->selectUsuarioAdministrador('1');
        while ($linha = $stmtUsusario->fetch()) {
            $usuario = new Usuario($linha);
            if ($usuario->getEmail() != "") {
                $email->addDestinatario($usuario->getEmail());
            }
        }
        $email->setAssunto("Usuário deletado!");
        $email->setMensagemHTML($conteudoHTML);
        $email->setEmailResposta($remetente);
        $email->enviar(true, false);
        $this->addToast("Sua mensagem foi enviada, o administrador entrara em contato em breve!");
        header('location: ../index.php?msg=enviado');
    }

    function confirmaEmail($destinatario, $codigo = null, $id_usuario = null)
    {
        if (is_null($codigo)) {
            $codigo = mt_rand(1000, 99999);
            $pdo = conexao::getConexao();
            $stmt = $pdo->prepare("insert into codigoconfirmacao values (:id_codigo, :id_usuario , :codigo, 'email');");
            $stmt->bindValue(':id_codigo', Uuid::uuid4()->toString());
            $stmt->bindValue(':id_usuario', $id_usuario);
            $stmt->bindValue(':codigo', $codigo);
            $stmt->execute();
        }
        $email = new Email();
        $server = $_SERVER['HTTP_HOST'];
        $server == 'localhost' ? $server = $server . '/TCC' : $server = $server;
        $conteudoHTML = htmlentities("Link de verificação:") . "<a href='https://" . $server . "/Controle/usuarioControle.php?function=confirmaEmail&codigo=" . $codigo . "'>CLIQUE AQUI!</a>";
        $conteudonaoHTML = "Link de verificação: https://" . $server . "/Controle/usuarioControle.php?function=confirmaEmail&codigo=" . $codigo;
        $email->setAssunto(("Confirmação de Email"));
        $email->setTituloModeP(htmlentities("Seu código de confirmação!"));
        $email->setMensagemModeP($conteudoHTML);
        $email->setMensagemNaoHTML($conteudonaoHTML);
        $email->setEmailResposta($this->parametros->getEmailContato());
        try {
            $email->addDestinatario($destinatario);
        } catch (Exception $e) {
            $this->addToast("E-mail Inválido!");
            header("location: ../Tela/perfil.php");
            exit(0);
        }
        return $email->enviar(true, true);
    }

    function recuperaSenha(Usuario $usuario)
    {

        $codigo = mt_rand(1000, 99999);
        $pdo = conexao::getConexao();
        $stmt = $pdo->prepare("insert into codigoconfirmacao values (:id_codigo, :id_usuario , :codigo, 'recuperaSenha');");
        $stmt->bindValue(':id_codigo', Uuid::uuid4()->toString());
        $stmt->bindValue(':id_usuario', $usuario->getId_usuario());
        $stmt->bindValue(':codigo', $codigo);
        $stmt->execute();

        $email = new Email();
        $server = $_SERVER['HTTP_HOST'];
        $server == 'localhost' ? $server = $server . '/TCC' : $server = $server;
        $conteudoHTML = "<head><metacharset='UTF-8'></head>"
            . "Link de recuperação: <a href='https://" . $server . "/Tela/redefineSenha.php?codigo=" . $codigo . "&email=" . $usuario->getEmail() . "'>CLIQUE AQUI!</a>";
        $email->setMensagemModeP($conteudoHTML);
        $email->setTituloModeP("Olá");
        $email->addDestinatario($usuario->getEmail());
        $email->setAssunto("Recuperação de Conta");
        $email->enviar(true, true);
    }

    function completaCadastro(Usuario $usuario)
    {

        $codigo = mt_rand(1000, 99999);
        $pdo = conexao::getConexao();
        $stmt = $pdo->prepare("insert into codigoconfirmacao values (:id_codigo, :id_usuario , :codigo, 'completa');");
        $stmt->bindValue(':id_codigo', Uuid::uuid4()->toString());
        $stmt->bindValue(':id_usuario', $usuario->getId_usuario());
        $stmt->bindValue(':codigo', $codigo);
        $stmt->execute();

        $server = $_SERVER['HTTP_HOST'];
        $server == 'localhost' ? $server = $server . '/MarkeyVip' : $server = $server;
        $email = new Email();
        $email->setAssunto("Completar cadastro");
        $email->addDestinatario($usuario->getEmail());
        $conteudoHTML = "
            <p>Olá, esse e-mail foi cadastrado em nosso sistema.</p>
            <p>Se você autorizou esse cadastro, por favor " . htmlentities("Link para completar cadastro:") . ".<a href='http://" . $server . "/Tela/completaCadastro.php?codigo=" . $codigo . "'>clique aqui</a> para completar seu cadastro</p>
        ";
        $email->setTituloModeP("Olá");
        $email->setMensagemModeP($conteudoHTML);
        $email->enviar(false, true);
    }
}
