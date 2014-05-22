<?php
require_once 'CrachaDao.php';

$instituicao = "SECR. MUNIC. EDUC.";
$nome = "Nome do Participante do Evento";
$tipoParticipante = "Palestrante";
$imprimir = true;

if (!(empty($_GET[cpf]))) {
    $crachaDao = new CrachaDao();
    $crachaDao->cpf = $_GET[cpf];
    $dados = $crachaDao->getParticipante();
    $dados = $dados[0];
    if (!($dados[nome])) {
        $imprimir = false;
    } else {
        $instituicao = $dados[instituicao];
        $nome = $dados[nome];
        $tipoParticipante = $dados[tipoParticipante];
    }
} else {
    if (!(empty($_GET[instituicao]))) {
        $instituicao = $_GET[instituicao];
    } else {
        $imprimir = false;
    }
    if (!(empty($_GET[nome]))) {
        $nome = $_GET[nome];
    } else {
        $imprimir = false;
    }
    if (!(empty($_GET[tipoParticipante]))) {
        $tipoParticipante = $_GET[tipoParticipante];
    } else {
        $imprimir = false;
    }
}



$x = 1;
$lstInstituicao[$x++] = "PREF. DE GUARULHOS";
$lstInstituicao[$x++] = "IFSP";
$lstInstituicao[$x++] = "ENIAC";
$lstInstituicao[$x++] = "UNG";
$lstInstituicao[$x++] = "FATEC";
$lstInstituicao[$x++] = "VISITANTE";

$x = 1;
$lstTipoParticipante[$x++] = "Palestrante";
$lstTipoParticipante[$x++] = "Visitante";
$lstTipoParticipante[$x++] = "Estudante";
$lstTipoParticipante[$x++] = "Comissão Organizadora";

//echo "....".$instituicao; exit;
?>
<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href="jquery/development-bundle/themes/sunny/jquery.ui.all.css" rel="stylesheet" type="text/css" />
        <link href="cracha.css" rel="stylesheet" type="text/css" />
        <script src="jquery/js/jquery.js" type="text/javascript"  charset="utf-8"></script>        
        <script src="jquery/js/validate.js" type="text/javascript" charset="utf-8"></script>
        <script src="jquery/js/printElement.js" type="text/javascript"  charset="utf-8"></script>                
        <script src="jquery/development-bundle/ui/jquery.ui.core.js" type="text/javascript"></script>        
        <script src="jquery/development-bundle/ui/jquery.ui.widget.js" type="text/javascript"></script>
        <script src="jquery/development-bundle/ui/jquery.ui.button.js" type="text/javascript"></script>
        <script src="jquery/development-bundle/ui/jquery.ui.dialog.js" type="text/javascript"></script>
        <script src="jquery/development-bundle/ui/jquery.ui.position.js" type="text/javascript"></script>
        <script src="jquery/development-bundle/ui/jquery.ui.tabs.js" type="text/javascript"></script>
        <script src="cracha.js" type="text/javascript"  charset="utf-8"></script>
        <script language="javascript">
            function fecha_janela() {
                window.opener = window;
                window.close();
            }
            function printload() {
                imprimir()
            }
        </script>

    </head>
    <body <?
    if ($_GET['print'] == 1) : echo "onload='printload()'";
    endif
    ?> >
        <div id="tabs">
            <ul>
                <li>
                    <a href="#tabs-1">Imprimir Crachá</a>
                </li>                
            </ul>
            <div id="tabs-1">
                <p>
                    <?php
                    if (!$imprimir) {
                        ?>  
                    <form action="cracha.php" method="get" name="frmCadastro" id="frmCadastro">
                        Nome participante:
                        <input type="text" id="nome" name="nome" value="" />
                        <br />
                        Instituição:
                        <select id="instituicao" name="instituicao">
                            <option value=""></option>
                            <?php
                            foreach ($lstInstituicao as $key => $value) {
                                ?>
                                <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <br />
                        Tipo Participante:
                        <select id="tipoParticipante" name="tipoParticipante">
                            <option value=""></option>
                            <?php
                            foreach ($lstTipoParticipante as $key => $value) {
                                ?>
                                <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <hr />
                        <input type="submit" value="gerar dados" />
                        <br /><hr /><br />
                        <br />
                    </form>
                    <?php
                }
                ?>
                <?php
                if ($imprimir) {
                    ?>    
                    <div id="divCracha">            
                        <div id="divTitulo">1ª Semana da Ciência, Tecnologia, Inovação e Desenvolvimento de Guarulhos</div>
                        <div id="divNome"><?php echo $nome; ?></div>                        
                        <div id="divTipoParticipante"><?php echo $tipoParticipante; ?></div>
                        <div id="divInstituicao"><?php echo $instituicao; ?></div>
                    </div>
                    <br /><br />
                    <div id="divImprimir">
                        <input type="button" name="btnImprimir" id="btnImprimir" value="Imprimir" onclick="imprimir()" />
                    </div>

                    <form action="cracha.php" method="get" name="frmLimpar" id="frmLimpar">
                        <input type="submit" name="btnLimpar" id="btnLimpar" value="Limpar Dados" />
                    </form>
                    <?php
                }
                ?>
                </p>
            </div>
        </div>
    </body>
</html>
