<?php


namespace TCC\Modelo;
class Endereco
{
    private $id_endereco;
    private $cep;
    private $estado;
    private $cidade;
    private $bairro;
    private $rua;
    private $numero;
    private $complemento;
    private $id_entidade;

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

    public function getEnderecoArray()
    {
        $cepExplode = explode('-', $this->cep);

        if(isset($cepExplode[1])) {
            $cep = $cepExplode[0].$cepExplode[1];
        } else {
            $cep = $cepExplode[0];
        }
        return array(
            "bairro" => strval($this->bairro),
            "cep" => intval($cep),
            "logradouro" => strval($this->rua),
            "numero" => intval($this->numero),
            "municipio" => strval($this->cidade),
            "uf" => strval($this->estado),
        );
    }

    public function getIdEndereco()
    {
        return $this->id_endereco;
    }

    public function setIdEndereco($id_endereco)
    {
        $this->id_endereco = $id_endereco;
    }

    public function getCep()
    {
        return $this->cep;
    }

    public function setCep($cep)
    {
        $this->cep = $cep;
    }

    public function getEstado()
    {
        return $this->estado;
    }

    public function setEstado($estado)
    {
        $this->estado = $estado;
    }

    public function getCidade()
    {
        return $this->cidade;
    }

    public function setCidade($cidade)
    {
        $this->cidade = $cidade;
    }

    public function getBairro()
    {
        return $this->bairro;
    }

    public function setBairro($bairro)
    {
        $this->bairro = $bairro;
    }

    public function getNumero()
    {
        return $this->numero;
    }

    public function setNumero($numero)
    {
        $this->numero = $numero;
    }

    public function getComplemento()
    {
        return $this->complemento;
    }

    public function setComplemento($complemento)
    {
        $this->complemento = $complemento;
    }

    public function getIdEntidade()
    {
        return $this->id_entidade;
    }

    public function setIdEntidade($id_entidade)
    {
        $this->id_entidade = $id_entidade;
    }

    public function getRua()
    {
        return $this->rua;
    }

    public function setRua($rua)
    {
        $this->rua = $rua;
    }
}