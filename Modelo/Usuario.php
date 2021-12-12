<?php

namespace TCC\Modelo;
use TCC\Modelo\Abstrato\Modelo;

class Usuario extends Modelo {

    protected $id_usuario;
    protected $nome;
    protected $senha;
    protected $cpf;
    protected $email;
    protected $telefone;
    protected $data_nasc;
    protected $foto;
    protected $administrador;
    protected $ativo;
    protected $codigo_parceiro = "";
    protected $deletado;
    protected $telefone_confirmado;
    protected $email_confirmado;
    protected $data_cadastro;
    protected $token;
    protected $pre_cadastro = 0;
    protected $facebook_id;
    protected $is_foto_url;
    protected $cep;
    protected $cidade;
    protected $estado;
    protected $bairro;
    protected $rua;
    protected $numero;
    protected $complemento;
    protected $novo_cadastro;
    protected $receber_email;
    protected $receber_email_sistema;
    protected $setor;

    const REPO = "/Img/Perfil/";

    public function getSetor()
    {
        return $this->setor;
    }

    public function setSetor($setor): void
    {
        $this->setor = $setor;
    }

    public function getDataCadastro()
    {
        return $this->data_cadastro;
    }

    public function setDataCadastro($data_cadastro): void
    {
        $this->data_cadastro = $data_cadastro;
    }

    function getPre_cadastro() {
        return $this->pre_cadastro;
    }

    function getFacebook_id() {
        return $this->facebook_id;
    }

    function getIs_foto_url() {
        return $this->is_foto_url;
    }

    public function getCodigoParceiro()
    {
        return $this->codigo_parceiro;
    }

    public function getNovoCadastro()
    {
        return $this->novo_cadastro;
    }

    public function getCep()
    {
        return $this->cep;
    }

    public function setCep($cep): void
    {
        $this->cep = $cep;
    }

    public function getCidade()
    {
        return $this->cidade;
    }

    public function setCidade($cidade): void
    {
        $this->cidade = $cidade;
    }

    public function getReceberEmail()
    {
        return $this->receber_email;
    }

    public function setReceberEmail($receber_email): void
    {
        $this->receber_email = $receber_email;
    }

    public function getReceberEmailSistema()
    {
        return $this->receber_email_sistema;
    }

    public function setReceberEmailSistema($receber_email_sistema): void
    {
        $this->receber_email_sistema = $receber_email_sistema;
    }

    public function getEstado()
    {
        return $this->estado;
    }

    public function setEstado($estado): void
    {
        $this->estado = $estado;
    }

    public function getBairro()
    {
        return $this->bairro;
    }

    public function setBairro($bairro): void
    {
        $this->bairro = $bairro;
    }

    public function getRua()
    {
        return $this->rua;
    }

    public function setRua($rua): void
    {
        $this->rua = $rua;
    }

    public function getNumero()
    {
        return $this->numero;
    }

    public function setNumero($numero): void
    {
        $this->numero = $numero;
    }

    public function getComplemento()
    {
        return $this->complemento;
    }

    public function setComplemento($complemento): void
    {
        $this->complemento = $complemento;
    }

    public function setNovoCadastro($novo_cadastro): void
    {
        $this->novo_cadastro = $novo_cadastro;
    }

    public function setCodigoParceiro($codigo_parceiro)
    {
        $this->codigo_parceiro = $codigo_parceiro;
    }

    function setFacebook_id($facebook_id) {
        $this->facebook_id = $facebook_id;
    }

    function setIs_foto_url($is_foto_url) {
        $this->is_foto_url = $is_foto_url;
    }

    function setPre_cadastro($pre_cadastro) {
        $this->pre_cadastro = $pre_cadastro;
    }

    function getTelefone_confirmado() {
        return $this->telefone_confirmado;
    }

    function getToken() {
        return $this->token;
    }

    function setToken($token) {
        $this->token = $token;
    }

    function getEmail_confirmado() {
        return $this->email_confirmado;
    }

    function setTelefone_confirmado($telefone_confirmado) {
        $this->telefone_confirmado = $telefone_confirmado;
    }

    function setEmail_confirmado($email_confirmado) {
        $this->email_confirmado = $email_confirmado;
    }

    function getData_nasc() {
        return $this->data_nasc;
    }

    function getDeletado() {
        return $this->deletado;
    }

    function setData_nasc($data_nasc) {
        $this->data_nasc = $data_nasc;
    }

    function setDeletado($deletado) {
        $this->deletado = $deletado;
    }

    public function getId_usuario() {
        return $this->id_usuario;
    }

    public function getTelefoneMascarado() {
        if ($this->telefone != '') {
            return "(" . substr($this->telefone, 0, 2) . ") " . substr($this->telefone, 2, 5) . "-" . substr($this->telefone, 7);
        } else {
            return "";
        }
    }

    function setId_usuario($id_usuario) {
        $this->id_usuario = $id_usuario;
    }

    public function getNome() {
        return $this->nome;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    public function getSenha() {
        return $this->senha;
    }

    function setSenha($senha) {
        $this->senha = $senha;
    }

    public function getCpf() {
        $newcpf = str_replace(".", "", $this->cpf);
        $newcpf = str_replace(".", "", $newcpf);
        $newcpf = str_replace("-", "", $newcpf);
        return $newcpf;
    }

    public function getCpfPontuado() {
        if ($this->cpf != '') {
            $cpf = $this->getCpf();
            $cpf = str_split($cpf);
            return $cpf[0] . $cpf[1] . $cpf[2] . "." . $cpf[3] . $cpf[4] . $cpf[5] . "." . $cpf[6] . $cpf[7] . $cpf[8] . "-" . $cpf[9] . $cpf[10];
        } else {
            return '';
        }
    }

    function setCpf($cpf) {
        $this->cpf = $cpf;
    }

    public function getEmail() {
        return $this->email;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    public function getTelefone() {
        if ($this->telefone != null) {
            $newCel = str_replace("-", "", $this->telefone);
            $newCel = str_replace("(", "", $newCel);
            $newCel = str_replace(")", "", $newCel);
            $newCel = str_replace(" ", "", $newCel);
            return $newCel;
        } else {
            return null;
        }
    }

    function setTelefone($telefone) {
        $this->telefone = $telefone;
    }

    public function getData_nascExibicao() {
        if ($this->data_nasc != null) {
            $data = explode("-", $this->data_nasc);
            if (count($data) > 1) {
                return $data[2] . $data[1] . $data[0];
            } else {
                $data = explode("/", $this->data_nasc);
                if (count($data) > 1) {
                    return $data[0] . $data[1] . $data[2];
                } else {
                    return $this->data_nasc;
                }
            }
        } else {
            return null;
        }
    }

    public function getData_nascBarras() {
        if ($this->data_nasc != null) {
            $data = explode("-", $this->data_nasc);
            if (count($data) > 1) {
                return $data[2] . "/" . $data[1] . "/" . $data[0];
            } else {
                return $this->data_nasc;
            }
        } else {
            return null;
        }
    }

    public function getData_banco() {
        if ($this->data_nasc != null) {
            $data = explode("/", $this->data_nasc);
            if (count($data) > 1) {
                return $data[2] . "-" . $data[1] . "-" . $data[0];
            } else {
                return $this->data_nasc;
            }
        } else {
            return null;
        }
    }

    function setDdata_nasc($data_nasc) {
        $this->data_nasc = $data_nasc;
    }

    public function getFoto() {
        return $this->foto;
    }

    function setFoto($foto) {
        $this->foto = $foto;
    }

    public function getAdministrador() {
        return $this->administrador;
    }

    function setAdministrador($administrador) {
        $this->administrador = $administrador;
    }

    public function getAtivo() {
        return $this->ativo;
    }

    function setAtivo($ativo) {
        $this->ativo = $ativo;
    }

}
