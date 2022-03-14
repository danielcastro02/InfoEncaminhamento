<?php

namespace TCC\Modelo;

namespace TCC\Modelo;
class Parametros
{

    private $id_parametro = 0;
    private $nome_empresa = "TCC";
    private $is_foto = 0;
    private $emailContato = "TCCapp@gmail.com";
    private $hasAdm = 1;
    private $telefones = "(55) 99959-8414";
    private $logo = "";
    private $ruaNumero = "";
    private $cidade = "";
    private $estado = "";
    private $app_token = "aegvasevservserfwserfvsev";
    private $envia_notificacao = 0;
    //private $server = "http://localhost/InfoEncaminhamento"; // colocar o do iff e apagar o construtor
	private $server = "https://ciet.svs.iffarroupilha.edu.br/grissetti/InfoEncaminhamento"
    private $link_app = "https://play.google.com/store/apps/details?id=markey.hotel";
    private $qr_app = "";
    private $active_chat = 0;
    private $confirma_email = 1;
    private $firebase_topic = "dispositivos";
    private $nome_db = "infoencaminhamento";
    private $metodo_autenticacao = 1;
    private $smtp_server;
    private $smtp_user;
    private $smtp_password;
    private $smtp_crypt;
    private $smtp_porta;
    private $smtp_remetente;


    public function __construct()
    {
        try {
            error_reporting(0);
            $atributos = json_decode(file_get_contents(__DIR__ . "/parametros.json"));
            foreach ($atributos as $atributo => $valor) {
                if (isset($valor)) {
                    $this->$atributo = $valor;
                }
            }
            error_reporting(E_ALL);
        } catch (\Exception $e) {
            $this->save();
        }        
    }

    public function getSmtpServer()
    {
        return $this->smtp_server;
    }

    public function setSmtpServer($smtp_server): void
    {
        $this->smtp_server = $smtp_server;
    }

    public function getSmtpUser()
    {
        return $this->smtp_user;
    }

    public function setSmtpUser($smtp_user): void
    {
        $this->smtp_user = $smtp_user;
    }

    public function getSmtpPassword()
    {
        return $this->smtp_password;
    }

    public function setSmtpPassword($smtp_password): void
    {
        $this->smtp_password = $smtp_password;
    }

    public function getFirebaseTopic(): string
    {
        return $this->firebase_topic;
    }

    public function setFirebaseTopic(string $firebase_topic)
    {
        $this->firebase_topic = $firebase_topic;
    }

    public function getMetodoAutenticacao(): int
    {
        return $this->metodo_autenticacao;
    }

    public function setMetodoAutenticacao(int $metodo_autenticacao): void
    {
        $this->metodo_autenticacao = $metodo_autenticacao;
    }

    public function getNomeDb()
    {
        return $this->nome_db;
    }

    public function setNomeDb($nome_db)
    {
        $this->nome_db = $nome_db;
    }

    public function getLinkApp()
    {
        return $this->link_app;
    }

    public function getConfirmaEmail()
    {
        return $this->confirma_email;
    }

    public function setConfirmaEmail($confirma_email)
    {
        $this->confirma_email = $confirma_email;
    }

    public function getSmtpCrypt()
    {
        return $this->smtp_crypt;
    }

    public function setSmtpCrypt($smtp_crypt): void
    {
        $this->smtp_crypt = $smtp_crypt;
    }

    public function getSmtpPorta()
    {
        return $this->smtp_porta;
    }

    public function setSmtpPorta($smtp_porta): void
    {
        $this->smtp_porta = $smtp_porta;
    }

    public function getSmtpRemetente()
    {
        return $this->smtp_remetente;
    }

    public function setSmtpRemetente($smtp_remetente): void
    {
        $this->smtp_remetente = $smtp_remetente;
    }

    public function getViraDiaria()
    {
        return $this->vira_diaria;
    }

    public function save()
    {
        file_put_contents(__DIR__ . '/parametros.json', json_encode(get_object_vars($this)));
//        file_put_contents(__DIR__ . '/../../adm.markeyvip.com/Parametros/'.$_SERVER["HTTP_HOST"].".json", json_encode(get_object_vars($this)));
    }

    public function setLinkApp($link_app)
    {
        $this->link_app = $link_app;
    }

    public function getActiveChat()
    {
        return $this->active_chat;
    }

    public function setActiveChat($active_chat)
    {
        $this->active_chat = $active_chat;
    }

    public function getQrApp()
    {
        return $this->qr_app;
    }

    public function setQrApp($qr_app)
    {
        $this->qr_app = $qr_app;
    }

    function getEnvia_notificacao()
    {
        return $this->envia_notificacao;
    }

    function setAtiva_pagamento($ativa_pagamento)
    {
        $this->ativa_pagamento = $ativa_pagamento;
    }

    function setEnvia_notificacao($envia_notificacao)
    {
        $this->envia_notificacao = $envia_notificacao;
    }

    function getAppToken()
    {
        return $this->app_token;
    }

    function getEnviarNotificacao()
    {
        return $this->envia_notificacao;
    }

    function setEnviarNotificacao($enviarNotificacao)
    {
        $this->envia_notificacao = $enviarNotificacao;
    }

    function setAppToken($appToken)
    {
        $this->app_token = $appToken;
    }

    function getApp_token()
    {
        return $this->app_token;
    }

    function getServer()
    {
        return $this->server;
    }

    function setApp_token($app_token)
    {
        $this->app_token = $app_token;
    }

    function setServer($server)
    {
        $this->server = $server;
    }

    function atualizar($vetor)
    {
        foreach ($vetor as $atributo => $valor) {
            if (isset($valor)) {
                $this->$atributo = $valor;
            }
        }
    }

    function getRuaNumero()
    {
        return $this->ruaNumero;
    }

    function getCidade()
    {
        return $this->cidade;
    }

    function getEstado()
    {
        return $this->estado;
    }

    function setRuaNumero($ruaNumero)
    {
        $this->ruaNumero = $ruaNumero;
    }

    function setCidade($cidade)
    {
        $this->cidade = $cidade;
    }

    function setEstado($estado)
    {
        $this->estado = $estado;
    }

    function getEmailContato()
    {
        return $this->emailContato;
    }

    function getLogo()
    {
        return $this->logo;
    }

    function setLogo($logo)
    {
        $this->logo = $logo;
    }

    function setEmailContato($emailContato)
    {
        $this->emailContato = $emailContato;
    }

    function getTelefones()
    {
        return $this->telefones;
    }

    function setTelefones($telefones)
    {
        $this->telefones = $telefones;
    }

    public function getId_parametro()
    {
        return $this->id_parametro;
    }

    function setId_parametro($id_parametro)
    {
        $this->id_parametro = $id_parametro;
    }

    public function getNome_empresa()
    {
        return $this->nome_empresa;
    }

    function setNome_empresa($nome_empresa)
    {
        $this->nome_empresa = $nome_empresa;
    }

    public function getIs_foto()
    {
        return $this->is_foto;
    }

    function setIs_foto($is_foto)
    {
        $this->is_foto = $is_foto;
    }

    public function getHasAdm()
    {
        return $this->hasAdm;
    }

    function setHasAdm($hasAdm)
    {
        $this->hasAdm = $hasAdm;
    }

}