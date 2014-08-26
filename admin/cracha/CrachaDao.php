<?php

require_once 'Banco.php';

class CrachaDao {

    private $nome;
    public $cpf;
    private $instituicao;
    private $tipoParticipante;

    function __construct() {
        $this->cpf = $_GET[cpf];
    }

    public function getParticipante() {
        $campos = "p.nome, ";
        $sql = "SELECT DISTINCT " . $campos . " FROM participantes p";
        //$sql .= " LEFT JOIN instituicao i ON p.idInstituicao=i.idInstituicao";
        //$sql .= " LEFT JOIN tipoParticipante tp ON p.idTipoParticipante=tp.idTipoParticipante";
        $sql .= " WHERE p.cpf=" . $this->cpf;
        $msg = false;
        $banco = new Banco();
        $con = $banco->conectar();
        $rs = "";
        if ($con) {
            try {
                $rs = $con->prepare($db[sql], array());
                $rs->execute();
                $res = $rs->fetchAll();
            } catch (Exception $e) {
                $msg = "Erro: Código: " . $e->getCode() . "Mensagem " . $e->getMessage();
            }
        } else {
            if (!$retorno)
                $retorno = $msg;
        }
        $banco = null;
        return $rs;
    }

}

$crachaDao = new CrachaDao();
