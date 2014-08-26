<?php
if (!$SESSION->IsLoggedIn()) {
    $Return_URL = "$CONFIG->URL_ROOT";
    header("Location: $Return_URL");
    unset($Return_URL);
}
if (tipoadmin(5, $USER->getCpf(), $SCT_ID)) {

//Verifica se o usu�rio est� logado
    function checkboxToString($check) {
        while (list ($key, $val) = @each($check)) {
            $string .= $val . ",";
        }
        $string = substr($string, 0, strlen($string) - 1);
        return $string;
    }

//Verifica se � aluno do IFSP
    $query = "SELECT RA FROM participantes WHERE cpf='{$_GET['usuario']}'";
    $aluno = mysql_fetch_array($DB->Query($query));
//$aluno = (strlen($aluno['RA'])) ? true : false;
    $aluno = false;

#--------------------------- ALTERA��O DADOS -------------------------------#
    if (isset($_POST['alterar_dados'])):
        $eventos = $_POST['eventos'];
        //Escapa as vari�veis
        $_POST = safe_sql($_POST);

        //Transforma os parametros em variaveis
        extract($_POST, EXTR_PREFIX_SAME, "");

        //Funções de validação
        require_once($CONFIG->DIR_ROOT . "/includes/validacao.php");

        $dadosOK = true;
        $erro = array();

        //Cpf
        //  if(strlen($cpf)!=11 || !valCpf($cpf)) {
        //  $dadosOK = false;
        //  $erro['cpf'] = "N&uacute;mero de cpf inv&aacute;lido.";
        //  }
        //Nome
        if (strlen($nome) < 3 || nome_invalido($nome)) {
            $dadosOK = false;
            $erro['nome'] = "Nome inv&aacute;lido. Entre com um nome entre 3 e 50 caracteres.";
        }

        //Aluno
        $aluno = ($aluno == 'sim') ? true : false;
        if ($aluno) {
            //Pronturio
            if (!is_numeric(substr($prontuario, 0, 6)) || strlen($prontuario) < 7) {
                $dadosOK = false;
                $erro['prontuario'] = "Prontu&aacute;rio inv&aacute;lido.";
            }
        } else {
            //Instituição
            if (strlen($instituicao) > 100) {
                $dadosOK = false;
                $erro['instituicao'] = "O nome da institui&ccedil&atilde;o deve ter no m&aacute;ximo 100 caracteres.";
            }
        }

        //RG
        if (strlen($rg) > 15) {
            $dadosOK = false;
            $erro['rg'] = "O RG deve ter no m&aacute;ximo 15 caracteres.";
        }

        //Endereço
        if (strlen($endereco) > 50) {
            $dadosOK = false;
            $erro['endereco'] = "O endere&ccedil;o deve ter no m&aacute;ximo 50 caracteres.";
        }

        //Número
        if (strlen($numero) && (!is_numeric($numero) || strlen($numero) > 5)) {
            $dadosOK = false;
            $erro['numero'] = "N&uacute;mero inv&aacute;lido para o endere&ccedil;o";
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
            $erro['uf'] = "Unidade Federal inv&aacute;lido. Escolha uma das op&ccedil&otilde;es dispon&iacute;�veis.";
        } unset($estados);

        //País
        if (strlen($pais) && strlen($pais) > 30) {
            $dadosOK = false;
            $erro['pais'] = "O pa&iacute;�s deve conter no m&aacute;ximo 30 caracteres.";
        }

        //Telefone
        if (strlen($tel) && strlen($tel) > 15) {
            $dadosOK = false;
            $erro['tel'] = "N&uacute;mero de telefone inv&aacute;lido.";
        }

        //Celular
        if (strlen($cel) && strlen($cel) > 15) {
            $dadosOK = false;
            $erro['cel'] = "N&uacute;mero de celular inv&aacute;lido.";
        }

        //Verifica se prontuario j� est� cadastrado
        if ($aluno) {
            $query = "SELECT * FROM participantes WHERE RA='$prontuario' AND cpf<>'{$_GET['usuario']}'";
            $result = $DB->Query($query);
            if (!$result || mysql_num_rows($result) > 0) {
                $dadosOK = false;
                $erro['prontuario_cadastrado'] = "Prontu&aacute;rio j&aacute; cadastrado.";
            }
        }


        //Se dados OK insere no banco de dados
        if ($dadosOK) {

            $query = "UPDATE participantes SET nome='$nome', rua='$endereco', numero=$numero, ";
            $query .= "complemento='$complemento', bairro='$bairro', cidade='$cidade', estado='$uf', pais='$pais', ";
            $query .= "cep='$cep', telefone='$tel', tel_celular='$cel', ";
            if (isset($_POST['admin'])) {
                $query .= "admin=$admin, ";
            }
            if (count($eventos) > 0) {
                $eventos = checkboxToString($eventos);
                $query .= "eventos='$eventos', ";
            }
            $query .= $aluno ? "RA='$prontuario' " : "inst_empresa='$instituicao' ";
            $query .= "WHERE cpf='{$_GET['usuario']}'";
            //exit($query);

            if (!$DB->Query($query)) {
                $dadosOK = false;
                $erro['insert'] = "Erro ao inserir no banco de dados.";
            }
        }

    endif;
#---------------------------------------------------------------------------#
#------------------------- ALTERAÇÃO EMAIL ---------------------------------#
    if (isset($_POST['email'])):
//Escapa as vari�veis
        $_POST = safe_sql($_POST);
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $cemail = $_POST['cemail'];
        $dadosOK = true;
        $erro = array();
        //Funções de validação
        require_once($CONFIG->DIR_ROOT . "/includes/validacao.php");

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

        if ($dadosOK) {
            $codigo = str_shuffle(date('dmYHis'));
            $query = "UPDATE participantes SET email='$email', confirmado='0', cod_confirmacao='$codigo' WHERE cpf='{$_GET['usuario']}'";

            if ($DB->Query($query)) {

                require_once($CONFIG->DIR_ROOT . "/includes/email_confirmacao.php");
                $enviado = @email_reconfirmacao($nome, $codigo, $email);
                $tentativas = 1;

                while ($enviado == false && $tentativas <= 3) {
                    sleep(2);
                    $enviado = @email_reconfirmacao($nome, $codigo, $email);
                    $tentativas++;
                }

                if ($enviado) {
                    $_SESSION['temp']['cadastro_ok'] = true;
                } else {
                    $_SESSION['temp']['erro_email'] = true;
                }
                $Return_URL = "$Esta_Pagina";
                header("Location: $Return_URL");
                unset($Return_URL);
            } else {
                $dadosOK = false;
                $erro['insert'] = "Erro ao inserir no banco de dados.";
            }
            unset($codigo);
        }

    endif;
#---------------------------------------------------------------------------#
#------------------------- ALTERAÇÃO SENHA ---------------------------------#
    if (isset($_POST['senha'])):

        //Escapa as vari�veis
        $_POST = safe_sql($_POST);
        $senha = $_POST['senha'];
        $csenha = $_POST['csenha'];
        $dadosOK = true;
        $erro = array();

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

        //Se dados OK insere no banco de dados
        if ($dadosOK) {
            $query = "UPDATE participantes SET senha='" . md5($senha) . "' WHERE cpf='{$_GET['usuario']}'";

            if (!$DB->Query($query)) {
                $dadosOK = false;
                $erro['insert'] = "Erro ao inserir no banco de dados.";
            }
        }

    endif;
#---------------------------------------------------------------------------#

    $query = "SELECT * FROM participantes WHERE cpf='{$_GET['usuario']}'";
    $result = mysql_fetch_array($DB->Query($query));
    ?>

    <h1>Meus Dados<span class="imgH1 geral"></span></h1>
    <br/>

    <p>
        Corrija seus dados pessoais caso necess&aacute;rio.
        <br/>
        E lembre-se de manter seu endere&ccedil;o de e-mail atualizado.
        Pois assim, caso necessite, voc&ecirc; poder&aacute; reenviar sua senha para o email cadastrado.
    </p>

    <?php
//Mensagem de erro (se houver)
    if (isset($dadosOK) && !$dadosOK)
        HTML_ErrorMessage($erro);
//Mensagem de atualização OK
    if (isset($dadosOK) && $dadosOK)
        HTML_SuccessMessage("Seus dados foram atualizados com sucesso.");

//Mensagem de erro de envio da chave de confirmaçao
    if ($_SESSION['temp']['erro_email']) {
        $msg = "Erro ao enviar e-mail de confirma&ccedil;&atilde;o.<br/>";
        $msg .= "Entre em contato conosco, pelo menu CONTATO, e solicite o reenvio da sua chave de acesso.";
        HTML_ErrorMessage($msg);
        unset($_SESSION['temp']['erro_email']);
    }
//Mensagem de sucesso
    if ($_SESSION['temp']['cadastro_ok']) {
        $msg = "Cadastro atualizado com sucesso.<br/>";
        $msg .= "Um link de confirma&ccedil;ao foi enviado ao seu endere&ccedil;o de e-mail.<br/>";
        $msg .= "Para ativar sua conta clique no link enviado para o seu e-mail.";
        HTML_SuccessMessage($msg);
        unset($_SESSION['temp']['cadastro_ok']);
    }
    ?>

    <?php HTML_RequiredMessage() ?>

    <form class="forms" name="alt_dados" method="post" action="<?php echo $Esta_Pagina; ?>">

        <input type="hidden" name="alterar_dados" value="false" />
        <?php if ($result['documento'] == "sim"): ?>
            <label for="rg"><?php HTML_RequiredField() ?>CPF:</label>
            <input type="text" name="cpf" id="rg" maxlength="15" size="35" value="<?php echo $result['cpf'] ?>" disabled />
        <?php else: ?>
            <label for="rg"><?php HTML_RequiredField() ?>RG:</label>
            <input type="text" name="cpf" id="rg" maxlength="15" size="35" value="<?php echo $result['cpf'] ?>" disabled />
        <?php endif ?><br/><br/>


        <label for="nome">
            <?php HTML_RequiredField() ?>Nome Completo:
        </label>
        <input type="text" name="nome" id="nome" maxlength="50" size="35" value="<?php echo $result['nome'] ?>" />
        <br/><br/> 

        <!--<label for="cpf">
            CPF: (apenas números)
        </label>
        <input type="text" name="cpf" id="cpf" maxlength="11" size="35" value="<?php echo $result['cpf'] ?>" />
        <br/><br/>

        <label for="aluno" style="margin-right:30px">
        <?php HTML_RequiredField() ?>Você é aluno do IFSP - <i>Campus</i> Guarulhos?
        </label>
        <input type="radio" name="aluno" id="aluno" value="sim" <?php if ($aluno): ?>checked="checked" <?php endif ?>onclick="document.getElementById('aluno_sim').style.display='block';document.getElementById('aluno_nao').style.display='none';" />SIM
        <input type="radio" name="aluno" value="nao" <?php if (!$aluno): ?>checked="checked" <?php endif ?>style="margin-left:35px" onclick="document.getElementById('aluno_sim').style.display='none';document.getElementById('aluno_nao').style.display='block';" />NÃO
        <br/><br/> -->

        <span id="aluno_sim" <?php if ($aluno): ?>style="display:block;"<?php else: ?>style="display:none;"<?php endif ?>>
            <label for="prontuario">
                <?php HTML_RequiredField() ?>Prontu&aacute;rio: (apenas números e <b>X</b>, se houver)
            </label>
            <input type="text" name="prontuario" id="prontuario" maxlength="7" size="35" value="<?php echo $result['RA'] ?>" />
            <br/><br/>
        </span>

        <span id="aluno_nao" <?php if ($aluno): ?>style="display:none;"<?php else: ?>style="display:block;"<?php endif ?>>
            <label for="instituicao">Instituição ou Empresa:</label>
            <input type="text" name="instituicao" id="instituicao" maxlength="100" size="35" value="<?php echo $result['inst_empresa'] ?>" />
            <br/><br/>
        </span>

        <label for="endereco">Endereço: (rua, avenida, etc.)</label>
        <input type="text" name="endereco" id="endereco" maxlength="50" size="35" value="<?php echo $result['rua'] ?>" />
        <br/><br/>

        <label for="numero">N&ordm;:</label>
        <input type="text" name="numero" id="numero" maxlength="5" size="35" value="<?php echo $result['numero'] ?>" />
        <br/><br/>

        <label for="complemento">Complemento:</label>
        <input type="text" name="complemento" id="complemento" maxlength="30" size="35" value="<?php echo $result['complemento'] ?>" />
        <br/><br/>

        <label for="cep">CEP: (apenas números)</label>
        <input type="text" name="cep" id="cep" maxlength="8" size="35" value="<?php echo $result['cep'] ?>" />
        <br/><br/>

        <label for="bairro">Bairro:</label>
        <input type="text" name="bairro" id="bairro" maxlength="50" size="35" value="<?php echo $result['bairro'] ?>" />
        <br/><br/>

        <label for="cidade">Cidade:</label>
        <input type="text" name="cidade" id="cidade" maxlength="50" size="35" value="<?php echo $result['cidade'] ?>" />
        <br/><br/>

        <label for="uf">UF:</label>
        <select name="uf" id="uf">
            <?php
            $estado = array('', 'AC', 'AL', 'AM', 'AP', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA', 'MG',
                'MS', 'MT', 'PA', 'PB', 'PE', 'PI', 'PR', 'RJ', 'RN', 'RO', 'RR', 'RS', 'SC', 'SE', 'SP', 'TO');
            foreach ($estado as $sigla) {
                if ($sigla == $result['estado'])
                    echo"<option value=\"$sigla\" selected=\"selected\">$sigla</option>";
                else
                    echo"<option value=\"$sigla\">$sigla</option>";
            }
            ?>
        </select>
        <br/><br/>

        <label for="pais">País:</label>
        <input type="text" name="pais" id="pais" maxlength="30" size="35" value="<?php echo $result['pais'] ?>" />
        <br/><br/>

        <label for="tel">Telefone: (xx) xxxxx-xxxx</label>
        <input type="text" name="tel" id="tel" maxlength="15" size="35" value="<?php echo $result['telefone'] ?>" />
        <br/><br/>

        <label for="cel">Celular: (xx) xxxxx-xxxx</label>
        <input type="text" name="cel" id="cel" maxlength="15" size="35" value="<?php echo $result['tel_celular'] ?>" />
        <br/><br/>
        <?php
        $admin = "SELECT admin FROM participantes WHERE cpf='{$USER->getCpf()}'";
        $admin = mysql_fetch_array($DB->Query($admin));
        ?>
        <?php if (tipoadmin(8, $USER->getCpf(), $SCT_ID, 0)): ?>

            <label for="admin">Tipo:</label>
            <select name="admin" id="admin">
                <option value = "0" <?php
                if ($result['admin'] == 0) {
                    echo " selected";
                }
                ?>>Usuario Comum
                <option value = "1" <?php
                if ($result['admin'] == 1) {
                    echo " selected";
                }
                ?>>Visualiza Relatórios
                <option value = "2" <?php
                if ($result['admin'] == 2) {
                    echo " selected";
                }
                ?>>Lista de Presença
                <option value = "5" <?php
                if ($result['admin'] == 5) {
                    echo " selected";
                }
                ?>> Administrador de atividades
                <option value = "7" <?php
                if ($result['admin'] == 7) {
                    echo " selected";
                }
                ?>>Administrador do Evento
                            <?php if (tipoadmin(8, $USER->getCpf(), $SCT_ID, 0)): ?>
                    <option value = "8" <?php
                    if ($result['admin'] == 8) {
                        echo " selected";
                    }
                    ?>>Administrador do Sistema <?php endif; ?>
            </select>    
            <br><br>
        <?php endif; ?>
        <?php
        if (tipoadmin(8, $USER->getCpf(), $SCT_ID, 0)) {
            $query = "SELECT SEMTEC, NOME FROM edicao ORDER BY SEMTEC";
            $alleventos = $DB->Query($query);
            if (@mysql_num_rows($alleventos) <= 0):
                echo "";
            else:
                ?>
                <label for="eventos">Permissão nos eventos:</label><br>
                <?php while ($x = mysql_fetch_array($alleventos)):
                    ?>
                    <input type="checkbox" name="eventos[]" id="eventos[]"  value="<?php echo $x['SEMTEC'] ?>" <?php echo strpos($result['eventos'], $x['SEMTEC']) !== false ? 'checked' : '' ?>/> <?php echo $x['NOME'] ?><br>
                    <?php
                endwhile;
            endif;
            ?>
            <br/><br/>
        <?php } ?>

        <input type="submit" value="Atualizar dados" />
    </form>


    <hr style="margin: 30px 0px;" />

    <h3 style="background:url('') top left no-repeat;">
        Alterar seu e-mail.
    </h3>

    <form class="forms" name="alt_email" method="post" action="<?php echo $Esta_Pagina; ?>">
        <input type="hidden" name="cpf" id="cpf" maxlength="11" size="35" value="<?php echo substr($result['cpf'], 0, 3) . "." . substr($result['cpf'], 3, 3) . "." . substr($result['cpf'], 6, 3) . "-" . substr($result['cpf'], 9, 2) ?>" disabled="disabled" />
        <input type="hidden" name="nome" id="nome" maxlength="50" size="35" value="<?php echo $result['nome'] ?>" />

        <label for="emailatual">E-mail atual :</label>  <?php echo $result['email'] ?><?php if ($result['confirmado'] == 0): ?><font color="red"> Não Confirmado</font><?php endif; ?><br><br>
        <label for="email">
            <?php HTML_RequiredField() ?>Novo E-mail:
        </label>
        <input type="text" name="email" id="email" maxlength="50" size="35" value="" />
        <br/><br/>
        <label for="cemail">
            <?php HTML_RequiredField() ?>Confirma novo E-mail:
        </label>
        <input type="text" name="cemail" id="cemail" maxlength="50" size="35" value="" />
        <br/><br/>

        <input type="submit" value="Alterar E-mail" />
    </form>

    <hr style="margin: 30px 0px;" />

    <h3 style="background:url('') top left no-repeat;">
        Reset de senha de acesso.
    </h3>
    <?php

    function novaSenha() {
        $var = "";
        for ($i = 1; $i <= 8; $i++)
            $var .= substr("abcdefghijklmnopqrstuvwxyz1234567890", rand(0, 35), 1);
        return str_shuffle($var);
    }
    ?>
    <form class="forms" name="alt_senha" method="post" action="<?php echo $Esta_Pagina; ?>">
        <label for="senha">Nova senha:</label>
        <?php $novasenhaauto = novaSenha(); ?>
        <input type="text" name="exibirsenha" id="exibirsenha" maxlength="30" value="<?php echo $novasenhaauto ?>" readonly /><br>
        <input type="hidden" name="senha" id="senha" maxlength="30" value="<?php echo $novasenhaauto ?>" />
        <input type="hidden" name="csenha" id="csenha" maxlength="30" value="<?php echo $novasenhaauto ?>"/>
        <br/><br/>

        <input type="submit" value="Resetar Senha" />
    </form>

<?php } ?>
