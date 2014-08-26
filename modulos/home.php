<?php if (time() < mktime($EVENTO['HORA'], $EVENTO['MINUTO'], 0, $EVENTO['MES'], $EVENTO['DIA_INICIO'], $EVENTO['ANO']) AND time() > mktime($EVENTO['HORA'], $EVENTO['MINUTO'], 0, $EVENTO['MES'] - 2, $EVENTO['DIA_INICIO'], $EVENTO['ANO'])): ?>
    <h1>Contagem Regressiva<span id="contagem"><script type="text/javascript">ContagemRegressiva();</script></span></h1>
    <div class="box">
        <center style="">
            <?php
            $expira = mktime($EVENTO['HORA'], $EVENTO['MINUTO'], 0, $EVENTO ['MES'], $EVENTO['DIA_INICIO'], $EVENTO['ANO']);
            $horaatual = date('U');
            $contatempo = $expira - $horaatual;
            $contadias = (int) ($contatempo / 86400);
            ?> 
            <?php echo strtoupper($EVENTO['GENERO']) ?> <?php echo $EVENTO['NOME'] ?> está chegando.<br/>
            Fa&ccedil;a j&aacute; seu <a style="color:blue;" href="<?php echo $CONFIG->URL_ROOT ?>/?pag=cadastro">cadastro </a> e sua <a style="color:blue;" href="<?php echo $CONFIG->URL_ROOT ?>/?pag=programacao">inscri&ccedil;&atilde;o</a>!
            <br><br>
            A inscrição para as atividades permanecerá aberta até o limite de vagas de cada atividade.
        </center>
    </div>
<?php endif; ?>

<?php
$timecertificado = mktime(0, 0, 0, $EVENTO ['MES'], $EVENTO ['DIA_FIM'] + 8, $EVENTO['ANO']);
$timeevento = mktime($EVENTO['HORA'], $EVENTO['MINUTO'], 0, $EVENTO['MES'], $EVENTO['DIA_INICIO'], $EVENTO['ANO']);
if (time() > $timeevento AND time() < $timecertificado):
    ?>
    <h1>Certificados</h1>
    <div class="box">
        <center style="">
            Os certificados d<?php echo $EVENTO['GENERO'] ?>  <?php echo $EVENTO['NOME'] ?> ser&atilde;o emitidos uma semana ap&oacute;s o termino do evento.<br/>
        </center>
    </div>
<?php endif; ?>

<?php if (time() > $timecertificado AND $timecertificado != ""): ?> 
    <h1>Certificados</h1>
    <div class="box">
        <center style="">
            Os certificados d<?php echo $EVENTO['GENERO'] ?>  <?php echo $EVENTO['NOME'] ?> ja est&atilde;o dispon&iacute;veis para quem fez inscri&ccedil;&atilde;o e confirmou sua presen&ccedil;a.<br /><br />Aos que se inscreveram no momento do evento os certificados serão emitidos gradativamente.
        </center>
    </div>
<?php endif; ?>
<?php if (strlen($EVENTO['APRESENTACAO']) > "5"): ?>
    <h1>Apresentação</h1>
    <div class="box">
        <p>
            <?php echo substituir_acentos($EVENTO['APRESENTACAO']) ?>
        </p>
    </div>
<?php endif ?>
<?php if (strlen($EVENTO['DATASIMPORTANTES']) > "5"): ?>
    <div class="box-data">
        <h1 class="evento-data">Datas Importantes</h1>
        <div class="evento">
            <?php echo substituir_acentos($EVENTO['DATASIMPORTANTES']) ?>
        </div>
    </div>
<?php endif; ?>
<?php if (strlen($EVENTO['COMISSAOORGANIZADORA']) > "5"): ?>
    <div class="box-data">
        <h1 class="evento-data">Comiss&atilde;o Organizadora</h1>
        <div class="evento">
            <?php echo substituir_acentos($EVENTO['COMISSAOORGANIZADORA']) ?>
        </div>
    </div>
<?php endif; ?>