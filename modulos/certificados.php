<?php
#------------------------ VERIFICA SE ESTÁ LOGADO ----------------------------#
if (!$SESSION->IsLoggedIn()) {
    ?>
    <h1>Certificados<span class="imgH1 geral"></span></h1>		
    <div class="box">
        <p >
            Os certificados da <?php echo $EVENTO['NOME'] ?> do <?php echo $EVENTO['NOME_INST_RED'] ?> já estão disponíveis online.
        </p>
        <p >
            Para visualizar, acesse sua conta através do seu e-mail e senha no campo ao lado esquerdo da página e clique no menu <b>Certificados</b>.
            Caso não lembre sua senha, utilize o link de recuperar senha <a href="javascript:RecuperarSenha();">clicando aqui</a>.
        </p>
        <p >
            Lembrando que só terão direito aos certificados os participantes que se inscreveram nos eventos e confirmaram presença no dia e local do mesmo.
        </p>
    </div>
    <?php
}
if ($SESSION->IsLoggedIn()) {

#-----------------------------------------------------------------------------#

    $CPF = $USER->getCpf();
    $query = "SELECT e.id, e.titulo, p.presenca, p.data_visualizacao FROM participacoes p, eventos e ";
    $query .= "WHERE cpf_participante='$CPF' AND e.id=p.id_evento AND p.tipo='P' AND e.semtec='{$SCT_ID}' AND e.tipo IN(1,2,4,5) ORDER BY data_inscricao";
    $result = $DB->Query($query);

    $header['css'][] = array("href" => $CONFIG->URL_ROOT . "/templates/" . $EVENTO['TEMPLATE'] . "/includes/css/certificados.css", "media" => "screen");
    ?>

    <h1>Certificados<span class="imgH1 geral"></span></h1>

    <div class="box">
        <p >
            Abaixo estão listados os eventos ao qual você se inscreveu.
        </p>
        <p >
            Se a presença estiver confirmada basta clicar no ícone
            <img src="<?php echo $CONFIG->URL_ROOT ?>/includes/imgs/view.png" alt="visualizar" />
            para visualizar e imprimir seu certificado.
        </p>

        <br/>

        <table id="lista_certificados">
            <tr>
                <th class="left" width="450">Nome da Atividade</th>
                <th>Presença</th>
                <!--th width="150">Última Visualizaçao</th-->
                <th>Visualizar</th>
            </tr>

            <? if (mysql_num_rows($result) <= 0): //IF 01 ?>

                <tr>
                    <th colspan="5">Nenhuma inscrição encontrada.</th>
                </tr>

            <? else: //IF 01 ?>

                <?
                while ($x = mysql_fetch_array($result)):
                    $titulo = (strlen($x['titulo']) > 53) ? substr($x['titulo'], 0, 50) . '...' : $x['titulo'];
                    $presenca = $x['presenca'] == 1 ? '<b style="color:#00aa00">OK</b>' : '<font color="#ff0000">não confirmada</font>';
                    $dataV = is_null($x['data_visualizacao']) ? $x['presenca'] == 1 ? "nunca" : "-"  : formata_data($x['data_visualizacao']);
                    $bg = $bg == "f0f0f0" ? "ffffff" : "f0f0f0";
                    ?>

                    <tr bgcolor="#<?php echo $bg ?>">
                        <td style="padding-left:5px;" title="<?= $x['titulo'] ?>"><?= $titulo ?></td>
                        <td class="center small"><?= $presenca ?></td>
                        <!--td class="center"><?= $dataV ?></td-->
                        <td class="center">
                            <? if ($x['presenca'] == 1): ?>
                                <a href="certificado.php?evento=<?= $x['id'] ?><?
                                if (isset($_GET['SCT'])) {
                                    echo '&SCT=' . $_GET['SCT'];
                                }
                                ?>" title="Visualizar certificado" target="_blank">
                                    <img src="<?php echo $CONFIG->URL_ROOT ?>/includes/imgs/view.png" alt="Visualizar certificado" />
                                </a>
                            <? else: ?>
                                <!--img src="<?php echo $CONFIG->URL_ROOT ?>/includes/imgs/cancel.png" alt="Sem certificação" /-->
                                -
                            <? endif ?>
                        </td>
                    </tr>

                <? endwhile ?>
            <? endif //IF 01   ?>
        </table>

        <br/><br/>

    </div>

    <?php
}
?>
