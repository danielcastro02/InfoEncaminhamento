<?php


namespace TCC\Modelo;
class Centrolucro
{
    private $id_centrolucro;
    private $id_entidade;
    private $nome;
    private $ativo;

    const CENTRO_LUCRO = 1;

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

    public function getIdCentrolucro()
    {
        return $this->id_centrolucro;
    }

    public function setIdCentrolucro($id_centrolucro)
    {
        $this->id_centrolucro = $id_centrolucro;
    }

    public function getIdEntidade()
    {
        return $this->id_entidade;
    }

    public function setIdEntidade($id_entidade)
    {
        $this->id_entidade = $id_entidade;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function getAtivo()
    {
        return $this->ativo;
    }

    public function setAtivo($ativo)
    {
        $this->ativo = $ativo;
    }
}