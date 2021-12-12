<?php

namespace TCC\Modelo;

use TCC\Modelo\Abstrato\Modelo;
use Ramsey\Uuid\Uuid;

class EmailBroadcast extends Modelo
{
    protected $id_email;
    protected $assunto;
    protected $conteudo;
    protected $prioridade;

    const PR_PRIORITARIO = 1;
    const PR_COMUM = 0;

    public function __construct()
    {
        if (func_num_args() != 0) {
            parent::__construct(func_get_args()[0]);
        }
        if($this->id_email==null || $this->id_email == ''){
            $this->id_email = Uuid::uuid4()->toString();
        }
    }

    public function getPrioridade()
    {
        return $this->prioridade;
    }

    public function setPrioridade($prioridade): void
    {
        $this->prioridade = $prioridade;
    }

    public function getIdEmail()
    {
        return $this->id_email;
    }

    public function setIdEmail($id_email): void
    {
        $this->id_email = $id_email;
    }

    public function getAssunto()
    {
        return $this->assunto;
    }

    public function setAssunto($assunto): void
    {
        $this->assunto = $assunto;
    }

    public function getConteudo()
    {
        return $this->conteudo;
    }

    public function setConteudo($conteudo): void
    {
        $this->conteudo = $conteudo;
    }

}