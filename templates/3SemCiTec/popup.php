<!-- POPUP -->
<link href='http://fonts.googleapis.com/css?family=Scada' rel='stylesheet' type='text/css'>
<style>
    #pop{
        display:block;
        position:absolute;
        top:50%;
        left:50%;
        margin-left:-150px;
        margin-top:-100px;
        padding:10px;
        width:300px;
        height:200px;
        border:1px solid #d0d0d0;
        /*
       background: #02accb; /* Old browsers */
	background: -moz-linear-gradient(45deg, #02accb 0%, #026d80 50%, #02accb 100%); /* FF3.6+ */
	background: -webkit-gradient(linear, left bottom, right top, color-stop(0%,#02accb), color-stop(50%,#026d80), color-stop(100%,#02accb)); /* Chrome,Safari4+ */
	background: -webkit-linear-gradient(45deg, #02accb 0%,#026d80 50%,#02accb 100%); /* Chrome10+,Safari5.1+ */
	background: -o-linear-gradient(45deg, #02accb 0%,#026d80 50%,#02accb 100%); /* Opera 11.10+ */
	background: -ms-linear-gradient(45deg, #02accb 0%,#026d80 50%,#02accb 100%); /* IE10+ */
	background: linear-gradient(45deg, #02accb 0%,#026d80 50%,#02accb 100%); /* W3C */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#02accb', endColorstr='#02accb',GradientType=1 ); /* IE6-9 fallback on horizontal gradient */

        border-width: 1px;
        border-color: black;
        border-radius: 15px;
        box-shadow: 10px 10px 5px #888888;



    }
</style>

<div id="pop">
    <a href="#" onclick="document.getElementById('pop').style.display = 'none';"><p style="color: black; text-align: right">[Fechar]</p></a>
    <font style="font-family: 'Scada', sans-serif; font-size: 15pt; text-align: center; color: white"><center>
        O Prêmio Jovem Inovador (PJI) mudou. Agora ele está associado à <a href='<?php echo str_replace("semcitec","feceg",$CONFIG->URL_ROOT) ?>'TARGET="_blank"><font color="ffffff"><strong>FECEG - Feira de Ciências e Engenharia de Guarulhos</strong></font></a>.
    </center></font>
</div> 
