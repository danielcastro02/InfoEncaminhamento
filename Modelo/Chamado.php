<?php


namespace TCC\Modelo;
use DateTime;

class Chamado
{
    private $id_chamado;
    private $tipo;
    private $id_usuario;
    private $id_responsavel;
    private $tela;
    private $descricao;
    private $status;
    private $hora;

    const ST_ABERTO = 1;
    const ST_FECHADO = 2;

    const TP_SUPORTE_FINANCEIRO = 1;
    const TP_SUPORTE_TECNICO = 2;
    const TP_DUVIDAS_GERAIS = 3;
    const TP_SUGESTAO = 4;

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

    public function getHora()
    {
        return $this->hora;
    }

    public function setHora($hora)
    {
        $this->hora = $hora;
    }

    public function getIdEntidade()
    {
        return $this->id_entidade;
    }

    public function setIdEntidade($id_entidade)
    {
        $this->id_entidade = $id_entidade;
    }

    public function getIdChamado()
    {
        return $this->id_chamado;
    }

    public function setIdChamado($id_chamado)
    {
        $this->id_chamado = $id_chamado;
    }

    public function getIdResponsavel()
    {
        return $this->id_responsavel;
    }

    public function setIdResponsavel($id_responsavel)
    {
        $this->id_responsavel = $id_responsavel;
    }

    public function getTipo()
    {
        return $this->tipo;
    }

    public function getTipoText(){
        switch ($this->tipo){
            case self::TP_SUPORTE_FINANCEIRO:
                return "Suporte financeiro";
            case self::TP_SUPORTE_TECNICO:
                return "Suporte técnico";
            case self::TP_DUVIDAS_GERAIS:
                return "Dúvidas gerais";
            case self::TP_SUGESTAO:
                return "Sugestão";
            default:
                return "Tipo não especificado";
        }
    }

    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }

    public function getIdUsuario()
    {
        return $this->id_usuario;
    }

    public function setIdUsuario($id_usuario)
    {
        $this->id_usuario = $id_usuario;
    }

    public function getHoraFormated(){
        $hora = new DateTime($this->hora);
        return $hora->format("d/m/Y H:i");
    }

    public function getTela()
    {
        return $this->tela;
    }

    public function setTela($tela)
    {
        $this->tela = $tela;
    }

    public function getDescricao()
    {
        return $this->descricao;
    }

    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }



}