<?php

#-------------------------------------------------------------------#
#     CARREGA OS ARQUIVOS E CONFIGURAÇÕES NECESSÁRIOS DO SISTEMA    #
#-------------------------------------------------------------------#
//Configurações do PHP
setlocale(LC_ALL, 'pt_BR'); //
date_default_timezone_set("America/Sao_Paulo");
$meses = array('Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro');
ini_set("register_globals", 0);
ini_set("magic_quotes_gpc", 0);
ini_set("magic_quotes_runtime", 0);
ini_set("magic_quotes_sybase", 0);
ini_set("display_errors", 0);

//Descomentar estas 2 linhas abaixo para efetuar testes
//ini_set("display_errors", 1);
//ini_set("error_reporting", E_ALL & ~E_NOTICE);
//Classe de configuração
if (file_exists("includes/configuration.php")) {
    require("includes/configuration.php");
} elseif (file_exists("../includes/configuration.php")) {
    require("../includes/configuration.php");
} elseif (file_exists("../../includes/configuration.php")) {
    require("../../includes/configuration.php");
} elseif (file_exists("../../../includes/configuration.php")) {
    require("../../../includes/configuration.php");
} else {
    echo "&Eacute; necess&aacute;rio configurar o sistema primeiramente";
    exit();
}
$CONFIG = new Config();


//Classe de banco de dados MySQL
require $CONFIG->DIR_ROOT . "/includes/class/database.class.php";
$DB = new MySQL_Connection($CONFIG, true);
if (!$DB->Connected())
    die("Error: <i>{$DB->getErrorClass()}</i>");

//Classe de controle de usuário
require $CONFIG->DIR_ROOT . "/includes/class/user.class.php";

//Classe de controle de sessão
require $CONFIG->DIR_ROOT . "/includes/class/session.class.php";
$SESSION = new Session($CONFIG);

//Recupera objeto do usuario
if (isset($_SESSION['USER'])) {
    $USER = & $_SESSION['USER'];
} else {
    $USER = false;
}


#-------------------------------------------------------------------#
#                             FUNCTIONS                             #
#-------------------------------------------------------------------#
//HTML functions
require $CONFIG->DIR_ROOT . "/includes/html-functions.php";


#safe_sql($var) - filtrar string sql passadas por get/post/cookie
require $CONFIG->DIR_ROOT . "/includes/safe_sql.php";

//Função para validar se banco de dados esta preenchido com algo
$query = "SELECT COUNT(*) as total FROM information_schema.tables WHERE table_schema = '$CONFIG->DB_NAME';";
$tabelas = mysql_fetch_assoc($DB->Query($query));
if ($tabelas['total'] <= 6) {
    echo "Voc&ecirc; deve importar o arquivo BD.sql";
    exit();
}

//Função para adicionar usuario admin se não existir nenhum usuário
$query = "SELECT * FROM participantes";
//$result = $DB->Query($query);
//$usuarios = mysql_fetch_array($DB->Query($query));
if (mysql_num_rows($DB->Query($query)) <= 0) {

    $query = "INSERT IGNORE INTO `participantes` (`cpf`, `documento`, `nome`, `rg`, `rua`, `numero`, `complemento`, "
            . "`bairro`, `cidade`, `estado`, `pais`, `cep`, `inst_empresa`, `telefone`, `tel_celular`, `email`, `senha`, "
            . "`data_inscricao`, `tipo`, `RA`, `cod_confirmacao`, `confirmado`, `admin`, `eventos`) VALUES ('0', 'sim', "
            . "'Administrador', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'admin', "
            . "'21232f297a57a5a743894a0e4a801fc3', '1980-01-01 00:00:00', NULL, NULL, NULL, '1', '8', NULL);";
    $result = $DB->Query($query);
}

//Função para Limpar GET se evento não existe
if (isset($_GET['SCT'])) {
    $SEMTEC = $_GET['SCT'];
    $query = "SELECT SEMTEC FROM edicao WHERE SEMTEC = '$SEMTEC'";
    if (mysql_num_rows($DB->Query($query)) <= 0) {
        unset($_GET['SCT']);
    }
}

//Função para Criar Dados de Novo evento
if (isset($_GET['SCT'])) {
    $SCT_ID = $_GET['SCT'];
} else {
    $SCT_ID = $CONFIG->SCT_ID;
}
$query = "SELECT SEMTEC FROM edicao WHERE SEMTEC = '$SCT_ID'";
if (mysql_num_rows($DB->Query($query)) <= 0) {
    $query = "INSERT INTO edicao(SEMTEC) VALUES('$SCT_ID')";
    $result = $DB->Query($query);
}
$query = "SELECT * FROM edicao WHERE SEMTEC = '$SCT_ID'";
$EVENTO = mysql_fetch_array($DB->Query($query));
if (!file_exists($CONFIG->DIR_ROOT . "/templates/" . $EVENTO['TEMPLATE']) and ! is_dir($dir)) {
    $EVENTO['TEMPLATE'] = "Default";
}
?>