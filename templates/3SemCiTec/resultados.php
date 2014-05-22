<?php
#---------------------------------------------------------------------------#
if (isset($_POST['nome'])):
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $assunto = $_POST['assunto'];
    $msg = $_POST['msg'];
    $emaileixo = $_POST['emaileixo'];
    $dadosOK = true;


    //Nome
    if (strlen($nome) < 3) {
        $dadosOK = false;
    }

    //E-mail
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $dadosOK = false;
    }

    //Assunto
    if (strlen($assunto) < 3 || strlen($assunto) > 90) {
        $dadosOK = false;
    }

    //Mensagem
    if (strlen(msg) < 3) {
        $dadosOK = false;
    }
    //EIXO
    if (!filter_var($emaileixos, FILTER_VALIDATE_EMAIL)) {
        $dadosOK = false;
    }

    if ($dadosOK) {
        //Funções para envio da mensagem por email
        require_once($CONFIG->DIR_ROOT . "/includes/email_submissao.php");

        $enviado = @email_contato($nome, $email, $assunto, $msg, $emaileixo);
        $tentativas = 1;

        while ($enviado == false && $tentativas <= 3) {
            sleep(2);
            $enviado = @email_contato($nome, $email, $assunto, $msg, $emaileixo);
            $tentativas++;
        }

        $dadosOK = $enviado ? true : false;

        //"Zera" os campos
        $nome = $email = $assunto = $msg = $emaileixo = "";
    }
endif;
#---------------------------------------------------------------------------#  
//$header['css'][] = array("href"=>CSS_DIR."/contato.css", "media"=>"all");
?>
<p
    style='padding: 0px; line-height: 19px; text-align: justify; outline-color: invert; outline-style: none; outline-width: medium;'><b
        style='line-height: 1.2em; outline-color: invert; outline-style: none; outline-width: medium;'><span
            style='line-height: 1.2em; outline-color: invert; outline-style: none; outline-width: medium; color: rgb(42, 42, 42);'>APRESENTAÇÃO
            DOS PÔSTERES:</span></b></p>
<p
    style='padding: 0px; line-height: 19px; text-align: justify; margin-left: 36pt; outline-color: invert; outline-style: none; outline-width: medium;'><span
        style='line-height: 1.2em; outline-color: invert; outline-style: none; outline-width: medium; color: rgb(42, 42, 42);'><font
            style='line-height: 1.2em; outline-color: invert; outline-style: none; outline-width: medium;'>1)</font><span
            style='line-height: normal; outline-color: invert; outline-style: none; outline-width: medium;'>&nbsp;
            &nbsp; &nbsp;</span><span
            style='line-height: normal; outline-color: invert; outline-style: none; outline-width: medium; background-color: rgb(255, 255, 0);'><font
                style='line-height: 1.2em; outline-color: invert; outline-style: none; outline-width: medium;'>A
            apresentação dos pôsteres será em 18/10, às 19, no Salão de Artes do
            Centro Municipal de Educação Adamastor Centro.</font></span></span></p>
<p
    style='padding: 0px; text-align: justify; margin-left: 36pt; outline-color: invert; outline-style: none; outline-width: medium;'><font
        color='#2a2a2a'><span style='line-height: 16px;'>2)&nbsp;&nbsp; &nbsp;
        Os pôsteres poderão ser afixados a partir do dia 17/10 no local
        especificado no item 1.</span></font></p>
<p
    style='padding: 0px; line-height: 19px; text-align: justify; margin-left: 36pt; outline-color: invert; outline-style: none; outline-width: medium;'><span
        style='line-height: 1.2em; outline-color: invert; outline-style: none; outline-width: medium; color: rgb(42, 42, 42);'><span
            style='line-height: normal; outline-color: invert; outline-style: none; outline-width: medium;'><font
                style='line-height: 1.2em; outline-color: invert; outline-style: none; outline-width: medium;'>3)
            </font></span></span><span
        style='outline-color: invert; outline-style: none; outline-width: medium; color: rgb(42, 42, 42);'>&nbsp;&nbsp;&nbsp;
        O pôster deverá ter as seguintes dimensões: 90 cm de largura por 120 cm
        de altura e obedecer à seguinte formatação:</span></p>
<p
    style='margin: 1.4pt 0cm 1.4pt 54pt; padding: 0px; line-height: 15.9333px; text-align: justify; outline-color: invert; outline-style: none; outline-width: medium;'><font
        style='line-height: 1.2em; outline-color: invert; outline-style: none; outline-width: medium;'><span
        style='line-height: 1.2em; outline-color: invert; outline-style: none; outline-width: medium; color: rgb(17, 17, 17);'>·&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span
        style='line-height: 1.2em; outline-color: invert; outline-style: none; outline-width: medium; color: rgb(17, 17, 17);'>Textos
        legíveis a uma distância de, pelo menos, 1 m.</span></font></p>
<p
    style='margin: 1.4pt 0cm 1.4pt 54pt; padding: 0px; line-height: 15.9333px; text-align: justify; outline-color: invert; outline-style: none; outline-width: medium;'><font
        style='line-height: 1.2em; outline-color: invert; outline-style: none; outline-width: medium;'><span
        style='line-height: 1.2em; outline-color: invert; outline-style: none; outline-width: medium; color: rgb(17, 17, 17);'>·&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span
        style='line-height: 1.2em; outline-color: invert; outline-style: none; outline-width: medium; color: rgb(17, 17, 17);'>Tipo
        de letra “Arial”, no tamanho 36 para o título de seções, 27 para
        subtítulos e 24 para textos e resumos.</span></font></p>
<p
    style='margin: 1.4pt 0cm 1.4pt 54pt; padding: 0px; line-height: 15.9333px; text-align: justify; outline-color: invert; outline-style: none; outline-width: medium;'><font
        style='line-height: 1.2em; outline-color: invert; outline-style: none; outline-width: medium;'><span
        style='line-height: 1.2em; outline-color: invert; outline-style: none; outline-width: medium; color: rgb(17, 17, 17);'>·&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span
        style='line-height: 1.2em; outline-color: invert; outline-style: none; outline-width: medium; color: rgb(17, 17, 17);'>Legenda
        de gráficos e imagens com tamanho da letra não inferior a 12.</span></font></p>
<p
    style='margin: 1.4pt 0cm 1.4pt 54pt; padding: 0px; line-height: 15.9333px; text-align: justify; outline-color: invert; outline-style: none; outline-width: medium;'><font
        style='line-height: 1.2em; outline-color: invert; outline-style: none; outline-width: medium;'><span
        style='line-height: 1.2em; outline-color: invert; outline-style: none; outline-width: medium; color: rgb(17, 17, 17);'>·&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span
        style='line-height: 1.2em; outline-color: invert; outline-style: none; outline-width: medium; color: rgb(17, 17, 17);'>Conter
        no cabeçalho: título, nomes dos autores, instituição de origem,
        endereços eletrônicos. E no corpo:&nbsp; introdução, objetivos,
        metodologia, resultados e referências bibliográficas conforme ABNT. Ver template: <a href="<?= $CONFIG->URL_ROOT . "/templates/" . $EVENTO['TEMPLATE'] ?>/docs/Template_Poster1.ppt">Template_Poster1.ppt</a></span></font></p>
<p
    style='margin: 1.4pt 0cm 1.4pt 54pt; padding: 0px; line-height: 15.9333px; text-align: justify; outline-color: invert; outline-style: none; outline-width: medium;'><font
        style='line-height: 1.2em; outline-color: invert; outline-style: none; outline-width: medium;'><span
        style='line-height: 1.2em; outline-color: invert; outline-style: none; outline-width: medium; color: rgb(17, 17, 17);'>·&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span
        style='line-height: 1.2em; outline-color: invert; outline-style: none; outline-width: medium; color: rgb(17, 17, 17);'>Figuras,
        fotos, esquemas e gráficos devem ter boa resolução (1028 x 1028
        pixels), impresso em papel couchê, 240g, conforme template.</span></font></p>
<p
    style='margin: 1.4pt 0cm 1.4pt 54pt; padding: 0px; line-height: 15.9333px; text-align: justify; outline-color: invert; outline-style: none; outline-width: medium;'><font
        style='line-height: 1.2em; outline-color: invert; outline-style: none; outline-width: medium;'><span
        style='line-height: 1.2em; outline-color: invert; outline-style: none; outline-width: medium; color: rgb(17, 17, 17);'>·&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span
        style='line-height: 1.2em; outline-color: invert; outline-style: none; outline-width: medium; color: rgb(17, 17, 17);'>Título
        deve ser o mesmo do resumo expandido, submetido à organização do evento.</span></font></p>
<p
    style='margin: 1.4pt 0cm 1.4pt 54pt; padding: 0px; line-height: 15.9333px; text-align: justify; outline-color: invert; outline-style: none; outline-width: medium;'><font
        style='line-height: 1.2em; outline-color: invert; outline-style: none; outline-width: medium;'><span
        style='line-height: 1.2em; outline-color: invert; outline-style: none; outline-width: medium; color: rgb(17, 17, 17);'>·&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span
        style='line-height: 1.2em; outline-color: invert; outline-style: none; outline-width: medium; color: rgb(17, 17, 17);'>Conter
        logotipo da instituição, do evento e de agência de fomento, se houver.</span></font></p>
<p
    style='margin: 1.4pt 0cm 1.4pt 54pt; padding: 0px; line-height: 15.9333px; text-align: justify; outline-color: invert; outline-style: none; outline-width: medium;'><font
        style='line-height: 1.2em; outline-color: invert; outline-style: none; outline-width: medium;'><span
        style='line-height: 1.2em; outline-color: invert; outline-style: none; outline-width: medium; color: rgb(17, 17, 17);'>·&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span
        style='line-height: 1.2em; outline-color: invert; outline-style: none; outline-width: medium; color: rgb(17, 17, 17);'>Conter
        cordão para permitir sua fixação.</span></font></p>
<p
    style='margin: 1.4pt 0cm; padding: 0px; line-height: 15.9333px; text-align: justify; outline-color: invert; outline-style: none; outline-width: medium;'><font
        style='line-height: 1.2em; outline-color: invert; outline-style: none; outline-width: medium;'>&nbsp;</font></p>
<p
    style='padding: 0px; line-height: 19px; text-align: justify; margin-left: 36pt; outline-color: invert; outline-style: none; outline-width: medium;'><font
        style='line-height: 1.2em; outline-color: invert; outline-style: none; outline-width: medium;'><span
        style='line-height: 1.2em; outline-color: invert; outline-style: none; outline-width: medium; color: rgb(42, 42, 42);'>4)<span
            style='line-height: normal; outline-color: invert; outline-style: none; outline-width: medium;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></span><span
        style='line-height: 1.2em; outline-color: invert; outline-style: none; outline-width: medium; color: rgb(42, 42, 42);'>Não
        serão aceitos pôsteres que não estejam de acordo com o padrão acima.</span></font></p>
<p
    style='padding: 0px; line-height: 19px; text-align: justify; margin-left: 36pt; outline-color: invert; outline-style: none; outline-width: medium;'><font
        style='line-height: 1.2em; outline-color: invert; outline-style: none; outline-width: medium;'><span
        style='line-height: 1.2em; outline-color: invert; outline-style: none; outline-width: medium; color: rgb(42, 42, 42);'></span></font><font
        style='line-height: 1.2em; outline-color: invert; outline-style: none; outline-width: medium;'><span
        style='line-height: 19px; outline-color: invert; outline-style: none; outline-width: medium; text-align: justify; color: rgb(42, 42, 42);'>5)<span
            style='line-height: normal; outline-color: invert; outline-style: none; outline-width: medium;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></span><span
        style='line-height: 19px; outline-color: invert; outline-style: none; outline-width: medium; text-align: justify; color: rgb(42, 42, 42);'>A
        apresentação dos pôsteres será realizada tão somente durante a sessão
        destinada a esse fim.</span> </font><br>
</p>
<p
    style='padding: 0px; line-height: 19px; text-align: justify; margin-left: 36pt; outline-color: invert; outline-style: none; outline-width: medium;'>6)&nbsp;&nbsp;&nbsp;
    &nbsp; Em caso de dúvidas, entrar em contato com o comitê organizador
    do evento.</p>


<center><big><big><a href="<?= $CONFIG->URL_ROOT . "/templates/" . $EVENTO['TEMPLATE'] ?>/docs/resultado_final.pdf">Resultado Final</a></big></big></center>


