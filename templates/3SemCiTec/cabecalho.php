<link href='http://fonts.googleapis.com/css?family=Scada' rel='stylesheet' type='text/css'>
<?php
switch ($EVENTO['MES']) {
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
?>
<?php $evento = explode("ª", $EVENTO['NOME']); ?>
<?php $nomeevento = explode(",", $evento[1]); ?>
<br>
<div style="width:100%; height: 100%; vertical-align: middle;">
    <div align=center style="width:13%; height: 100%; display: table-cell; vertical-align: middle;">
    </div>
    <div align=center style="width:12%; height: 100%; display: table-cell; vertical-align: middle;">
        <center>
            <div>
                <div style="display: table-cell; vertical-align: middle;">
                    <font style="font-family: 'Scada', sans-serif; font-size: 100px; color: #026d80;"><?php echo $evento[0]; ?></font>
                </div>
                <div style="display: table-cell; vertical-align: middle;">
                    <font style="font-family: 'Scada', sans-serif; font-size: 36px; color: #026d80;">ª<br><br></font>
                </div>
            </div>
        </center>
    </div>
    <div align=center style="width:57%; height: 100%; display: table-cell; vertical-align: middle;">
        <center>
            <font style="font-family: 'Scada', sans-serif; font-size: 35px; color: #026d80;"><?php echo trim(strtr(strtoupper($nomeevento[0]), "àáâãäåæçèéêëìíîïðñòóôõö÷øùüúþÿ", "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÜÚÞß")); ?></font><br>
            <font style="font-family: 'Scada', sans-serif; font-size: 25px; color: #026d80;"><?php echo trim(strtr(strtoupper($nomeevento[1]), "àáâãäåæçèéêëìíîïðñòóôõö÷øùüúþÿ", "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÜÚÞß")); ?></font>
        </center>
    </div>
    <div align=center style="width:18%; height: 100%; display: table-cell;  vertical-align: middle;">
        <center>
            <font style="font-family: 'Scada', sans-serif; font-size: 40px; color: #026d80;"><?php echo $EVENTO['DIA_INICIO'] . " a " . $EVENTO['DIA_FIM'] ?></font><br>
            <font style="font-family: 'Scada', sans-serif; font-size: 30px; color: #026d80;"><?php echo trim(strtolower($mes)); ?></font><br>
            <font style="font-family: 'Scada', sans-serif; font-size: 30px; color: #026d80;"><?php echo $EVENTO['ANO']; ?></font>
        </center>
    </div>
</div>