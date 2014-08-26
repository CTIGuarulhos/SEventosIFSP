<h1>Como Chegar<span class="imgH1 geral"></span></h1>
<br/>
<center>
    <?php strtoupper($EVENTO['GENERO']) ?> <?php echo $EVENTO['NOME'] ?> acontecer&aacute; no seguinte endereço:
    <br>
    <?php echo $EVENTO['ENDERECO_L1'] ?>
    <br>
    <?php echo $EVENTO['ENDERECO_L2'] ?>

    <br/><br/>

    <iframe width="640" height="480" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="<?php echo $EVENTO['URL_MAPS_IFRAME'] ?>"></iframe><br /><small><a href="<?php echo $EVENTO['URL_MAPS'] ?>" style="color:#0000FF;text-align:left" target=_blank>Exibir mapa ampliado</a></small>

</center>

