<?php


namespace TCC\Modelo;
use DateTime;

class Mensagem
{
    private $id_mensagem;
    private $id_chamado;
    private $id_usuario;
    private $from_user;
    private $mensagem;
    private $hora;

    public function __construct() {
        if (func_num_args() != 0) {
            $atributos = func_get_args()[0];
            foreach ($atributos as $atributo => $valor) {
                if (isset($valor)) {
                    $this->$atributo = $valor;
                }
            }
        }
    }


    function atualizar($vetor) {
        foreach ($vetor as $atributo => $valor) {
            if (isset($valor)) {
                $this->$atributo = $valor;
            }
        }
    }

    public function getFromUser()
    {
        return $this->from_user;
    }

    public function setFromUser($from_user)
    {
        $this->from_user = $from_user;
    }

    public function getIdMensagem()
    {
        return $this->id_mensagem;
    }

    public function setIdMensagem($id_mensagem)
    {
        $this->id_mensagem = $id_mensagem;
    }

    public function getIdChamado()
    {
        return $this->id_chamado;
    }

    public function getHoraFormated(){
        $hora = new DateTime($this->hora);
        return $hora->format("d/m/Y H:i");
    }

    public function getHora()
    {
        return $this->hora;
    }

    public function setHora($hora)
    {
        $this->hora = $hora;
    }

    public function setIdChamado($id_chamado)
    {
        $this->id_chamado = $id_chamado;
    }

    public function getIdUsuario()
    {
        return $this->id_usuario;
    }

    public function setIdUsuario($id_usuario)
    {
        $this->id_usuario = $id_usuario;
    }

    public function getMensagem()
    {
        return $this->mensagem;
    }

    public function setMensagem($mensagem)
    {
        $this->mensagem = $mensagem;
    }


}