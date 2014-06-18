<?php
/* * ****************************************************************************** */
/* * ************************* VALIDA INSCRIÇÃO ******************************* */
/* * ****************************************************************************** */
if (isset($_POST['cpf'])):

    //Escapa as vari�veis
    $_POST = safe_sql($_POST);


    //Transforma os parametros em variaveis
    extract($_POST, EXTR_PREFIX_SAME, "");

    //Funções de validação
    require_once($CONFIG->DIR_ROOT . "/includes/validacao.php");

    $dadosOK = true;
    $erro = array();
    if ($documento == 'sim') {
        $rg = "";
    } else {
        $cpf = "";
    }

    //Documento
    if ((($documento == "sim") && (strlen($cpf) == 0)) || (($documento == "nao") && (strlen($rg) == 0)) || $documento == "") {
        $dadosOK = false;
        $erro['documento'] = "Você deve especificar algum documento.";
    }

    //Cpf
    if ($documento == 'sim') {
        $cpf = str_replace(".", "", $cpf);
        $cpf = str_replace("-", "", $cpf);
        if (strlen($cpf) != 11 || !valCpf($cpf)) {
            $dadosOK = false;
            $erro['cpf'] = "N&uacute;mero de cpf inv&aacute;lido.";
        }
    }

    //Nome
    if (strlen($nome) < 3 || nome_invalido($nome)) {
        $dadosOK = false;
        $erro['nome'] = "Nome inv&aacute;lido. O seu nome precisa ter entre 3 e 50 caracteres.";
    }

    //Aluno
    $aluno = strtolower($aluno) == 'sim' ? true : false;

    //Prontu�rio
    if ($aluno && (!is_numeric(substr($prontuario, 0, 6)) || strlen($prontuario) < 7)) {
        $dadosOK = false;
        $erro['prontuario'] = "Prontu&aacute;rio inv&aacute;lido.";
    }

    //E-mail
    if (!valEmail($email) || strlen($email) < 5 || strlen($email) > 50) {
        $dadosOK = false;
        $erro['email'] = "endere&ccedil;o de e-mail inv&aacute;lido.";
    }
    //Confirma E-Mail
    if (strcmp($email, $cemail) != 0) {
        $dadosOK = false;
        $erro['cemail'] = "O e-mail n&atilde;o confere.";
    }

    //Senha
    if (strlen($senha) < 5 || strlen($senha) > 30) {
        $dadosOK = false;
        $erro['senha'] = "Senha deve ter entre 5 e 30 caracteres.";
    }

    //Confirma Senha
    if (strcmp($senha, $csenha) != 0) {
        $dadosOK = false;
        $erro['csenha'] = "As senhas n&atilde;o conferem.";
    }

    //Instituição
    if (!$aluno && strlen($instituicao) > 100) {
        $dadosOK = false;
        $erro['instituicao'] = "O nome da institui&ccedil;&atilde;o deve ter no m&aacute;ximo 100 caracteres.";
    }

    //RG
    if ($documento == "nao") {
        $rg = str_replace(".", "", $rg);
        $rg = str_replace("-", "", $rg);
        if (strlen($rg) > 15 || strlen($rg) < 5) {
            $dadosOK = false;
            $erro['rg'] = "O RG deve ter entre 5 e 15 caracteres.";
        }
    }


    //Endereço
    if (strlen($endereco) > 50) {
        $dadosOK = false;
        $erro['endereco'] = "O endere&ccedil;o deve ter no m&aacute;ximo 50 caracteres.";
    }

    //Número
    if (strlen($numero) && (!is_numeric($numero) || strlen($numero) > 5)) {
        $dadosOK = false;
        $erro['numero'] = "N&uacute;mero inv&aacute;lido para o endere&ccedil;o.";
    } else {
        $numero = (strlen($numero)) ? $numero : "NULL";
    }

    //Complemento
    if (strlen($complemento) && (strlen($complemento) < 1 || strlen($complemento) > 30)) {
        $dadosOK = false;
        $erro['complemento'] = "O complemento deve ter no m&aacute;ximo 30 caracteres.";
    }

    //Cep
    if (strlen($cep) && (!is_numeric($cep) || strlen($cep) != 8)) {
        $dadosOK = false;
        $erro['cep'] = "CEP inv&aacute;lido.";
    }

    //Bairro
    if (strlen($bairro) && strlen($bairro) > 50) {
        $dadosOK = false;
        $erro['bairro'] = "O endere&ccedil;o deve ter no m&aacute;ximo 50 caracteres.";
    }

    //Cidade
    if (strlen($cidade) && strlen($cidade) > 50) {
        $dadosOK = false;
        $erro['cidade'] = "A cidade deve ter no m&aacute;ximo 50 caracteres.";
    }

    //Estado (UF)
    $estados = array('', 'AC', 'AL', 'AM', 'AP', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA', 'MG', 'MS',
        'MT', 'PA', 'PB', 'PE', 'PI', 'PR', 'RJ', 'RN', 'RO', 'RR', 'RS', 'SC', 'SE', 'SP', 'TO');
    if (array_search($uf, $estados) === false) {
        $dadosOK = false;
        $erro['uf'] = "Unidade Federal inv&aacute;lido. Escolha uma das op&ccedil;&otilde;es dispon&iacute;veis.";
    } unset($estados);

    //País
    if (strlen($pais) && strlen($pais) > 30) {
        $dadosOK = false;
        $erro['pais'] = "O pa&iacute;s deve conter no m&aacute;ximo 30 caracteres.";
    }

    //Telefone
    if (strlen($tel) && strlen($tel) > 14) {
        $dadosOK = false;
        $erro['tel'] = "N&uacute;mero de telefone inv&aacute;lido.";
    }

    //Celular
    if (strlen($cel) && strlen($cel) > 15) {
        $dadosOK = false;
        $erro['cel'] = "N&uacute;mero de celular inv&aacute;lido.";
    }

    //Verifica se cpf j� est� cadastrado
    $query = "SELECT * FROM participantes WHERE cpf='$cpf'";
    $result = $DB->Query($query);
    if (!$result || mysql_num_rows($result) > 0) {
        $dadosOK = false;
        $erro['cpf_cadastrado'] = "Documento j&aacute; cadastrado.";
    }

    //Verifica se email já está cadastrado
    $query = "SELECT * FROM participantes WHERE email='$email'";
    $result = $DB->Query($query);
    if (!$result || mysql_num_rows($result) > 0) {
        $dadosOK = false;
        $erro['email_cadastrado'] = "E-mail j&aacute; cadastrado.";
    }

    //Verifica se prontuario j� est� cadastrado
    if ($aluno) {
        $query = "SELECT * FROM participantes WHERE RA='$prontuario'";
        $result = $DB->Query($query);
        if (!$result || mysql_num_rows($result) > 0) {
            $dadosOK = false;
            $erro['prontuario_cadastrado'] = "Prontu&atilde;rio j&aacute; cadastrado.";
        }
    }


    //Se dados OK insere no banco de dados
    if ($dadosOK) {
        //Manda RG para variavel CPF (Ajuste Técnico)
        if ($documento == "nao") {
            $cpf = $rg;
        }
        $NOME_INST_RED = $EVENTO['NOME_INST_RED'];

        $codigo = str_shuffle(date('dmYHis'));
        $query = "INSERT INTO participantes(cpf,documento,nome,rua,numero,complemento,bairro,cidade,estado,";
        $query .= "pais,cep,telefone,tel_celular,email,senha,data_inscricao,tipo,inst_empresa,RA,cod_confirmacao,confirmado) ";
        $query .= "VALUES('$cpf','$documento','$nome','$endereco',$numero,'$complemento','$bairro',";
        $query .= "'$cidade','$uf','$pais','$cep','$tel','$cel','$email','" . md5($senha) . "',NOW(),'1',";
        $query .= $aluno ? "'$NOME_INST_RED','$prontuario'," : "'$instituicao',NULL,";
        $query .= "'$codigo',0)";

        if ($DB->Query($query)) {

            require_once($CONFIG->DIR_ROOT . "/includes/email_confirmacao.php");
            $enviado = @email_confirmacao($nome, $senha, $codigo, $email);
            $tentativas = 1;

            while ($enviado == false && $tentativas <= 3) {
                sleep(2);
                $enviado = @email_confirmacao($nome, $senha, $codigo, $email);
                $tentativas++;
            }

            if ($enviado) {
                $_SESSION['temp']['cadastro_ok'] = true;
            } else {
                $_SESSION['temp']['erro_email'] = true;
            }
            $Return_URL = "{$CONFIG->URL_ROOT}/?pag=confirmacao";
            header("Location: $Return_URL");
            unset($Return_URL);
            exit;
        } else {
            $dadosOK = false;
            $erro['insert'] = "Erro ao inserir no banco de dados.";
        }

        unset($codigo);
    }

endif;
/* * ************************************************************************** */
?>

<?php if ($SESSION->IsLoggedIn()): ?>
    <h1>Cadastro<span class="imgH1 geral"></span></h1>
    <div class="box">
        <p>Voc&ecirc; j&aacute; est&aacute; cadastrado.</p>
        <p>Para fazer a inscri&ccedil&atilde;o de uma outra pessoa &eacute; preciso sair da sua conta antes.</p>
    </div>
<?php else: ?>

    <h1>Cadastro<span class="imgH1 geral"></span></h1>
    <div class="box">
        <? if ($EVENTO['CADASTRO'] == "fechado"): ?>
            <p>
                O Cadastro da <?php echo $EVENTO['NOME'] ?> ainda não esta aberto.
            </p>
        <? else: ?>

            <p>
                Ap&oacute;s cadastro, use seu e-mail e senha nos campos ao lado para inscrever-se nos eventos.
            </p>
            <!-- <p>
                    Caso voc&ecirc; j&aacute; tenha participado da edi&ccedil;&atilde;o anterior d<?php echo $EVENTO['GENERO'] ?> <?php echo $EVENTO['NOME'] ?> do <?php echo $EVENTO['NOME_INST_RED'] ?>, provavelmente voc&ecirc; j&aacute; est&aacute; cadastrado. Use seu
                    e-mail e senha para acessar sua conta. Ou use o link de recuperar senha.
            </p> -->
            <p>
                Voc&ecirc; dever&aacute; acessar seu e-mail para ativar seu cadastro, caso n&atilde;o esteja em sua caixa de entrada verifique no spam ou lixo eletr&ocirc;nico.
            </p>
            <!--<p>
                    Caso deseje adicione o e-mail <?php echo $CONFIG->MAIL_FROM ?> na lista de confi&aacute;veis.
            </p>-->		


            <?php
            //Mensagem de erro (se houver)
            if (isset($dadosOK) && !$dadosOK)
                HTML_ErrorMessage($erro);
            ?>

            <?php HTML_RequiredMessage() ?>
            <?php HTML_DocumentoMessage() ?>


            <form class="forms" name="inscricao" method="post" action="<? echo $Esta_Pagina ?>">

                <label for="nome">
                    <?php HTML_RequiredField() ?>Nome Completo:
                </label>
                <input type="text" name="nome" id="nome" maxlength="50" size="35" value="<?= $nome ?>" <?= $erro['nome'] ? 'class="input-erro"' : "" ?>/>
                <br/><br/>


                <label for="email">
                    <?php HTML_RequiredField() ?>E-mail:
                </label>
                <input type="text" name="email" onKeyPress="return disableCtrlModifer(event);" onKeyDown="return disableCtrlModifer(event);" onselectstart="return false" id="draggingDisabled" maxlength="50" size="35" value="<?= $email ?>" <?= $erro['email'] ? 'class="input-erro"' : "" ?>/>
                <br/><br/>

                <label for="cemail">
                    <?php HTML_RequiredField() ?>Confirma E-mail:
                </label>
                <input type="text" name="cemail" onKeyPress="return disableCtrlModifer(event);" onKeyDown="return disableCtrlModifer(event);" id="cemail" onselectstart="return false" maxlength="50" size="35" value="<?= $cemail ?>" <?= $erro['cemail'] ? 'class="input-erro"' : "" ?>/>
                <br/><br/>

                <label for="senha">
                    <?php HTML_RequiredField() ?>Senha:
                </label>
                <input type="password" name="senha" onKeyPress="return disableCtrlModifer(event);" onKeyDown="return disableCtrlModifer(event);" onselectstart="return false" id="senha" maxlength="30" size="35" <?= ($erro['senha'] || $erro['csenha']) ? 'class="input-erro"' : "" ?>/>
                <br/><br/>

                <label for="csenha">
                    <?php HTML_RequiredField() ?>Confirma senha:
                </label>
                <input type="password" name="csenha" onKeyPress="return disableCtrlModifer(event);" onKeyDown="return disableCtrlModifer(event);" onselectstart="return false" id="csenha" maxlength="30" size="35" <?= ($erro['senha'] || $erro['csenha']) ? 'class="input-erro"' : "" ?>/>
                <br/><br/>

                <label for="documento" style="margin-right:30px">
                    <?php HTML_RequiredField() ?><?php HTML_RequiredField() ?>Voc&ecirc; possui CPF?
                </label>
                <input type="radio" name="documento" id="documento" value="sim" <? if ($documento == "sim"): ?>checked='checked'<? endif ?>onclick="document.getElementById('cpf').style.display = 'block';
                                document.getElementById('rg').style.display = 'none';" />SIM
                <input type="radio" name="documento" value="nao" <? if ($documento == "nao"): ?>checked='checked'<? endif ?>style="margin-left:35px" onclick="document.getElementById('cpf').style.display = 'none';
                                document.getElementById('rg').style.display = 'block';" />NÃO
                <br/><br/> 

                <span id="cpf" <? if ($documento == "sim"): ?>style="display:block;"<? else: ?>style="display:none;"<? endif ?>>
                    <label for="CPF"><?php HTML_RequiredField() ?><?php HTML_RequiredField() ?>CPF</label>
                    <input type="text" name="cpf" id="cpf" maxlength="11" size="35" value="<?= $cpf ?>" <?= ($erro['cpf'] || $erro['cpf_cadastrado']) ? 'class="input-erro"' : "" ?>/>
                    <br/><br/>
                </span>

                <span id="rg" <? if ($documento == "nao"): ?>style="display:block;"<? else: ?>style="display:none;"<? endif ?>>
                    <label for="RG"><?php HTML_RequiredField() ?><?php HTML_RequiredField() ?>RG:</label>
                    <input type="text" name="rg" id="rg" maxlength="15" size="35" value="<?= $rg ?>" <?= $erro['rg'] ? 'class="input-erro"' : "" ?>/>
                    <br/><br/>
                </span>


                <!--
                <label for="rg"><?php HTML_RequiredField() ?>RG:</label>
                <input type="text" name="rg" id="rg" maxlength="15" size="35" value="<?= $rg ?>" <?= $erro['rg'] ? 'class="input-erro"' : "" ?>/>
                <br/><br/>
                
                <label for="cpf">CPF: (apenas números)
                </label>
                <input type="text" name="cpf" id="cpf" maxlength="11" size="35" value="<?= $cpf ?>" <?= ($erro['cpf'] || $erro['cpf_cadastrado']) ? 'class="input-erro"' : "" ?>/>
                <br/><br/> -->

                <!--		<label for="aluno" style="margin-right:30px">
                <?php HTML_RequiredField() ?>Voc&ecirc; &eacute; aluno do IFSP - Campus Guarulhos?
                </label>
                 <input type="radio" name="aluno" id="aluno" value="sim" CHECKED <? if ($aluno): ?>checked="checked" <? endif ?>onclick="document.getElementById('aluno_sim').style.display='block';document.getElementById('aluno_nao').style.display='none';" />SIM
                <input type="radio" name="aluno" value="nao" <? if (!$aluno): ?>checked="checked" <? endif ?>style="margin-left:35px" onclick="document.getElementById('aluno_sim').style.display='none';document.getElementById('aluno_nao').style.display='block';" />NÃO
                <br/><br/> 

                <span id="aluno_sim" <? if ($aluno): ?>style="display:block;"<? else: ?>style="display:none;"<? endif ?>>
                        <label for="prontuario">
                <?php HTML_RequiredField() ?>Prontu&aacute;rio: (apenas números e <b>X</b>, se houver)
                        </label>
                        <input type="text" name="prontuario" id="prontuario" maxlength="7" size="35" value="<?= $prontuario ?>" <?= ($erro['prontuario'] || $erro['prontuario_cadastrado']) ? 'class="input-erro"' : "" ?>/>
                        <br/><br/>
                </span>-->

                <span id="aluno_nao" <? if ($aluno): ?>style="display:none;"<? else: ?>style="display:block;"<? endif ?>>
                    <label for="instituicao">Instituição ou Empresa:</label>
                    <input type="text" name="instituicao" id="instituicao" maxlength="100" size="35" value="<?= $instituicao ?>" <?= $erro['instituicao'] ? 'class="input-erro"' : "" ?>/>
                    <br/><br/>
                </span>


                <label for="endereco">Endereço: (rua, avenida, etc.)</label>
                <input type="text" name="endereco" id="endereco" maxlength="50" size="35" value="<?= $endereco ?>" <?= $erro['endereco'] ? 'class="input-erro"' : "" ?>/>
                <br/><br/>

                <label for="numero">N&ordm;:</label>
                <input type="text" name="numero" id="numero" maxlength="5" size="35" value="<?= $numero == 'NULL' ? "" : $numero ?>" <?= $erro['numero'] ? 'class="input-erro"' : "" ?>/>
                <br/><br/>

                <label for="complemento">Complemento:</label>
                <input type="text" name="complemento" id="complemento" maxlength="30" size="35" value="<?= $complemento ?>" <?= $erro['complemento'] ? 'class="input-erro"' : "" ?>/>
                <br/><br/>

                <label for="cep">CEP: (apenas números)</label>
                <input type="text" name="cep" id="cep" maxlength="8" size="35" value="<?= $cep ?>" <?= $erro['cep'] ? 'class="input-erro"' : "" ?>/>
                <br/><br/>

                <label for="bairro">Bairro:</label>
                <input type="text" name="bairro" id="bairro" maxlength="50" size="35" value="<?= $bairro ?>" <?= $erro['bairro'] ? 'class="input-erro"' : "" ?>/>
                <br/><br/>
                <? $cidade = Guarulhos ?>
                <label for="cidade">Cidade:</label>
                <input type="text" name="cidade" id="cidade" maxlength="50" size="35" value="<?= $cidade ?>" <?= $erro['cidade'] ? 'class="input-erro"' : "" ?>/>
                <br/><br/>

                <label for="uf">UF:</label>
                <select name="uf" id="uf">
                    <?
                    $uf = SP;
                    $estado = array('', 'AC', 'AL', 'AM', 'AP', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA', 'MG',
                        'MS', 'MT', 'PA', 'PB', 'PE', 'PI', 'PR', 'RJ', 'RN', 'RO', 'RR', 'RS', 'SC', 'SE', 'SP', 'TO');
                    foreach ($estado as $sigla) {
                        if ($sigla == $uf)
                            echo"<option value=\"$sigla\" selected=\"selected\">$sigla</option>";
                        else
                            echo"<option value=\"$sigla\">$sigla</option>";
                    }
                    ?>
                </select>
                <br/><br/>

                <label for="pais">País:</label>
                <input type="text" name="pais" id="pais" maxlength="30" size="35" value="<?= empty($pais) ? 'Brasil' : $pais ?>" <?= $erro['pais'] ? 'class="input-erro"' : "" ?>/>
                <br/><br/>

                <label for="tel">Telefone: (xx) xxxxx-xxxx</label>
                <input type="text" name="tel" id="tel" maxlength="15" size="35" value="<?= $tel ?>" <?= $erro['tel'] ? 'class="input-erro"' : "" ?>/>
                <br/><br/>

                <label for="cel">Celular: (xx) xxxxx-xxxx</label>
                <input type="text" name="cel" id="cel" maxlength="15" size="35" value="<?= $cel ?>" <?= $erro['cel'] ? 'class="input-erro"' : "" ?>/>
                <br/><br/>

                <input type="submit" value="Enviar" />
            </form>
        <? endif ?>

    </div>
<?php endif ?>
