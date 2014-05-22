<?php
if (!$SESSION->IsLoggedIn()) {
    $Return_URL = "$CONFIG->URL_ROOT";
    header("Location: $Return_URL");
    unset($Return_URL);
}
if (tipoadmin(7, $USER->getCpf(), $SCT_ID)) {
    $SNCTID = $SCT_ID; //SCT_ID;
# ----------------------- Par�metros GET/POST ----------------------------- #
    $deletarusuario = safe_sql($_REQUEST['deletarusuario']);
    $listar = safe_sql($_REQUEST['listar']);
    $listar = (empty($listar) || $listar < 0 || $listar > 2) ? 0 : $listar;
    $opcao = safe_sql($_REQUEST['opcao']);
    $evento_op2 = safe_sql($_REQUEST['evento_op2']);
    $evento_op3 = safe_sql($_REQUEST['evento_op3']);
    $busca = safe_sql($_REQUEST['busca']);
# ------------------------------------------------------------------------- #

    $header['css'][] = array("href" => $CONFIG->URL_ROOT . "/templates/" . $EVENTO['TEMPLATE'] . "/css/relatorios.css", "media" => "screen");
    $header['css'][] = array("href" => $CONFIG->URL_ROOT . "/templates/" . $EVENTO['TEMPLATE'] . "/css/relatorios_print.css", "media" => "print");
    ?>

    <script type="text/javascript">
        function lock()
        {
            document.getElementById('l1').disabled = true;
            document.getElementById('l2').disabled = true;
            document.getElementById('l3').disabled = true;
            document.getElementById('ll1').style.color = '#959595';
            document.getElementById('ll2').style.color = '#959595';
            document.getElementById('ll3').style.color = '#959595';
        }

        function unlock()
        {
            document.getElementById('l1').disabled = false;
            document.getElementById('l2').disabled = false;
            document.getElementById('l3').disabled = false;
            document.getElementById('ll1').style.color = '#000000';
            document.getElementById('ll2').style.color = '#000000';
            document.getElementById('ll3').style.color = '#000000';
        }
    </script>


    <h1 style="margin-bottom:30px;" class="noprint">GERENCIAR USUÁRIOS</h1>

    <div id="relatorios">
        <form method="post" action="<?= $Esta_Pagina ?>">
            <label for="l1" style="margin-right:30px;">LISTAR:</label>
            <input type="radio" name="listar" id="l0" value="0" <?= $listar == 0 ? 'checked="checked" ' : '' ?> <?= $listar == '' ? 'checked="checked" ' : '' ?>/><font id="ll1">TODOS OS USUARIOS</font>
            <input type="radio" name="listar" id="l1" value="1" <?= $listar == 1 ? 'checked="checked" ' : '' ?>/><font id="ll1">USUÁRIOS NÃO ATIVOS</font>
            <input type="radio" name="listar" id="l2" value="2" <?= $listar == 2 ? 'checked="checked" ' : '' ?>/><font id="ll1">USUÁRIOS ATIVOS</font><br><br>
            FILTRAR POR DOCUMENTO OU NOME: 	    <input type="text" name="busca" value="<?= $busca ?>"/>
            <hr style="border:1px #a5a5a5 dashed;margin:15px 0px;" />UTILIZE ESSA FERRAMENTA COM MUITO CUIDADO! <br><br>
            <input type="hidden" name="opcao" value="1" CHECKED <?= $opcao == 1 ? 'checked="checked" ' : '' ?>onclick="unlock();" /><!--USUÁRIOS NÃO ATIVOS.
                                                <br/><br/>
            
                                                
                                                

            <br/><br/> -->

            <input type="submit" value="Exibir" />
        </form>
    </div>

    <?
    require_once("usuarios_functions.php");
    if (isset($deletarusuario)):
        deletar_usuario($deletarusuario);
    endif;

    if ($opcao == 1):
        buscar_usuarios($listar, $busca);
    endif;
    ?>


    <? if ($opcao == 3): ?>
        <script type="text/javascript">lock();</script>
    <? endif
    ?>

<? } ?>
