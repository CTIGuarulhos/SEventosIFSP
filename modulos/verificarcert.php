<h1>Verificação de Certificado<span class="imgH1 geral"></span></h1>
<br/>

<p>
    Digite os dados conforme encontrado no certificado
</p>

<?php
#---------------------------------------------------------------------------#
#------------------------- Exibe Resultado ---------------------------------#
if (isset($_POST['verificacertificado'])):
//Escapa as vari�veis
    $_POST = safe_sql($_POST);
    $codcontrole = $_POST['codcontrole'];
    $documento = $_POST['documento'];
    $dadosOK = true;
    $erro = array();

    $query = "SELECT DISTINCT u.cpf as CPF,u.documento as documento, u.nome as NOME, i.NOME as EDICAO, ";
    $query .= "p.verificacao as CODCONTROLE, e.titulo as TITULO, e.data as DATA, e.duracao as DURACAO ";
    $query .= "from participacoes p, participantes u, eventos e, edicao i where p.verificacao='$codcontrole' ";
    $query .= "AND p.cpf_participante ='$documento' AND p.presenca ='1' AND p.cpf_participante=u.cpf AND p.id_evento=e.id AND e.semtec=i.SEMTEC";
    $result = $DB->Query($query);
    if (mysql_num_rows($result) == 1) {
        $dadosOK = true;
    } else {
        $dadosOK = false;
        $erro['dados'] = "Dados Inválidos.";
    }

endif;
?>

<?php
//Mensagem de erro (se houver)
if (isset($dadosOK) && !$dadosOK) {
    HTML_ErrorMessage($erro);
}
?>

<form class="forms" name="alt_dados" method="post" action="<?php echo $Esta_Pagina; ?>">

    <input type="hidden" name="verificacertificado" value="false" />
    <label for="documento"><?php HTML_RequiredField() ?>DOCUMENTO (CPF OU RG):</label>
    <input type="text" name="documento" id="documento" maxlength="15" size="35" value="<?php echo $_POST['documento'] ?>" />
    <br><br>

    <label for="codcontrole"><?php HTML_RequiredField() ?>CÓDIGO DE VALIDAÇÃO:</label>
    <input type="text" name="codcontrole" id="codcontrole" maxlength="32" size="35" value="<?php echo $_POST['codcontrole'] ?>" />
    <br><br>

    <input type="submit" value="Verificar autenticidade" />

    <?php
    if (isset($_POST['verificacertificado'])):

        if (mysql_num_rows($result) == 1) {
            $result = mysql_fetch_array($result);
            $datahoraparte = explode(" ", $result['DATA']);
            $data = $datahoraparte[0];
            $data = implode("/", array_reverse(explode("-", $result['DATA'])));
            ?><br><br><center><font color="red"><b>Dados para autenticação</b></font></center><br><br>
            <label for="Nome">Nome do Participante:</label>
            <input type="text" name="nome" id="nome" maxlength="15" size="35" value="<?php echo $result['NOME'] ?> " readonly />
            <br/><br/>

            <label for="<?php
            if ($result['documento'] == "sim") {
                echo "CPF";
            } elseif ($result['documento'] == "nao") {
                echo "RG";
            }
            ?>"><?php
                       if ($result['documento'] == "sim") {
                           echo "CPF";
                       } elseif ($result['documento'] == "nao") {
                           echo "RG";
                       }
                       ?> do Participante:</label>
            <input type="text" name="<?php
            if ($result['documento'] == "sim") {
                echo "CPF";
            } elseif ($result['documento'] == "nao") {
                echo "RG";
            }
            ?>" id="<?php
                   if ($result['documento'] == "sim") {
                       echo "CPF";
                   } elseif ($result['documento'] == "nao") {
                       echo "RG";
                   }
                   ?>" maxlength="15" size="35" value="<?php echo $result['CPF'] ?>" readonly />
            <br><br>
            <label for="edicao">Nome do Evento:</label>
            <input type="text" name="edicao" id="edicao" maxlength="15" size="35" value="<?php echo $result['EDICAO'] ?>" readonly />
            <br/><br/>        
            <label for="titulo">Nome da Atividade:</label>
            <input type="text" name="titulo" id="titulo" maxlength="15" size="35" value="<?php echo $result['TITULO'] ?>" readonly />
            <br/><br/>                
            <label for="data">Data da Atividade:</label>
            <input type="text" name="data" id="data" maxlength="15" size="35" value="<?php echo $data ?>" readonly />
            <br/><br/>
            <label for="duracao">Duração (em minutos):</label>
            <input type="text" name="duracao" id="duracao" maxlength="15" size="35" value="<?php echo $result['DURACAO'] ?>" readonly />
            <br/><br/>                



            <?php
        }
    endif;
    ?>
</form>