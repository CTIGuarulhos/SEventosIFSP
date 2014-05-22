<?php

class Banco {

    private $tipo = "mysql";
    private $host = "127.0.0.1"; // IP do banco
    private $bd = "snct"; // usu
    private $user = "snct"; // usu
    private $pass = "snctgrumct"; // senha

    public function conectar() {
        //Pega dados de conexão        

        $con = $this->tipo_bd($db);

        if ($con) {
            try {
                $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $con;
            } catch (PDOException $e) {
                $msg = "Erro de conexão com o banco de dados: Código: " . $e->getCode() . "Mensagem " . $e->getMessage() . "hora: " . date('H:i:s');
            }
            return ($con = false);
        }
    }

    // &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

    private function tipo_bd() {
        switch ($this->tipo) {
            case "mysql":
                $con = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->bd, $this->user, $this->pass, array(PDO::ATTR_PERSISTENT => true), array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
                break;
            case 'pgsql':
                $con = new PDO("pgsql:dbname={$bd};user={$user}; password={$pass};host=$host");
                break;
            case 'oci8':
                $tns = "(DESCRIPTION=(ADDRESS_LIST=(ADDRESS=(PROTOCOL=TCP)(HOST=" . $db['host'] . ")(PORT=1521)))(CONNECT_DATA=(SID=" . $db['bd'] . ")))";
                $con = new PDO("oci:dbname=" . $tns, $db['user'], $db['pass'], array(PDO::ATTR_PERSISTENT => true));
                break;
            case 'mssql':
                $con = new PDO("mssql:host={$host},1433;dbname={$bd}", $user, $pass);
                break;
        }return $con;
    }

}

?>
