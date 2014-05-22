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
    ?>

    <h1>RELATÓRIO DE EVENTOS</h1>
    <br/>
    <p>Aqui você pode ver todos os eventos separados por dia e as presenças já confirmadas</p>
    <?
    if (@mysql_num_rows($eventos) > 0):  //if 01

        while ($evento = mysql_fetch_array($eventos)):

            $query = "SELECT * FROM participacoes WHERE id_evento='{$evento['id']}' AND presenca=1";

            $presentes = @mysql_num_rows($DB->Query($query));

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
                    ?></table><br>
                    <table width=100%>
                        <tr>
                            <td colspan="4" width=85%><b><font size="5">TOTAL DE PRESENÇAS DO DIA</font></td>
                            <td><b><font size="5"><?= $soma ?></font></b></td>
                            <? $somatotal = $somatotal + $soma; ?>

                        </tr> <?
                        echo "</table></div></div>";
                        $soma = 0;
                    }
                    ?>
                    <div class="box-data">
                        <h1 class="evento-data"><?= $data_evento . ' - ' . $diaSemana[date('w', $ts_evento)] ?></h1>
                        <div class="evento">

                            <table class="sortable" width=100% border="0,5">

                                <tr>
                                    <td><b>CÓDIGO</b></td>
                                    <td width=50%><b>NOME</b></td>
                                    <td><b>HORA</b></td>
                                    <td><b>LOCAL</b></td>
                                    <td><b>PRESENÇAS</b></td>
                                </tr>
                                <?
                                $data = $evento['data'];
                            }
                            ?>  
                            <tr>
                                <td><?= $evento['id'] ?></td>
                                <td><?= $evento['titulo'] ?></td>
                                <td><?= substr($evento['hora'], 0, -3); ?></td>
                                <td><?= $evento['local'] ?></td>
                                <td><?= $presentes ?></td>
                                <? $soma = $soma + $presentes ?>
                            </tr>

                            <?
                        endwhile;
                        ?>  
                    </table>
                    <table width=100%>
                        <tr>
                            <td colspan="4" width=85%><b><font size="5">TOTAL DE PRESENÇAS DO DIA</font></b></td>
                            <? $somatotal = $somatotal + $soma; ?>
                            <td><b><font size="5"><?= $soma ?></font></b></td>
                        </tr>
                    </table></div></div><br><br>
            <table width=100%>
                <tr>
                    <td colspan="4" width=85%><b><font color="red" size="5">TOTAL DE PRESENÇAS DO EVENTO</font></b></td>
                    <td><b><font color="red" size="5"><?= $somatotal ?></font></b></td>
                </tr></table> <?
        else:  //if 01
            ?>

            <h3>Nenhum evento disponível</h3>
        <? endif  //if 01   ?>
    <? } ?>
    