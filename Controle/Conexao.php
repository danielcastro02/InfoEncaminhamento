<?php
namespace TCC\Controle;

use Exception;
use TCC\Modelo\Parametros;
use PDO;

class Conexao {

    private static $con;

    public static function getConexao(): PDO {
        $parametros = new Parametros();
        try {
            if (is_null(self::$con)) {
                self::$con = new PDO('mysql:host=ciet.svs.iffarroupilha.edu.br:3306;dbname='.$parametros->getNomeDb(), 'grissetti', '4*Lb#$M2', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            }
            return self::$con;
        } catch (Exception $e) {
            echo "<h1>FALHA GERAL CONTATE O SUPORTE contato@markeyvip.com</h1>";
            exit(0);
        }
    }

    public static function getTransactConnetion(): PDO {
        $parametros = new Parametros();
        try {
            return new PDO('mysql:host=ciet.svs.iffarroupilha.edu.br:3306;dbname='.$parametros->getNomeDb(), 'grissetti', '4*Lb#$M2', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        } catch (\Exception $e) {
            echo "<h1>FALHA GERAL CONTATE O SUPORTE contato@markeyvip.com</h1>";
            exit(0);
        }
    }

}
