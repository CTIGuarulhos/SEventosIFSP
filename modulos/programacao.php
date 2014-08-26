<?php
$query = "SELECT * FROM eventos WHERE semtec='" . $SCT_ID . "' ORDER BY `data`,hora";
$eventos = $DB->Query($query);

//Apenas para controle de exibição
$primeiro = true;

//Dias da semana
$diaSemana = array('Domingo', 'Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sábado');

//$header['css'][] = array("href"=>CSS_DIR."/programacao.css", "media"=>"all");
?>

<h1>Programação<span class="imgH1 geral"></span></h1>
<br/>

<p>
    Consulte aqui os eventos d<?php echo $EVENTO['GENERO'] ?> <?php echo $EVENTO['NOME'] ?>.
    Não se esqueça de realizar inscrição nos eventos escolhidos e assinar a
    lista de presença no dia para garantir o direito ao certificado.
    <br><br>
    Lembramos também que o evento estará liberado para lista de espera
    <?php echo $EVENTO['LIBERACAO'] ?> minutos antes do inicio do evento.
    <br><br>
    Pedimos aos participantes que compareçam ao local do evento de 
    <?php echo $EVENTO['LIBERACAO'] + 20 ?> à <?php echo $EVENTO['LIBERACAO'] ?> 
    minutos antes do início para que sua vaga esteja garantida.



</p>

<p>
    <?php echo substituir_acentos($CONFIG->PROGRAMACAO) ?>
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

<?php
if (@mysql_num_rows($eventos) > 0):  //if 01

    while ($evento = mysql_fetch_array($eventos)):

        $query = "SELECT * FROM participacoes WHERE id_evento='{$evento['id']}' and tipo='P'";

        $inscritos = @mysql_num_rows($DB->Query($query));
        $total_vagas = $evento['vagas'];

        $dt = date_create($evento['data']);         //datetime
        $data_evento = date_format($dt, "d/m/Y");   //string - data do evento
        $hora_evento = substr($evento['hora'], 0, 5); //string - hora do evento
        $ts_evento = mktime(23, 59, 59, date_format($dt, "m"), date_format($dt, "d"), date_format($dt, "Y"));  //timestamp da data do evento
        //$ts_evento = $DATA_MAX; //Prazo máximo para inscrições

        if ($inscritos < $total_vagas) {
            if (time() < $ts_evento)
                $inscricoes_abertas = true;
            else
                $inscricoes_abertas = "Inscri&ccedil;&otilde;es encerradas";
        } else {
            $inscricoes_abertas = "Vagas esgotadas";
        }

        $tipo = array('', 'Palestra', 'Mini-curso', 'Mesa redonda', 'Seção Oral', 'Oficina');

        if ($data != $evento['data']) {
            if ($primeiro) {
                $primeiro = false;
            } else {
                echo "</div>";
            }
            ?>

            <div class="box-data">
                <h1 class="evento-data"><?php echo $data_evento . ' - ' . $diaSemana[date('w', $ts_evento)] ?></h1>
                <?php
                $data = $evento['data'];
            }
            ?>

            <div class="evento">
                <h2><?php echo $evento['titulo'] ?><?php if ($evento['tipo'] != 0): ?> - <b><?php echo $tipo[$evento['tipo']] ?></b><?php endif ?></h2>

                <?php if (strlen($evento['descricao'])): ?>
                    <br/>
                    <p><?php echo nl2br($evento['descricao']) ?></p>
                <?php endif ?>

                <?php if ($evento['tipo']): ?>
                    <?php if (($total_vagas - $inscritos) > 0): ?>
                        <small style="float:right">Vagas: <?php echo $total_vagas - $inscritos ?> de <?php echo $total_vagas ?></small>
                    <?php endif ?>
                <?php endif ?>
                <small>Local: <?php echo $evento['local'] ?></small>
                <?php
                $query = "SELECT cod_palestrante FROM part_palestrante WHERE cod_palestra='{$evento['id']}'";
                $palestrantes = $DB->Query($query);
                if (@mysql_num_rows($palestrantes) > 0):  //if 01
                    if (@mysql_num_rows($palestrantes) == 1):  //if 01 
                        ?>
                        <br><small>Palestrante:</small>
                    <?php else : ?>
                        <br><small>Palestrantes:</small>
                    <?php endif; ?>
                    <?php while ($palestrante = mysql_fetch_array($palestrantes)): ?>
                        <?php
                        $query = "SELECT palestrante FROM palestrante WHERE codigo='{$palestrante['cod_palestrante']}'";
                        $nomepalestrante = mysql_fetch_array($DB->Query($query));
                        ?>
                        <small><?php echo $nomepalestrante['palestrante'] ?></small><br>
                    <?php endwhile; ?>
                <?php endif; ?>

                <br/>
                <?php if ($inscricoes_abertas === true): ?>
                    <a class="inscricao" href="<?php echo $CONFIG->URL_ROOT ?>/inscrevase.php?evento=<?php echo $evento['id'] ?>">INSCREVA-SE</a>
                <?php else: ?>
                    <?php if ($evento['tipo']): ?>
                        <small style="float:right"><?php echo $inscricoes_abertas ?></small>
                    <?php endif ?>
                <?php endif ?>
                <small>Data: <?php echo $data_evento ?>&nbsp;&nbsp;<b>|</b>&nbsp;&nbsp;Horário: <?php echo $hora_evento ?>&nbsp;&nbsp;<b>|</b>&nbsp;&nbsp;Duração aprox.: <?php echo $evento['duracao'] ?> min.</small>
            </div>

            <?php
        endwhile;
        echo "</div>";
    else:  //if 01
        ?>
        <?php if (strlen($EVENTO['PALESTRANTESCONFIRMADOS']) > "5"): ?>
            <div class="box-data">
                <h1 class="evento-data">Palestrantes Confirmados</h1>
                <div class="evento">
                    <?php echo substituir_acentos($EVENTO['PALESTRANTESCONFIRMADOS']) ?>
                </div>
            </div>
        <?php endif; ?><br><br>
        <h3>Em Construção</h3>
        <!--<h3>Nenhum evento disponível</h3> -->
                                                                                                                <?php endif  //if 01 ?>
