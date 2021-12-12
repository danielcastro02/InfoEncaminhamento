<?php

namespace TCC\Modelo\Abstrato;

use TCC\Controle\Conexao;

class Modelo
{

    public function __construct()
    {
        if (func_num_args() != 0) {
            $atributos = func_get_args()[0];
            foreach ($atributos as $atributo => $valor) {
                if (isset($valor)) {
                    $this->$atributo = $valor;
                }
            }
        }
    }

    function atualizar($vetor)
    {
        foreach ($vetor as $atributo => $valor) {
            if (isset($valor)) {
                $this->$atributo = $valor;
            }
        }
    }


    function inserir($object)
    {
        $pdo = Conexao::getConexao();
        $chaves = "(";
        $valores = '(';
        $atribs = array_keys(get_class_vars(get_called_class()));

        foreach ($object as $chave => $valor) {
            if (in_array($chave, $atribs, false) && $valor != "") {
                $chaves = $chaves . $chave . ',';
                $valores = $valores . ':' . $chave . ',';
            }
        }
        $chaves = substr($chaves, 0, -1);
        $valores = substr($valores, 0, -1);
        $chaves = $chaves . ')';
        $valores = $valores . ')';
        $classe = get_class($object);
        $classe = explode('\\', $classe);
        $query = "insert into " . strtolower(end($classe)) . " " . $chaves . ' values ' . $valores;

        $stmt = $pdo->prepare($query);
        foreach ($object as $chave => $valor) {
            if (in_array($chave, $atribs, false) && $valor != "") {
                $stmt->bindValue(':' . $chave, $valor);
            }
        }
        return $stmt->execute();
    }

    public static function toArray(Object $object , bool $showNull = false, bool $showEmpty = false)
    {
        $vars = get_object_vars($object);
        $array = [];
        foreach ($vars as $nome => $valor){
            if($showNull || $valor !== null) {
                if ($showEmpty || $valor !== "") {
                    $array[$nome] = $valor;
                }
            }
        }
        return $array;
    }
}