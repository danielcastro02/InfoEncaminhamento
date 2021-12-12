<?php

namespace TCC\Modelo;

use TCC\Modelo\Abstrato\Modelo;

class SelectOption extends Modelo
{
    protected $id_option;
    protected $texto;
    protected $tipo;
    protected $setor;

    const TP_MOTIVO = 1;
    const TP_SUGESTAO = 2;
    const TP_RECURSO = 3;
    const TP_TURMA = 4;

    const ST_PEDAGOGICO = 1;
    const ST_CAE = 2;

    public function getIdOption()
    {
        return $this->id_option;
    }

    public function setIdOption($id_option): void
    {
        $this->id_option = $id_option;
    }

    public function getTexto()
    {
        return $this->texto;
    }

    public function setTexto($texto): void
    {
        $this->texto = $texto;
    }

    public function getTipo()
    {
        return $this->tipo;
    }

    public function setTipo($tipo): void
    {
        $this->tipo = $tipo;
    }

    public function getSetor()
    {
        return $this->setor;
    }

    public function setSetor($setor): void
    {
        $this->setor = $setor;
    }

}