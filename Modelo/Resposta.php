<?php

namespace TCC\Modelo;

use DateTime;
use TCC\Modelo\Abstrato\Modelo;

class Resposta extends Modelo
{

    protected $id_resposta;
    protected $id_servidor;
    protected $id_encaminhamento;
    protected $resposta;
    protected $data_resposta;

    public function getIdResposta()
    {
        return $this->id_resposta;
    }

    public function setIdResposta($id_resposta): void
    {
        $this->id_resposta = $id_resposta;
    }

    public function getIdServidor()
    {
        return $this->id_servidor;
    }

    public function setIdServidor($id_servidor): void
    {
        $this->id_servidor = $id_servidor;
    }

    public function getIdEncaminhamento()
    {
        return $this->id_encaminhamento;
    }

    public function setIdEncaminhamento($id_encaminhamento): void
    {
        $this->id_encaminhamento = $id_encaminhamento;
    }

    public function getResposta()
    {
        return $this->resposta;
    }

    public function setResposta($resposta): void
    {
        $this->resposta = $resposta;
    }

    public function getDataResposta()
    {
        return $this->data_resposta;
    }

    public function setDataResposta($data_resposta): void
    {
        $this->data_resposta = $data_resposta;
    }

    public function getHoraFormated()
    {
        $hora = new DateTime($this->data_resposta);
        return $hora->format("d/m/Y H:i");
    }

}