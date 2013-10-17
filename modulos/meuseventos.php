<?
//Verifica se o usuário está logado
if (!$SESSION->IsLoggedIn()) {
    header('Location: ' . $CONFIG->URL_ROOT . '/?pag=cadastro');
    exit;
}

#---------------------------------------------------------------------------#
$query = "SELECT p.* FROM participacoes p, eventos e WHERE p.cpf_participante='{$USER->getCpf()}' ";
$query .= "AND p.id_evento IN (SELECT id FROM eventos WHERE semtec='" . $SCT_ID . "') AND p.id_evento=e.id ";
$query .= "ORDER BY e.data, e.hora";
$result = $DB->Query($query);
#---------------------------------------------------------------------------# 
//Apenas para controle de exibição
$primeiro = true;

//Dias da semana
$diaSemana = array('Domingo', 'Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sábado');

//$header['css'][] = array("href"=>CSS_DIR."/meuseventos.css", "media"=>"all");
?>


<h1>Meus Eventos<span class="imgH1 geral"></span></h1>
<br/>

<p>
    Aqui estar&atilde;o listados todos os eventos que voc&ecirc; se inscreveu.
    <br/>
    As inscri&ccedil&otilde;es poder&atilde;o ser canceladas at&eacute; &agrave;s 18h00 do dia do evento.
</p>

<?php
if (isset($_SESSION['temp']['inscricaoOK'])) {
    if ($_SESSION['temp']['inscricaoOK'] == true)
        HTML_SuccessMessage($_SESSION['temp']['inscricaoMSG']);
    else
        HTML_ErrorMessage($_SESSION['temp']['inscricaoMSG']);
    //Destroi as variaveis temporárias
    unset($_SESSION['temp']['inscricaoOK']);
    unset($_SESSION['temp']['inscricaoMSG']);
}
?>

<? if (@mysql_num_rows($result) <= 0): ?>

    <i>Voc&ecirc; ainda n&atilde;o se inscreveu em nenhum evento.</i>

<? else: ?>

    <?
    while ($x = mysql_fetch_array($result)):
        $eventoID = $x['id_evento'];
        $query = "SELECT * FROM eventos where id='$eventoID'";
        $evento = mysql_fetch_array($DB->Query($query));

        $dt = date_create($evento['data']);         //datetime
        $data_evento = date_format($dt, "d/m/Y");   //string - data do evento
        $hora_evento = substr($evento['hora'], 0, 5); //string - hora do evento				
        $ts_evento = mktime(23, 59, 59, date_format($dt, "m"), date_format($dt, "d"), date_format($dt, "Y"));  //timestamp da data do evento
        //$ts_evento = $DATA_MAX; //Prazo máximo para inscrições

        if (time() < $ts_evento)
            $inscricoes_abertas = true;
        else
            $inscricoes_abertas = false;

        $tipo = array('', 'Palestra', 'Mini-curso', 'Mesa redonda', 'Se&ccedil;&atilde;o Oral', 'Oficina');

        if ($data != $evento['data']): //if 02
            if ($primeiro) {
                $primeiro = false;
            } else {
                echo "</div>";
            }
            ?>

            <div class="box-data">
                <h1 class="evento-data"><?= $data_evento . ' - ' . $diaSemana[date('w', $ts_evento)] ?></h1>
                <?
                $data = $evento['data'];
            endif; //if 02
            ?>

            <div class="evento">
                <h2><?= $evento['titulo'] ?> - <b><?= $tipo[$evento['tipo']] ?></b></h2>

                <? if (strlen($evento['descricao'])): ?>
                    <br/>
                    <p><?= nl2br($evento['descricao']) ?></p>
                <? endif ?>

                <small>Local: <?= $evento['local'] ?></small>
                <br/>
                <? if ($inscricoes_abertas === true): ?>
                    <a class="cancelar-inscricao" href="<?php echo $CONFIG->URL_ROOT ?>/cancelar-inscricao.php?evento=<?= $evento['id'] ?>">CANCELAR INSCRI&Ccedil&Atilde;O</a>
                <? endif ?>
                <small>Data: <?= $data_evento ?>&nbsp;&nbsp;<b>|</b>&nbsp;&nbsp;Horário: <?= $hora_evento ?>&nbsp;&nbsp;<b>|</b>&nbsp;&nbsp;Dura&ccedil&atilde;o aprox.: <?= $evento['duracao'] ?> min.</small>
            </div>

        <? endwhile ?>
        <? echo "</div>"; ?>
<? endif ?>