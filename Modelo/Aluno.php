<?php

namespace TCC\Modelo;

use TCC\Controle\SelectOptionPDO;
use TCC\Modelo\Abstrato\Modelo;

class Aluno extends Modelo
{
    protected $id_aluno;
    protected $nome;
    protected $apelido;
    protected $id_turma;

    public function getIdAluno()
    {
        return $this->id_aluno;
    }

    public function setIdAluno($id_aluno): void
    {
        $this->id_aluno = $id_aluno;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setNome($nome): void
    {
        $this->nome = $nome;
    }

    public function getApelido()
    {
        return $this->apelido;
    }

    public function setApelido($apelido): void
    {
        $this->apelido = $apelido;
    }

    public function getIdTurma()
    {
        return $this->id_turma;
    }

    public function setIdTurma($id_turma): void
    {
        $this->id_turma = $id_turma;
    }

    function getTurma():SelectOption{
        if(isset($this->Turma)){
            return $this->Turma;
        }else {
            if ($this->getIdTurma() == "") {
                return new SelectOption();
            } else {
                $selectOptionPDO = new SelectOptionPDO();
                $this->Turma = $selectOptionPDO->selectObjectByIdOption($this->getIdTurma());
                return $this->Turma;
            }
        }
    }

}