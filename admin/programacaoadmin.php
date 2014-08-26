<?php
if (!$SESSION->IsLoggedIn()) {
    $Return_URL = "$CONFIG->URL_ROOT";
    header("Location: $Return_URL");
    unset($Return_URL);
}
if (tipoadmin(5, $USER->getCpf(), $SCT_ID)) {
    $query = "SELECT * FROM eventos WHERE semtec='" . $SCT_ID . "' ORDER BY `data`,hora";
    $eventos = $DB->Query($query);

//Apenas para controle de exibição
    $primeiro = true;

//Dias da semana
    $diaSemana = array('Domingo', 'Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sábado');

//$header['css'][] = array("href"=>CSS_DIR."/programacao.css", "media"=>"all");
    $deletarevento = safe_sql($_REQUEST['deletarevento']);
    $deletarpalestrante = safe_sql($_REQUEST['deletarpalestrante']);


    if (isset($deletarevento) AND strlen($deletarevento) > 0):
        require_once("eventoadmin_functions.php");
        deletar_evento($deletarevento);
        echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=$Esta_Pagina'>";
    endif;
    if (isset($deletarpalestrante) AND strlen($deletarpalestrante) > 0):
        require_once("eventoadmin_functions.php");
        deletar_palestrante($deletarpalestrante);
    //echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=$Esta_Pagina'>";
    endif;
    ?>

    <h1>EDITAR PROGRAMAÇÃO<span class="imgH1 geral"></span></h1>
    <br/>

    <p>
        Procure o dia e a atividade e selecione <img src="<?php echo $CONFIG->URL_ROOT ?>/includes/imgs/view.png" name="EDITAR" ALT="EDITAR" VALUE="EDITAR" title="EDITAR"> para editar e <img src="<?php echo $CONFIG->URL_ROOT ?>/includes/imgs/cancel.png" name="DELETAR" ALT="DELETAR" VALUE="DELETAR" title="DELETAR"> para excluir.
    <hr style="border:1px #a5a5a5 dashed;margin:15px 0px;" /><center>UTILIZE ESSA FERRAMENTA COM MUITO CUIDADO!</center> <br><br>
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

            $query = "SELECT * FROM participacoes WHERE id_evento='{$evento['id']}'";

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

                    <h2><?php echo $evento['id'] ?> - <?php echo $evento['titulo'] ?><?php if ($evento['tipo'] != 0): ?> - <b><?php echo $tipo[$evento['tipo']] ?></b><?php endif ?></h2><div>


                    </div>

                    <?php if (strlen($evento['descricao'])): ?>
                        <br/>
                        <p><?php echo nl2br($evento['descricao']) ?></p>
                    <?php endif ?>

                    <?php if ($evento['tipo']): ?>
                        <small style="float:right">Vagas: <?php echo $total_vagas - $inscritos ?> de <?php echo $total_vagas ?></small>
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
                            <form method="post" action="<?php echo $Esta_Pagina ?>">
                                <input type="hidden" name="deletarpalestrante" value="<?php echo $palestranteid['codigo'] ?>" />

                                <?php
                                $query = "SELECT codigo FROM part_palestrante WHERE cod_palestrante='{$palestrante['cod_palestrante']}' AND cod_palestra ='{$evento['id']}'";
                                $palestranteid = mysql_fetch_array($DB->Query($query));
                                ?>
                                <a href="<?php echo $CONFIG->URL_ROOT ?>/?pag=admcertificadopalestrante&id=<?php echo $evento['id'] ?>"><img src="<?php echo $CONFIG->URL_ROOT ?>/includes/imgs/print.png" name="Imprimir Certificado" ALT="Imprimir Certificado" VALUE="Imprimir Certificado" title="Imprimir Certificado"></a>
                                <input type="image" src="<?php echo $CONFIG->URL_ROOT ?>/includes/imgs/cancel.png" name="DELETAR" ALT="DELETAR" VALUE="DELETAR" title="DELETAR" onclick="alert('Você está excluindo o palestrante <?php echo $nomepalestrante['palestrante'] ?> do evento <?php echo $evento['id'] ?> - <?php echo $evento['titulo'] ?>')"><small><?php echo $nomepalestrante['palestrante'] ?></small><br>
                            </form>
                        <?php endwhile; ?>
                    <?php endif; ?>
                    <form method ="post" action="<?php echo $Esta_Pagina ?>">
                        <input type="hidden" name="deletarevento" value="<?php echo $evento['id'] ?>" />
                        <!--<a href="<?php echo $CONFIG->URL_ROOT ?>/?pag=adminscreverpale&evento=<?php echo $evento['id'] ?>">Adicionar Palestrante</a>-->

                        <br/>	
                        <div class="right"><a href="<?php echo $CONFIG->URL_ROOT ?>/?pag=admeventoedit&id=<?php echo $evento['id'] ?>"><img src="<?php echo $CONFIG->URL_ROOT ?>/includes/imgs/view.png" name="EDITAR" ALT="EDITAR" VALUE="EDITAR" title="EDITAR"></a>&nbsp;&nbsp;<input type="image" src="<?php echo $CONFIG->URL_ROOT ?>/includes/imgs/cancel.png" name="DELETAR" ALT="DELETAR" VALUE="DELETAR" title="DELETAR" onclick="alert('Você está excluindo o evento <?php echo $evento['id'] ?> - <?php echo $evento['titulo'] ?><?php if ($evento['tipo'] != 0): ?> - <?php echo $tipo[$evento['tipo']] ?><?php endif ?>')">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div><br>

                        <small>Data: <?php echo $data_evento ?>&nbsp;&nbsp;<b>|</b>&nbsp;&nbsp;Horário: <?php echo $hora_evento ?>&nbsp;&nbsp;<b>|</b>&nbsp;&nbsp;Duração aprox.: <?php echo $evento['duracao'] ?> min.</small>
                    </form></div>

                <?php
            endwhile;
            echo "</div>";
        else:  //if 01
            ?>

            <h3>Nenhum evento disponível</h3>
        <?php endif  //if 01  ?>
    <?php } ?>
    