<?php
require "initialize.php";
//Verifica se o usuário está logado
if (!$SESSION->IsLoggedIn()) {
    header('Location: ' . $CONFIG->URL_ROOT . '/?pag=cadastro');
}

//Resgata os parametros
$CPF = $USER->getCpf();
$evento = safe_sql($_REQUEST['evento']);


//Query SQL
$query = "SELECT * FROM participacoes WHERE cpf_participante='$CPF' AND id_evento='$evento'";
$result = $DB->Query($query);


//Verifica inscrição no evento
if (mysql_num_rows($result) <= 0)
    die("Inscrição para o evento inexistente.");


//Verifica presenca
$result = mysql_fetch_array($result);
$presenca = $result['presenca'] == 1 ? true : die('Presença não confirmada.');


//Atualiza data de visualização
$query = "UPDATE participacoes SET data_visualizacao=Now() WHERE cpf_participante='$CPF' AND id_evento='$evento'";
$DB->Query($query);


//Recupera o título e tipo do evento
$query = "SELECT UPPER(titulo) as 'titulo',tipo, data, hora, duracao FROM eventos WHERE id='$evento' AND semtec='$SCT_ID'";
$result = $DB->Query($query) or die('Falha ao selecionar evento (1).');
$result = mysql_num_rows($result) ? mysql_fetch_array($result) : die('Falha ao selecionar evento (2).');
$titulo = $result['titulo'];
$tipo = $result['tipo'];
$duracao = $result['duracao'];
$dt = date_create($result['data']);         //datetime
$dia = date_format($dt, "d");   //string - data do evento
$mes = date_format($dt, "m");   //string - data do evento
switch ($mes) {

    case 1: $mes = "Janeiro";
        break;
    case 2: $mes = "Fevereiro";
        break;
    case 3: $mes = "Março";
        break;
    case 4: $mes = "Abril";
        break;
    case 5: $mes = "Maio";
        break;
    case 6: $mes = "Junho";
        break;
    case 7: $mes = "Julho";
        break;
    case 8: $mes = "Agosto";
        break;
    case 9: $mes = "Setembro";
        break;
    case 10: $mes = "Outubro";
        break;
    case 11: $mes = "Novembro";
        break;
    case 12: $mes = "Dezembro";
        break;
}
$ano = date_format($dt, "Y");   //string - data do evento
if ($tipo == 2)
    $tipo = "do mini-curso";
elseif ($tipo == 3)
    $tipo = "da mesa redonda";
else
    $tipo = "da palestra";


//Recupera o nome do participante
$query = "SELECT UPPER(nome) as 'nome', documento FROM participantes WHERE cpf='$CPF'";
$result = $DB->Query($query) or die('Falha ao selecionar participante (1).');
$result = mysql_num_rows($result) ? mysql_fetch_array($result) : die('Falha ao selecionar participante (2).');
$nome = $result['nome'];
$documento = $result['documento'];
$doc = $CPF;
//Formata o CPF
if ($documento == "sim") {
    $CPF = substr($CPF, 0, 3) . "." . substr($CPF, 3, 3) . "." . substr($CPF, 6, 3) . "-" . substr($CPF, 9, 2);
}

$textocertificado = "Certifico que <b>" . $nome . "</b>";
if ($documento == "sim") {
    $textocertificado .= " CPF <b>" . $CPF . "</b>";
} else {
    $textocertificado .= " RG <b>" . $CPF . "</b>";
}
$textocertificado .= " participou " . $tipo . " intitulad" . substr($tipo, -1, 1);
$textocertificado .= " <b>" . $titulo . "</b> durante " . $EVENTO['GENERO'] . " <b>" . $EVENTO['NOME'];
$textocertificado .= "</b> realizada no dia " . $dia . " de " . $mes . " de " . $ano;
$textocertificado .= " com duração de " . $duracao . " minutos.";


$textoparahash = "Documento ";
if ($documento == "sim") {
    $textoparahash .= " CPF " . $CPF;
} else {
    $textoparahash .= " RG " . $CPF;
}
$textoparahash .= " participou " . $evento;
$textoparahash .= " durante " . $EVENTO['SEMTEC'];
$textoparahash = md5($textoparahash);

$query = "UPDATE participacoes SET verificacao='$textoparahash' WHERE cpf_participante='$doc' AND id_evento='$evento' AND presenca='1'";
$DB->Query($query);
$codigovalidacao = "<font size='1' style='line-height:1; font-weight:bold;'>Código de validação " . $textoparahash . "<br>A autenticidade deste certificado pode ser confirmada na Internet, através do endereço " . $CONFIG->URL_ROOT . ".</font>";

//$textoparahash= substr($textoparahash, 0, 4) . "-" . substr($textoparahash, 4, 4) . "-" . substr($textoparahash, 8, 4) . "-" . substr($textoparahash, 12, 4) . "-" . substr($textoparahash, 16, 4) . "-" . substr($textoparahash, 20, 4) . "-" . substr($textoparahash, 24, 4) . "-" . substr($textoparahash, 28, 4);

$assinaturaparticipante = $nome . "<br>" . $CPF;
$assinaturainstituicao = $EVENTO['NOME_INST_COMP'];
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="pt-BR">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=<?php echo $CONFIG->CHARSET ?>" />
        <meta http-equiv="content-language" content="pt-br" />
        <meta name="author" content="IFSP - Campus São Carlos + IFSP - Campus Guarulhos"/>
        <meta name="robots" content="noindex,nofollow" />
        <script type="text/javascript" src="<?php echo $CONFIG->URL_ROOT ?>/includes/js/jquery.js"></script>
        <script type="text/javascript" src="<?php echo $CONFIG->URL_ROOT ?>/includes/js/certificado.js"></script>
        <link rel="stylesheet" href="<?php echo $CONFIG->URL_ROOT ?>/templates/<?php echo $EVENTO['TEMPLATE'] ?>/css/certificado.css" media="all" />
        <link href='http://fonts.googleapis.com/css?family=Roboto:400,400italic,700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>   
            <title><?php echo $EVENTO['NOME'] ?> - CERTIFICADO</title>

            <style type="text/css" media="print">
                .noprint { display: none; }
                #pagina { border-color: #ffffff; }
            </style>
            <style type="text/css">
                <!--
                .espaco {	
                    line-height: 20px;
                }
                .justificado {	
                    text-align: justify
                }
                -->
            </style>
    </head>


    <body>


        <div id="instrucoes" class="noprint">

            <br/>
            <center><p id="link"><big><big><big><span style="color: rgb(255, 0, 0);">LEIA ANTES DE IMPRIMIR:</span></big></big></big></p></center>

            <div class="esquerda">
                <b>Internet Explorer 6 ou superior:</b>
                <ol type="1">
                    <li>Na barra de menu, clique em <b>Ferramentas</b> &gt;&gt; <b>Opções da internet</b>. Na guia <b>Avançadas</b> marque a opção "imprimir cores e imagens do plano de fundo". Clique no botão <b>OK</b>.</li>
                    <li>
                        Na barra de menu, clique em <b>Arquivo</b> &gt;&gt; <b>Configurar página</b>. Marque as opções de acordo com as especificações abaixo:
                        <ul>
                            <li>Tamanho: A4;</li>
                            <li>Retire o conteúdo dos campos cabeçalho e rodapé. Deixe-os em branco. (opcional);</li>
                            <li>Orientação: Paisagem;</li>
                            <li>Margens: 0 (esquerda, direita, superior e inferior);</li>
                            <li>Clique no botão <b>OK</b>.</li>
                        </ul>
                    </li>
                    <li>Nas opções avançadas de impressão você deve colocar em escala 117%</li>
                </ol>
            </div>

            <div class="direita">
                <b>Mozilla Firefox:</b>
                <ol type="1">
                    <li>Na barra de menu, clique em <b>Arquivo</b> &gt;&gt; <b>Configurar página...</b></li>
                    <li>
                        Na guia <b>Geral</b> marque as opções de acordo com as especificações abaixo:
                        <ul>
                            <li>Orientação: Paisagem;</li>
                            <li>Escala: 118;</li>
                            <li>Marque a opção "imprimir cores e imagens do plano de fundo".</li>
                        </ul>
                    </li>
                    <li>
                        Na guia <b>Margens</b> marque as opções de acordo com as especificações abaixo:
                        <ul>
                            <li>Margens: 0 (esquerda, direita, superior e inferior);</li>
                            <li>Cabeçalho e rodapé: marque todas as opções "--em branco--" (opcional);</li>
                            <li>Clique no botão <b>OK</b>.</li>
                        </ul>
                    </li>
                </ol>
            </div>


            <center style="margin-bottom:10px;">
                <input type="button" value="IMPRIMIR" onclick="javascript:window.print();" style="margin-right:100px;" />
                <input type="button" value="FECHAR" onclick="javascript:window.close();" />
            </center>

        </div>


        <center>
            <div id="pagina">
                <div id="texto"><table style="text-align: left; width: 100%;"
                                       border="0" cellpadding="2" cellspacing="2">
                        <tbody>
                            <tr>
                                <td style="width: 25%"></td>
                                <td style="width: 75%">
                                    <?php require($CONFIG->DIR_ROOT . "/templates/" . $EVENTO['TEMPLATE'] . "/certificado.php"); ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </center>


    </body>
</html>
