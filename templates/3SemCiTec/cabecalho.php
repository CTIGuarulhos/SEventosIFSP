<link href='http://fonts.googleapis.com/css?family=Scada' rel='stylesheet' type='text/css'>
<?
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
<? $evento = explode("ª",$EVENTO['NOME']); ?>
<? $nomeevento = explode(",",$evento[1]); ?>
<div>
<table cellpadding="0" cellspacing="0" width="100%" border="0" align=center style="height: 100%;">
<tr>
  <td width="13%"></td>
  <td width="12%"><center><table style="height: 100%;" align=center><tr><td><font style="font-family: 'Scada', sans-serif; font-size: 100px; color: #026d80;"><?= $evento[0]; ?></font></td><td><font style="font-family: 'Scada', sans-serif; font-size: 36px; color: #026d80;">ª<br><br></font></td></tr></table></center></td>
  <td width="57%"><center><font style="font-family: 'Scada', sans-serif; font-size: 35px; color: #026d80;"><?= trim(strtr(strtoupper($nomeevento[0]),"àáâãäåæçèéêëìíîïðñòóôõö÷øùüúþÿ","ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÜÚÞß")); ?></font><br><font style="font-family: 'Scada', sans-serif; font-size: 25px; color: #026d80;"><?= trim(strtr(strtoupper($nomeevento[1]),"àáâãäåæçèéêëìíîïðñòóôõö÷øùüúþÿ","ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÜÚÞß")); ?></font></center></td>
  <td width="18%"><center><font style="font-family: 'Scada', sans-serif; font-size: 40px; color: #026d80;"><?= $EVENTO['DIA_INICIO'] . " a " . $EVENTO['DIA_FIM']?></font><br><font style="font-family: 'Scada', sans-serif; font-size: 30px; color: #026d80;"><?= trim(strtolower($mes)); ?></font></center></td>
</tr>
</table>
</div>