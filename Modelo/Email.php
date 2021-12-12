<?php
namespace TCC\Modelo;

use DateTime;
use Exception;
use TCC\Controle\UsuarioPDO;
use PHPMailer\PHPMailer\PHPMailer;

class Email
{

    private $emailObject;
    private $corpoHTML;
    private $corpoHTML2;
    private $corpoHTML3;
    private $parametros;
    private $titulo = '';
    private $mensagem = '';
    private $liberar = false;
    private $imediate = false;

    public function __construct()
    {
        $this->log("----------------------------------", "emailFail");
        $this->log("Inicio do Envio", "emailFail");
        $this->emailObject = new PHPMailer(true);
        $this->parametros = new Parametros();
        $this->constroiMensagem();

        try {
            //Server settings
            $this->emailObject->isSMTP();                                            // Set this->emailObjecter to use SMTP
            $this->emailObject->SMTPAuth = true;

            $this->emailObject->Host = $this->parametros->getSmtpServer();  // Specify main and backup SMTP servers
            $this->emailObject->Username = $this->parametros->getSmtpUser();                     // SMTP username
            $this->emailObject->Password = $this->parametros->getSmtpPassword();                               // SMTP password
            $this->emailObject->SMTPSecure = $this->parametros->getSmtpCrypt();                                  // Enable TLS encryption, `ssl` also accepted
            $this->emailObject->Port = intval($this->parametros->getSmtpPorta());                                    // TCP port to connect to

            $this->emailObject->setFrom($this->parametros->getSmtpRemetente(), $this->parametros->getNome_empresa());
            $this->emailObject->addReplyTo($this->parametros->getEmailContato(), $this->parametros->getNome_empresa());
            $this->emailObject->isHTML(true);                                  // Set ethis->emailObject format to HTML
            $this->emailObject->AltBody = "Sua caixa de entrada não suporta este E-mail.";
            $this->emailObject->CharSet = 'UTF-8';
            $this->emailObject->Encoding = 'base64';
        } catch (Exception $e) {
            $hora = new DateTime();
            file_put_contents("../Logs/this->emailObjectLog.txt", $e->getMessage() . "\nHORA: " . $hora->format('d/m/Y H:i:s'), FILE_APPEND);
        }
    }

    public function setEmailResposta(string $remetente)
    {
        $this->emailObject->addReplyTo($remetente);
    }

    public function isImediate(): bool
    {
        return $this->imediate;
    }

    public function setImediate(bool $imediate)
    {
        $this->imediate = $imediate;
    }


    private function constroiMensagem()
    {
        $this->corpoHTML = '<!DOCTYPE html>

<html lang="pt-br">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Email de confirmação</title>
    </head>
    <body style="max-width: 100%; margin: 0; padding: 0; font-family: Arial">

        <style>

            .detalheSuaveE {
                background-color: #f5f5f5;
                -webkit-box-shadow: 0 3px 3px 0 rgba(0, 0, 0, 0.14), 0 1px 7px 0 rgba(0, 0, 0, 0.12), 0 3px 1px -1px rgba(0, 0, 0, 0.2);
                box-shadow: 0 3px 3px 0 rgba(0, 0, 0, 0.14), 0 1px 7px 0 rgba(0, 0, 0, 0.12), 0 3px 1px -1px rgba(0, 0, 0, 0.2);
            }

            .horizontal-dividerE{
                background-image: linear-gradient(to right, transparent, black , transparent);
                height: 1px;
            }
        </style>

        <table class="detalheSuaveE" align="center" cellpadding="0" cellspacing="0" width="90%" style="max-width: 100%; border-collapse: collapse;">
            <tr>
                <td align="center" style="padding: 20px 0 20px 0;">
                    <img src="' . $this->parametros->getServer() . '/' . $this->parametros->getLogo() . '" alt="Logo" width="300" height="230" style="display: block; height: 10rem; width: auto" />
                </td>
            </tr>
            <tr class="horizontal-dividerE">
                <td>

                </td>
            </tr>

            <tr>
                <td bgcolor="#ffffff" style="padding: 20px 30px 40px 30px;">
                    <table cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td align="center" style="font-size: 1rem">
                               ';
        $this->corpoHTML2 = '</td>
            </tr><tr>
                <td bgcolor="#ffffff" style="padding: 20px 30px 40px 30px;">
                    <table cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td align="center" style="font-size: 1rem">
                               
                            </td>
                        </tr>
                        <tr>
                            <td align="center" style="padding: 20px 0px 30px 0; font-size: 1rem;">';
        $this->corpoHTML3 = '</td>
                        </tr>
                    </table>
                </td>
            <tr class="horizontal-dividerE">
                <td>

                </td>
            </tr>
            <tr >
                <td bgcolor="#ffffff" style="padding: 20px 20px 20px 20px;" style="font-size: 1rem">
                    <table cellpadding="0" cellspacing="0" width="100%" style="font-size: 1rem">
                        <tr>
                            <td align="center">
                                ' . $this->parametros->getEmailContato() . '
                            </td>
                        </tr>
                        <tr>
                            <td align="center" style="padding: 20px 20px 0px 20px;" style="font-size: 0.7rem">
                                © 2020 Desenvolvido por - TCCApp
                            </td>
                        </tr>

                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>
';
    }

    public function addDestinatario(string $destinatario, string $nome = "")
    {
        if ($destinatario != "" && $destinatario != null) {
            try {
                $this->emailObject->addBCC($destinatario, $nome);
                $this->liberar = true;
            } catch (\Exception $e) {
                $this->addToast("Ocorreu um erro ao enviar o E-mail.");
            }
        }
    }

    public function addCopia(string $enderecoCopia)
    {
        $this->emailObject->addCC($enderecoCopia);
    }

    public function addCopiaComNome(string $enderecoCopia, string $nome)
    {
        $this->emailObject->addCC($enderecoCopia, $nome);
    }

    public function addCopiaOculta(string $enderecoCopia)
    {
        $this->emailObject->addBCC($enderecoCopia);
    }

    public function addCopiaOcultaComNome(string $enderecoCopia, string $nome)
    {
        $this->emailObject->addBCC($enderecoCopia, $nome);
    }

    public function setAssunto(string $assunto)
    {
        $this->emailObject->Subject = $assunto;
    }

    public function setMensagemHTML(string $mensagem)
    {
        $this->emailObject->Body = $mensagem;
    }

    function getTitulo()
    {
        return $this->titulo;
    }

    function getMensagem()
    {
        return $this->mensagem;
    }

    function setTituloModeP($titulo)
    {
        $this->titulo = $titulo;
    }

    function setMensagemModeP($mensagem)
    {
        $this->mensagem = $mensagem;
    }

    function addDestinatarioById($id_usuario){
        $usuarioPDO = new UsuarioPDO();
        $usuario = new Usuario($usuarioPDO->selectUsuarioId_usuario($id_usuario)->fetch());
        $this->addDestinatario($usuario->getEmail() , $usuario->getNome());
    }

    public function setMensagemNaoHTML(string $mensagem)
    {
        $this->emailObject->AltBody = $mensagem;
    }

    public function setServerUsername(string $username)
    {
        $this->emailObject->Username = $username;
    }

    public function setServerPassword(string $password)
    {
        $this->emailObject->Password = $password;
    }

    public function enviar(bool $registraBanco = false, bool $modeloPadrao = true, bool $fail = false)
    {
        if ($modeloPadrao) {
            $this->emailObject->Body = $this->corpoHTML . $this->titulo . $this->corpoHTML2 . $this->mensagem . $this->corpoHTML3;
        }
//        if ($this->liberar and $this->isImediate()) {
        if ($this->liberar) {
            try {
                if ($fail == false) {
                    $this->log("Sending with aws", "emailFail");
                } else {
                    $this->log("Sending with hostoo", "emailFail");
                }
                session_write_close();
                $this->emailObject->send();
                $this->log("Fim do envio", "emailFail");
                $this->log("----------------------------------", "emailFail");
                return true;

            } catch (Exception $e) {
                $this->log("ERROR MESSAGE ->".$e->getMessage(), "emailFail");
                $this->log("ERROR CODE ->".$e->getCode(), "emailFail");
                $this->log($e->getCode(), "emailFail");
                $this->log("DADOS", "emailFail");
                $this->log("Titulo - ".$this->getTitulo(), "emailFail");
                $this->log("Conteudo - ".$this->getMensagem(), "emailFail");
                if ($fail == false) {
                    $this->contingence();
                } else {
                    if (!isset($_SESSION)) {
                        session_start();
                    }
                    $this->addToast("Ocorreu um erro ao enviar o E-mail.");
                }
                return false;
            }
        } else {
            if ($this->liberar) {
                $serializdo = serialize($this);

            }
            return false;
        }
        $this->log("Fim do envio", "emailFail");
        $this->log("----------------------------------", "emailFail");
    }


    public function log(string $content, string $file = "logEmergence")
    {
        $data = new DateTime();
        file_put_contents(__DIR__ . "/../Logs/" . $file, "
" . $data->format("d/m/Y H:i:s - - -") . $content, FILE_APPEND);
    }

    function contingence()
    { 
        $this->emailObject->Host = 'mail.TCC.app';  // Specify main and backup SMTP servers
        $this->emailObject->Username = 'no_reply@TCC.app';                     // SMTP username
        $this->emailObject->Password = 'yoidWE4#';
        $this->emailObject->SMTPSecure = 'ssl';
        $this->emailObject->Port = 465;                                    // TCP port to connect to

        $this->enviar(true, true, true);
    }

}
