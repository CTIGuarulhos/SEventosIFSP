<?php
#------------------------ VERIFICA SE ESTÁ LOGADO ----------------------------#
if (!$SESSION->IsLoggedIn()) {
    ?>
    <h1>Certificados<span class="imgH1 geral"></span></h1>		
    <div class="box">
        <p >
            Os certificados d<?php $EVENTO['GENERO'] ?> <?php echo $EVENTO['NOME'] ?> do <?php echo $EVENTO['NOME_INST_RED'] ?> já estão disponíveis online.
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
    exit();
}
#-----------------------------------------------------------------------------#


$CPF = $USER->getCpf();
$query = "SELECT DISTINCT e.semtec as semtec, u.NOME as NOME FROM participacoes p, eventos e, edicao u ";
$query .= "WHERE cpf_participante='$CPF' AND e.id=p.id_evento AND e.semtec=u.SEMTEC AND e.tipo IN(1,2,4,5) AND p.tipo='P' ORDER BY e.semtec";
$result = $DB->Query($query);

$header['css'][] = array("href" => $CONFIG->URL_ROOT . "/templates/" . $EVENTO['TEMPLATE'] . "/includes/css/certificados.css", "media" => "screen");
?>


<h1>Certificados<span class="imgH1 geral"></span></h1>

<div class="box">
    <p >
        Abaixo estão listados os anos ao qual você participou.
    </p>
    <br/>

    <table id="lista_certificados" width="100%">
        <tr>
            <th class="left" width="50%">Evento</th>
            <th width="50%">Acesso aos Certificados</th>
        </tr>

        <? if (mysql_num_rows($result) <= 0): //IF 01 ?>

            <tr>
                <th colspan="5">Você ainda não participou de nenhum evento.</th>
            </tr>

        <? else: //IF 01 ?>

            <?
            while ($x = mysql_fetch_array($result)):
                $semtec = $x['semtec'];
                $NOME = $x['NOME'];
                $bg = $bg == "f0f0f0" ? "ffffff" : "f0f0f0";
                ?>

                <tr bgcolor="#<?php echo $bg ?>">
                    <td style="padding-left:5px;" title="<?= $NOME ?>"><?= $NOME ?></td>
                    <td class="center">
                        <a href="<? echo $CONFIG->URL_ROOT ?>/?pag=certificados<?
                        if ($semtec != $CONFIG->SCT_ID) {
                            echo '&SCT=' . $semtec;
                        }
                        ?>" title="Visualizar certificados">
                            <center>Visualizar certificados</center>
                        </a>
                    </td>
                </tr>

            <? endwhile ?>
        <? endif //IF 01     ?>
    </table>

    <br/><br/>

</div>

<?php ?>
