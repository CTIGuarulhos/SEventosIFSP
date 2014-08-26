<?php
#---------------------------------------------------------------------------#
if (isset($_POST['nome'])):
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $emaileixo = $_POST['emaileixo'];
    $files = $$_POST['files'];
    $dadosOK = true;
    //Nome
    if (strlen($nome) < 3) {
        $dadosOK = false;
    }

    //E-mail
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $dadosOK = false;
    }
    //E-mail
    if (strlen($_FILES['files']['name']) == 0) {
        $dadosOK = false;
    }

    if (strtolower($_POST['codigo']) != strtolower($_SESSION['letrasgd'])) {
        $dadosOK = false;
    }

    if ($dadosOK) {
        //Funções para envio da mensagem por email
        require_once($CONFIG->DIR_ROOT . "/templates/" . $EVENTO['TEMPLATE'] . "/email_submissao.php");

        $enviado = email_submissao($nome, $email, $emaileixo, $_FILES['files']['name'], $_FILES['files']['tmp_name'], $_FILES['files']['size']);
        $tentativas = 1;

        while ($enviado == false && $tentativas <= 3) {
            sleep(2);
            $enviado = email_submissao($nome, $email, $emaileixo, $_FILES['files']['name'], $_FILES['files']['tmp_name'], $_FILES['files']['size']);
            $tentativas++;
        }

        $dadosOK = $enviado ? true : false;

        //"Zera" os campos
        $nome = $email = $assunto = $msg = $emaileixo = "";
    }
endif;
#---------------------------------------------------------------------------#  
//$header['css'][] = array("href"=>CSS_DIR."/contato.css", "media"=>"all");
$_SESSION['letrasgd'] = gerarLetras();
?>
<?php
//Mensagem de erro (se houver)
if (isset($dadosOK) && !$dadosOK) {
    HTML_ErrorMessage("Erro ao enviar mensagem. Todos os campos são obrigat&oacute;rios!<br/>Certifique-se de ter digitado os dados corretamente.");
}
if (isset($dadosOK) && $dadosOK === true) {
    HTML_SuccessMessage("Submissão enviada com sucesso! Aguarde contato");
}
?>
<?php if (time() < mktime(00, 0, 0, 09, 16, 2012)): ?>

    <p style="margin-bottom: 0cm; line-height: 150%; font-family: Arial;"
       align="center"><font size="4"><b>NORMAS PARA
            INSCRIÇÃO E SUBMISSÃO DE PÔSTERES</b></font></p>
    <p style="margin-bottom: 0cm; line-height: 150%; font-family: Arial;"
       align="justify">
        <br>
    </p>
    <p style="margin-bottom: 0cm; line-height: 150%; font-family: Arial;"
       align="justify">
        A inscrição é aberta a toda e
        qualquer pessoa, desde que os trabalhos inscritos estejam de acordo
        com os critérios estabelecidos.</p>
    <p style="margin-bottom: 0cm; line-height: 150%; font-family: Arial;"
       align="justify">
        <br>
    </p>
    <p style="margin-bottom: 0cm; line-height: 150%; font-family: Arial;"
       align="justify">
        <b>CRITÉRIOS PARA A SELEÇÃO</b></p>
    <ol style="font-family: Arial;">
        <li>
            <p style="margin-bottom: 0cm; line-height: 150%;" align="justify">Os
                trabalhos devem contemplar estudos e experiências
                na área educacional ou ainda serem o resultado de pesquisas finalizadas
                ou em andamento, comprovado através de prototipagem, ambientes
                simulados ou modelagem matemática.</p>
        </li>
        <li>
            <p style="margin-bottom: 0cm; line-height: 150%;" align="justify">Autores
                e co-autores deverão estar inscritos.</p>
        </li>
        <li>
            <p style="margin-bottom: 0cm; line-height: 150%;" align="justify">Cada
                participante poderá inscrever apenas um trabalho
                como autor e co-autor.</p>
        </li>
        <li>
            <p style="margin-bottom: 0cm; line-height: 150%;" align="justify">Os
                trabalhos deverão necessariamente contemplar um
                dos eixos temáticos descritos abaixo:</p>
        </li>
    </ol>
    <ul style="font-family: Arial;">
        <li>
            <p
                style="margin-right: 1cm; margin-bottom: 0cm; widows: 2; orphans: 2;"
                align="justify"> <span style="font-variant: small-caps;">Formação
                    Docente para a Educação Básica</span> - Este eixo<font color="#222222">
                comporta estudos de abordagem teórica ou decorrentes de práticas
                pedagógicas vivenciadas em ambientes de ensino, </font>voltados à
                formação inicial e continuada de professores da Educação Básica.</p>
        </li>
        <li>
            <p
                style="margin-right: 1cm; margin-bottom: 0cm; widows: 2; orphans: 2;"
                align="justify"> S<span style="font-variant: small-caps;">ustentabilidade
                    e Desenvolvimento Econômico e Social</span> - <font color="#222222">Este
                eixo comporta trabalhos de natureza teórica ou prática que possibilitem
                iniciativas voltadas &nbsp;para maior racionalidade na utilização de
                recursos naturais, estimulem o crescimento
                sustentável&nbsp;e&nbsp;novas formas de consumo,&nbsp;e&nbsp;promovam a
                melhoria da qualidade de vida com diminuição das iniquidades.</font></p>
        </li>
        <li>
            <p
                style="margin-right: 1cm; margin-bottom: 0cm; widows: 2; orphans: 2;"
                align="justify"> <span style="font-variant: small-caps;">Praticas
                    Sustentáveis e desenvolvimento local</span> - Este eixo abrange
                trabalhos de investigação de métodos e práticas locais que possibilitem
                a promoção de políticas de desenvolvimento sustentado, como uso de
                novos <font color="#000000">materiais na construção, aproveitamento e
                consumo de fontes alternativas de energia, combate ao desperdício de
                água e de alimentos, entre outras práticas.</font></p>
        </li>
        <li>
            <p
                style="margin-right: 1cm; margin-bottom: 0cm; widows: 2; orphans: 2;"
                align="justify"> <span style="font-variant: small-caps;">Inovação
                    Tecnológica - </span><font color="#222222">Este eixo abrange trabalhos
                resultantes de investigação teórica ou prática ou ainda de pesquisa em
                andamento, voltados para a solução de situações e problemas, podendo
                comportar métodos, processos e produtos (bens e serviços).</font></p>
        </li>
    </ul>
    <p style="margin-left: 1.27cm; margin-bottom: 0cm; font-family: Arial;"
       align="justify">
        <br>
    </p>
    <ol style="font-family: Arial;" start="5">
        <li>
            <p style="margin-bottom: 0cm; line-height: 150%;" align="justify">Não
                serão aceitos trabalhos cujo conteúdo não
                contemple um dos eixos temáticos do evento.</p>
        </li>
    </ol>
    <p style="margin-bottom: 0cm; font-family: Arial;" align="justify"><br>
    </p>
    <p style="margin-bottom: 0cm; line-height: 150%; font-family: Arial;"
       align="justify">
        <b>SUBMISSÃO DE TRABALHOS</b></p>
    <ol style="font-family: Arial;">
        <li>
            <p style="margin-bottom: 0cm; line-height: 150%;" align="justify">Os
                trabalhos devem ser submetidos no formato de <b><a href="<?php echo $CONFIG->URL_ROOT . "/templates/" . $EVENTO['TEMPLATE'] ?>/docs/Modelo_Resumo.pdf">resumo
                        expandido</a>,</b> estruturado com no <b>mínimo 3</b> e no <b>máximo 5
                    páginas</b>, incluindo as referências bibliográficas.</p>
        </li>
        <li>
            <p style="margin-bottom: 0cm; line-height: 150%;" align="justify">O
                resumo deve conter: título, nome dos autores e
                co-autores, instituição de origem, endereço eletrônico, conforme
                template disponibilizado pelo evento no link abaixo, introdução,
                objetivos, metodologia, resultados e referências bibliográficas.</p>
        </li>
        <li>
            <p style="margin-bottom: 0cm; line-height: 150%;" align="justify">A
                digitação e formatação do texto devem obedecer às
                seguintes orientações:</p>
        </li>
    </ol>
    <ul style="font-family: Arial;">
        <li>
            <p style="margin-bottom: 0cm; line-height: 150%;" align="justify">Fonte:
                Times New Roman, tamanho 12;</p>
        </li>
        <li>
            <p style="margin-bottom: 0cm; line-height: 150%;" align="justify">Papel
                tamanho A4; </p>
        </li>
        <li>
            <p style="margin-bottom: 0cm; line-height: 150%;" align="justify">Margem
                superior e inferior com 2,5 cm;</p>
        </li>
        <li>
            <p style="margin-bottom: 0cm; line-height: 150%;" align="justify">Margem
                esquerda e direita com 3 cm; </p>
        </li>
        <li>
            <p style="margin-bottom: 0cm; line-height: 150%;" align="justify">Espaçamento
                entre linhas: simples;</p>
        </li>
        <li>
            <p style="margin-bottom: 0cm; line-height: 150%;" align="justify">Alinhamento:
                Justificado;</p>
        </li>
        <li>
            <p style="margin-bottom: 0cm; line-height: 150%;" align="justify">Título
                em maiúsculo/negrito com alinhamento
                centralizado;</p>
        </li>
        <li>
            <p style="margin-bottom: 0cm; line-height: 150%;" align="justify">Nome(s)
                do(s) autor(es) e instituição(ões) e email
                com alinhamento centralizado;</p>
        </li>
        <li>
            <p style="margin-bottom: 0cm; line-height: 150%;" align="justify">O
                título, o(s) nome(s) do(s) autor(es) e o corpo do
                texto devem ser separados por uma linha;</p>
        </li>
        <li>
            <p style="margin-bottom: 0cm; line-height: 150%;" align="justify">Três
                a cinco palavras-chave.</p>
        </li>
        <li>
            <p style="margin-bottom: 0cm; line-height: 150%;" align="justify">As
                citações e as notas devem seguir as normas da ABNT
                em vigor;</p>
        </li>
        <li>
            <p style="margin-bottom: 0cm; line-height: 150%;" align="justify">As
                referências bibliográficas devem ficar localizadas
                ao final do texto, contendo exclusivamente as obras citadas.</p>
        </li>
    </ul>
    <ol style="font-family: Arial;" start="4">
        <li>
            <p style="margin-bottom: 0cm; line-height: 150%;" align="justify">O
                texto do trabalho deve ser salvo em pdf como segue:
                eixo_tematico_nome_completo_do_primeiroautor.pdf</p>
            <p style="margin-bottom: 0cm; line-height: 150%;" align="justify"> <b>Exemplo:
                    formacao_docente_joao_dos_santos.pdf</b></p>
        </li>
        <li>
            <p style="margin-bottom: 0cm; line-height: 150%;" align="justify">Para
                enviar o arquivo, clicar no eixo desejado.</p>
        </li>
        <li>
            <p style="margin-bottom: 0cm; line-height: 150%;" align="justify">Não
                serão aceitos arquivos que não contenham
                referência ao eixo temático e nome completo do primeiro autor.</p>
        </li>
    </ol>
    <p style="margin-bottom: 0cm; line-height: 150%; font-family: Arial;"
       align="justify">
        <br>
    </p>
    <p style="margin-bottom: 0cm; line-height: 150%; font-family: Arial;"
       align="justify">
        <b>AVALIAÇÃO DOS TRABALHOS INSCRITOS</b></p>
    <ol style="font-family: Arial;">
        <li>
            <p style="margin-bottom: 0cm; line-height: 150%;" align="justify">Os
                trabalhos que atendam às orientações de formulação
                e formatação serão encaminhados, sem identificação de autoria, à
                Comissão de Avaliação Científica, que selecionará os trabalhos por Eixo
                Temático para serem apresentados na forma de pôster.</p>
        </li>
        <li>
            <p style="margin-bottom: 0cm; line-height: 150%;" align="justify">O
                resultado da avaliação será publicado um mês antes
                da realização do evento.</p>
        </li>
    </ol>
    <p style="margin-bottom: 0cm; line-height: 150%; font-family: Arial;"
       align="justify">
        .</p>
    <p style="margin-bottom: 0cm; line-height: 150%; font-family: Arial;"
       align="justify">
        <font color="#2a2a2a"><b>APRESENTAÇÃO
            DOS PÔSTERES:</b></font></p>
    <ol style="font-family: Arial;">
        <li>
            <p style="margin-bottom: 0cm; line-height: 150%;" align="justify"> <font
                    color="#2a2a2a">O pôster deverá ter as
                seguintes dimensões: 90 cm de largura por 120 cm de altura e obedecer à
                seguinte formatação:</font></p>
        </li>
    </ol>
    <ul style="font-family: Arial;">
        <li>
            <p style="margin-top: 0.05cm; margin-bottom: 0.05cm;"
               align="justify"> <font color="#111111">Textos legíveis a uma
                distância de, pelo menos, 1 m. </font> </p>
        </li>
        <li>
            <p style="margin-top: 0.05cm; margin-bottom: 0.05cm;"
               align="justify"> <font color="#111111">Tipo de letra “Arial”, no
                tamanho 36 para o título de seções, 27 para subtítulos e 24 para textos
                e resumos.</font></p>
        </li>
        <li>
            <p style="margin-top: 0.05cm; margin-bottom: 0.05cm;"
               align="justify"> <font color="#111111">Legenda de gráficos e imagens
                com tamanho da letra não inferior a 12.</font></p>
        </li>
        <li>
            <p style="margin-top: 0.05cm; margin-bottom: 0.05cm;"
               align="justify"> <font color="#111111">Conter no cabeçalho: título,
                nomes dos autores, instituição de origem, endereços eletrônicos. E no
                corpo: introdução, objetivos, metodologia, resultados e referências
                bibliográficas conforme ABNT. Ver template: <a href="<?php echo $CONFIG->URL_ROOT . "/templates/" . $EVENTO['TEMPLATE'] ?>/docs/Template_Poster1.ppt">Template_Poster1.ppt</a></font>
        </li>
        <li>
            <p style="margin-top: 0.05cm; margin-bottom: 0.05cm;"
               align="justify"> <font color="#111111">Figuras, fotos, esquemas e
                gráficos devem ter boa resolução (1028 x 1028 pixels), impresso em
                papel couchê, 240g, conforme template.</font></p>
        </li>
        <li>
            <p style="margin-top: 0.05cm; margin-bottom: 0.05cm;"
               align="justify"> <font color="#111111">Título deve ser o mesmo do
                resumo expandido, submetido à organização do evento.</font></p>
        </li>
        <li>
            <p style="margin-top: 0.05cm; margin-bottom: 0.05cm;"
               align="justify"> <font color="#111111">Conter logotipo da
                instituição, do evento e de agência de fomento, se houver.</font></p>
        </li>
        <li>
            <p style="margin-top: 0.05cm; margin-bottom: 0.05cm;"
               align="justify"> <font color="#111111">Conter cordão para permitir
                sua fixação.</font></p>
        </li>
    </ul>
    <ul style="font-family: Arial;">
        <ul>
            <p style="margin-top: 0.05cm; margin-bottom: 0.05cm;"
               align="justify"> </p>
        </ul>
    </ul>
    <ol style="font-family: Arial;" start="2">
        <li>
            <p style="margin-bottom: 0cm; line-height: 150%;" align="justify"> <font
                    color="#2a2a2a">Não serão aceitos pôsteres que
                não estejam de acordo com o padrão acima.</font></p>
        </li>
        <li>
            <p style="margin-bottom: 0cm; line-height: 150%;" align="justify"> <font
                    color="#2a2a2a">A apresentação dos pôsteres
                será realizada durante a sessão destinada a esse fim.</font></p>
        </li>
    </ol>
    <p style="margin-bottom: 0cm; font-family: Arial;" align="justify"><br>
    </p>
    <p style="margin-bottom: 0cm; line-height: 150%; font-family: Arial;"
       align="justify">
        <b>PUBLICAÇÃO E CERTIFICADOS</b></p>
    <ol style="font-family: Arial;">
        <li>
            <p style="margin-bottom: 0cm; line-height: 150%;" align="justify">Os
                trabalhos aprovados serão publicados nos anais do
                evento.</p>
        </li>
        <li>
            <p style="margin-bottom: 0cm; line-height: 150%;" align="justify">Será
                disponibilizado no site do evento <b>certificado
                    de participação</b> aos inscritos que comparecerem ao evento. </p>
        </li>
        <li>
            <p style="margin-bottom: 0cm; line-height: 150%;" align="justify">Aos
                apresentadores de trabalhos, também serão
                fornecidos <b>certificados</b>, mediante inscrição no evento,
                aprovação do trabalho pelo comitê científico, e comparecimento para
                apresentação do trabalho.</p>
        </li>
    </ol>

    <form class="forms"  name="email" action="<?php echo $Esta_Pagina ?>" method="POST" enctype="multipart/form-data"/>
    <label for="eixo"><span class="required-field">*</span> Eixo tecnológico:</label><br />
    <select name="emaileixo" id="emaileixo">
        <option value = ""  selected> ** Selecione **
        <option value = "FDEB" <?php if ($emaileixo == "FDEB") echo selected ?> > Formação Docente para a Educação Básica
        <option value = "SDES" <?php if ($emaileixo == "SDES") echo selected ?> > Sustentabilidade e Desenvolvimento Econômico e Social
        <option value = "PSDL" <?php if ($emaileixo == "PSDL") echo selected ?> > Práticas Sustentáveis e desenvolvimento local
        <option value = "INTE" <?php if ($emaileixo == "INTE") echo selected ?> > Inovação Tecnológica
        <!-- <option value = "TEST" <?php if ($emaileixo == "TEST") echo selected ?> > TESTE DE ENVIO -->
    </select><br/><br/>
    <label for="nome"><?php HTML_RequiredField() ?>Nome:</label><br/>
    <input type="text" value="<?php echo $nome ?>" name="nome" /><br /><br />
    <label for="nome"><?php HTML_RequiredField() ?>E-mail:</label><br/>
    <input type="text" value="<?php echo $email ?>" name="email" /><br /> <br />
    <label for="nome"><?php HTML_RequiredField() ?>Arquivo:</label><br/>
    <input type="file" value="<?php echo $files ?>" name="files" /><br /><br />  
    <td align="center"><img name="codigo" src="includes/gdimg.php?letrasgd=<?php echo $_SESSION['letrasgd']; ?>" alt="codigo" /></td><br><br>
    <label for="codigo"><?php HTML_RequiredField() ?>Código imagem:</label><br/>
    <input type="text" name="codigo" id="codigo" maxlength="5" size="13" />
    <br/><br>
    <input type="submit" value="Enviar" name="sub" /> 
    </form> 

<?php else : ?>

    <h3>A submissão de trabalhos está finalizada</h3>

<?php endif; ?>