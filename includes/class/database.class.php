<?php

#-------------------------------------------------------------------#
#            CLASSE PARA GERENCIAMENTO DO BANCO DE DADOS            #
#-------------------------------------------------------------------#

class MySQL_Connection {

    private $host, $user, $password, $database, $port = 3306;
    private $connection, $resource, $query;
    private $error_class, $error_code, $error_msg;
    private $conectado = false;

    /**
     * Metodo construtor
     * @param class $ConfigClass - classe de configuracao
     * @param bool $autoConnect - inicia conexao automatica
     */
    public function __construct($ConfigClass = false, $autoConnect = false) {
        if ($ConfigClass) {
            $this->setHost($ConfigClass->DB_HOST);
            $this->setUser($ConfigClass->DB_USER);
            $this->setPassword($ConfigClass->DB_PSWD);
            $this->setDataBase($ConfigClass->DB_NAME);
            $this->setPort($ConfigClass->DB_PORT);
            if ($autoConnect)
                $this->Connect();
        }
    }

    /**
     * Metodo destrutor
     * Fecha a conexao com o banco de dados
     */
    public function __destruct() {
        @mysql_close($this->resource);
    }

    #---------------------------------------------------------------#
    #                      METODOS PUBLICO                          #
    #---------------------------------------------------------------#

    /**
     * Inicia conexao com o servidor
     * @return true se conexao OK || false se conexao falhou
     */
    public function Connect() {
        //String de conexao (server host + porta)
        $stringHost = $this->host . ":" . $this->port;
        $this->connection = @mysql_connect($stringHost, $this->user, $this->password);
        mysql_set_charset("utf8", $this->connection);

        //Verifica conexao
        if (!$this->connection) {
            $this->error_class = "Falha ao se conectar com o servidor de banco de dados.";
            return false;
        }

        //Seleciona o banco
        if (!@mysql_select_db($this->database, $this->connection)) {
            $this->error_class = "Falha ao selecionar banco de dados.";
            return false;
        }

        $this->conectado = true;
        return true;
    }

    /**
     * Executa uma query SQL
     * @param string $sql_query
     * @return resource da query
     */
    public function Query($sql_query = false) {
        if ($sql_query !== false) {
            $this->setQuery($sql_query);
        }

        //Verifica conexao
        if (!$this->conectado) {
            if (!$this->Connect()) {
                $this->error_class = "Class error: conexão inexistente com o banco de dados.";
                return false;
            }
        }

        //Se tudo certo, retorna resource da consulta
        $this->resource = @mysql_query($this->query, $this->connection);
        if ($this->resource === false) {
            return false;
        } else {
            return $this->resource;
        }
    }

    /**
     * Retorna um array de array dos resultaos da última consulta
     * equivale a while($array = mysql_fetch_array($result)) { ... }
     * [@param string $sql_query] - opcional, se a query for passada como parametro será executada
     * 								antes e eao retornado seu array de resultados
     * @return array $array_result - array com cada linha retornada pela consulta 
     */
    public function FetchArray($sql_query = false) {
        if ($sql_query) {
            if (!$this->Query($sql_query))
                return false;
        }

        $result = $this->resource;
        $array_result = array();

        if (!mysql_num_rows($result))
            return false;

        while ($linha = mysql_fetch_array($result)) {
            $array_result[] = $linha;
        }

        return $array_result;
    }

    /**
     * Verifica se a conexao foi estabelecida
     * @return bool $this->conectado;
     */
    public function Connected() {
        return $this->conectado;
    }

    #---------------------------------------------------------------#
    #                      METODOS GET/SET                          #
    #---------------------------------------------------------------#

    public function getHost() {
        return $this->host;
    }

    public function setHost($_host) {
        //if (filter_var($_host, FILTER_VALIDATE_IP)) {
            $this->host = $_host;
        //} else {
        //    return false;
        //}
    }

    public function getUser() {
        return $this->user;
    }

    public function setUser($_user) {
        //TODO: Validação do nome de usuário
        $this->user = $_user;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($_pswd) {
        $this->password = $_pswd;
    }

    public function getDataBase() {
        return $this->database;
    }

    public function setDataBase($_database) {
        $this->database = $_database;
    }

    public function getPort() {
        return $this->port;
    }

    public function setPort($_port) {
        if (is_numeric($_port)) {
            $this->port = $_port;
        } else {
            return false;
        }
    }

    public function getQuery() {
        return $this->query;
    }

    public function setQuery($_query) {
        $this->query = $_query;
    }

    public function getErrorCode() {
        $this->error_code = mysql_errno($this->connection);
        return $this->error_code;
    }

    public function getErrorMsg() {
        $this->error_msg = mysql_error($this->connection);
        return $this->error_msg;
    }

    public function getErrorClass() {
        return $this->error_class;
    }

}

?>