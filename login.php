<?php

require_once("initialize.php");

//Se já estiver logado redireciona:
if ($SESSION->IsLoggedIn()) {
    header("Location: {$CONFIG->URL_ROOT}");
    exit;
}

//Recupera CPF e SENHA
$cpf = safe_sql($_POST['login']);
//$cpf	= str_replace(".", "", str_replace("-", "", $cpf));
$senha = md5(safe_sql($_POST['senha']));
$redir = $_POST['redir'];
$query = "SELECT * FROM participantes WHERE email='$cpf'";

//Consulta SQL
$DB->Query($query);
$result = $DB->FetchArray();

//Verifica usuario e senha
if ($result) {

    $result = $result[0];
    if ($senha == $result['senha']) {

        //if($result['confirmado']) {

        $array['cpf'] = $result['cpf'];  // CPF do usuário
        $array['nome'] = $result['nome'];  // Nome do usuário (servidor/funcionário)
        $array['email'] = $result['email'];  // Email do usuário
        $array['permissao'] = $result['permissao']; // Nivel de permissão do usuário

        $USER = new User($array);
        $_SESSION['USER'] = $USER;
        header("Location: {$redir}");
        if (!$result['confirmado']) {
            $_SESSION['temp']['erro_login'] = 3;
        }

        exit;

        //} else {
        //Usuario pendente de confirmação
        //	$_SESSION['temp']['erro_login'] = 3;
        //	header("Location: {$redir}");
        //	exit;
        //}
    } else {

        //Senha incorreta
        $_SESSION['temp']['erro_login'] = 2;
        header("Location: {$redir}");
        exit;
    }
} else {

    //Usuario nao cadastrado
    $_SESSION['temp']['erro_login'] = 1;
    header("Location: {$redir}");
    exit;
}
?>