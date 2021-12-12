<?php

namespace TCC\Modelo;

use TCC\Controle\AlunoPDO;
use TCC\Controle\SelectOptionPDO;
use TCC\Modelo\Abstrato\Modelo;

class Encaminhamento extends Modelo
{

    protected $id_encaminhamento;
    protected $id_servidor;
    protected $id_aluno;
    protected $id_motivo;
    protected $id_recurso;
    protected $id_sugestao;
    protected $data_ocorrencia;
    protected $data_encaminhamento;
    protected $relato;
    protected $disciplina;
    protected $frequencia;
    protected $setor;
    protected $status;

    const SET_PEDAGOGICO = 1;
    const SET_CAE = 2;

    const STT_ABERTO = 1;
    const STT_ATENDENDO = 2;
    const STT_RESOLVIDO = 3;

    public function getIdEncaminhamento()
    {
        return $this->id_encaminhamento;
    }

    public function setIdEncaminhamento($id_encaminhamento): void
    {
        $this->id_encaminhamento = $id_encaminhamento;
    }

    public function getIdServidor()
    {
        return $this->id_servidor;
    }

    public function setIdServidor($id_servidor): void
    {
        $this->id_servidor = $id_servidor;
    }

    public function getIdAluno()
    {
        return $this->id_aluno;
    }

    public function setIdAluno($id_aluno): void
    {
        $this->id_aluno = $id_aluno;
    }

    public function getIdMotivo()
    {
        return $this->id_motivo;
    }

    public function setIdMotivo($id_motivo): void
    {
        $this->id_motivo = $id_motivo;
    }

    public function getIdRecurso()
    {
        return $this->id_recurso;
    }

    public function setIdRecurso($id_recurso): void
    {
        $this->id_recurso = $id_recurso;
    }

    public function getIdSugestao()
    {
        return $this->id_sugestao;
    }

    public function setIdSugestao($id_sugestao): void
    {
        $this->id_sugestao = $id_sugestao;
    }

    public function getDataOcorrencia()
    {
        return $this->data_ocorrencia;
    }

    public function setDataOcorrencia($data_ocorrencia): void
    {
        $this->data_ocorrencia = $data_ocorrencia;
    }

    public function getDataEncaminhamento()
    {
        return $this->data_encaminhamento;
    }

    public function setDataEncaminhamento($data_encaminhamento): void
    {
        $this->data_encaminhamento = $data_encaminhamento;
    }

    public function getRelato()
    {
        return $this->relato;
    }

    public function setRelato($relato): void
    {
        $this->relato = $relato;
    }

    public function getDisciplina()
    {
        return $this->disciplina;
    }

    public function setDisciplina($disciplina): void
    {
        $this->disciplina = $disciplina;
    }

    public function getFrequencia()
    {
        return $this->frequencia;
    }

    public function setFrequencia($frequencia): void
    {
        $this->frequencia = $frequencia;
    }

    public function getSetor()
    {
        return $this->setor;
    }

    public function setSetor($setor): void
    {
        $this->setor = $setor;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status): void
    {
        $this->status = $status;
    }

    function getAluno(): Aluno
    {
        if(isset($this->Aluno)){
            return $this->Aluno;
        } else {
            if ($this->getIdAluno() == "") {
                return new Aluno();
            } else {
                $alunoPDO = new AlunoPDO();
                $this->Aluno = $alunoPDO->selectObjectByIdAluno($this->getIdAluno());
                return $this->Aluno;
            }
        }
    }

    function getMotivo(): SelectOption
    {
        if(isset($this->Motivo)){
            return $this->Motivo;
        }
        if ($this->getIdMotivo() == "") {
            return new SelectOption();
        } else {
            $selectOptionPDO = new SelectOptionPDO();
            $this->Motivo = $selectOptionPDO->selectObjectByIdOption($this->getIdMotivo());
            return $this->Motivo;
        }
    }

    function getSugestao(): SelectOption
    {
        if (isset($this->Sugestao)) {
            return $this->Sugestao;
        } else {
            if ($this->getIdSugestao() == "") {
                return new SelectOption();
            } else {
                $selectOptionPDO = new SelectOptionPDO();
                $this->Sugestao = $selectOptionPDO->selectObjectByIdOption($this->getIdSugestao());
                return $this->Sugestao;
            }
        }
    }

    function getRecurso(): SelectOption
    {
        if (isset($this->Recurso)) {
            return $this->Recurso;
        } else {
            if ($this->getIdRecurso() == "") {
                return new SelectOption();
            } else {
                $selectOptionPDO = new SelectOptionPDO();
                $this->Recurso = $selectOptionPDO->selectObjectByIdOption($this->getIdRecurso());
                return $this->Recurso;
            }
        }

    }

}