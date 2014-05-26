<?php
ob_start();
require "initialize.php";
global $CONFIG, $SESSION, $USER, $DB, $Return_URL, $Esta_Pagina, $EVENTO, $SCT_ID;
$Esta_Pagina = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$MODULO = $_GET["pag"];
if ($MODULO == "") {
    $MODULO = "home";
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <!-- <?= date("d/m/Y H:i:s") ?> -->
        <!-- INICIO HEAD -->

        <?php
        if (file_exists($CONFIG->DIR_ROOT . "/templates/" . $EVENTO['TEMPLATE'] . "/analytics.php")) {
            require($CONFIG->DIR_ROOT . "/templates/" . $EVENTO['TEMPLATE'] . "/analytics.php");
        }
        ?>

        <?php require($CONFIG->DIR_ROOT . "/includes/head.php"); ?>
        <!-- FIM HEAD -->
    </head>
    <body> 
        <? if (isset($_GET['SCT'])): ?>
            <? if ($_GET['SCT'] != $CONFIG->SCT_ID): ?>
                <?php $paginaatual = str_replace("&SCT=" . $_GET['SCT'], "", $Esta_Pagina); ?>
                <?php $paginaatual = str_replace("?SCT=" . $_GET['SCT'], "", $paginaatual); ?>
                <div style="background-color:red;text-align:center"><font color="yellow">Você está acessando este site para visualização de eventos anteriores, para o evento atual <strong><a href="<?= $paginaatual ?>">Clique aqui</a></strong></font></div><br>
            <? endif ?>
        <? endif ?>
        <div id = "pagina">
            <!-- INICIO CABECALHO -->
            <div id="carregando"></div>
            <?php if (isset($_SESSION['temp']['erro_login'])): ?>
                <script type="text/javascript">
                    $(document).ready(function() {
                        $("#carregando").fadeIn(300);
                        title = "Alerta";
    <?
    switch ($_SESSION['temp']['erro_login']) {
        case 1:
            echo 'msg = "Usu&aacute;rio não cadastrado.";';
            break;

        case 2:
            echo 'msg = "Senha incorreta. Caso não lembre, use o link de recuperar senha e uma nova será enviada para o seu endereço de email.";';
            break;

        case 3:
            echo 'msg = "Usu&aacute;rio pendente de confirmação. Sua chave de confirmação foi enviada para o endereço de email cadastrado. Caso não tenha recebido, aguarde alguns minutos e verifique sua caixa de spam. Se o problema persistir entre em contato conosco.";';
            break;
    }
    ?>
                        jAlert(msg, title, function() {
                            $("#carregando").fadeOut(300);
                        });
                    });
    <? unset($_SESSION['temp']['erro_login']); ?>
                </script>
            <? endif; ?>
            <div id = "banner" class="naoselecionavel">                
                <?php
                if (file_exists($CONFIG->DIR_ROOT . "/templates/" . $EVENTO['TEMPLATE'] . "/cabecalho.php")) {
                    require($CONFIG->DIR_ROOT . "/templates/" . $EVENTO['TEMPLATE'] . "/cabecalho.php");
                }
                ?>
            </div>
            <div id = "menu">
                <ul>
                    <?php require($CONFIG->DIR_ROOT . "/includes/menu.php") ?>
                    <?
                    if (file_exists($CONFIG->DIR_ROOT . "/templates/" . $EVENTO['TEMPLATE'] . "/menu.php")) {
                        require($CONFIG->DIR_ROOT . "/templates/" . $EVENTO['TEMPLATE'] . "/menu.php");
                    }
                    ?>
                </ul>
            </div>
            <!-- FIM CABECALHO -->
            <div id = "corpo">
                <?
                if ($MODULO == "home") {
                    if (file_exists($CONFIG->DIR_ROOT . "/templates/" . $EVENTO['TEMPLATE'] . "/fotos.php")) {
                        require($CONFIG->DIR_ROOT . "/templates/" . $EVENTO['TEMPLATE'] . "/fotos.php");
                    }
                }
                ?>
                <?php
                if (file_exists($CONFIG->DIR_ROOT . "/templates/" . $EVENTO['TEMPLATE'] . "/corpo.php")) {
                    require($CONFIG->DIR_ROOT . "/templates/" . $EVENTO['TEMPLATE'] . "/corpo.php");
                }
                ?>
                <!-- INICIO Carousel -->

                <!-- FIM Carousel -->
                <div id = "subMenu">
                    <!-- INICIO Tela de Login -->
                    <?php require($CONFIG->DIR_ROOT . "/includes/telalogin.php"); ?>
                    <!-- FIM Tela de Login -->
                    <!-- INICIO Menu -->
                    <?php
                    if ($SESSION->IsLoggedIn()) {
                        require($CONFIG->DIR_ROOT . "/includes/subMenu.php" );
                        require($CONFIG->DIR_ROOT . "/includes/subMenu-adm.php");
                    }
                    ?>
                    <!-- FIM Menu -->
                </div>

                <div id="conteudo">
                    <!-- Redes sociais flutuantes Baseado em http://www.gerenciandoblog.com.br -->
                    <div id="floating-fblog">
                        <div id="fblog-box">
                            <div>
                                <div id="fb-root">
                                </div>
                                <fb:like font="arial" href="<? echo $Esta_Pagina ?>" layout="box_count" send="true" show_faces="false" width="54"></fb:like>
                            </div>
                            <div>
                                <g:plusone size="tall"></g:plusone>
                            </div>
                            <div>
                                <a class="twitter-share-button" data-count="vertical" data-related="<? echo $EVENTO['NOME'] ?>" data-text="<? echo $EVENTO['NOME'] ?>" data-url="<? echo $Esta_Pagina ?>" href="http://twitter.com/share"></a>
                            </div>
                            <div>
                                <script src="http://platform.linkedin.com/in.js" type="text/javascript"></script>
                                <script type="IN/Share" data-counter="top" title-text="<? echo $EVENTO['NOME'] ?>"></script>
                            </div>
                        </div>
                    </div>
                    <script src="includes/js/sorttable.js"></script>
                    <!-- FIM Redes sociais flutuantes Baseado em http://www.gerenciandoblog.com.br -->
                    <!-- INICIO MODULO -->
                    <?php
                    if (substr($MODULO, 0, 3) == "adm") {
                        if (file_exists($CONFIG->DIR_ROOT . "/admin/" . substr($MODULO, 3) . ".php")) {
                            require($CONFIG->DIR_ROOT . "/admin/" . substr($MODULO, 3) . ".php");
                        } else {
                            require($CONFIG->DIR_ROOT . "/modulos/404.php");
                        }
                    } elseif (substr($MODULO, 0, 3) == "tmp") {
                        if (file_exists($CONFIG->DIR_ROOT . "/templates/" . $EVENTO['TEMPLATE'] . "/" . substr($MODULO, 3) . ".php")) {
                            require($CONFIG->DIR_ROOT . "/templates/" . $EVENTO['TEMPLATE'] . "/" . substr($MODULO, 3) . ".php");
                        } else {
                            require($CONFIG->DIR_ROOT . "/modulos/404.php");
                        }
                    } elseif (file_exists($CONFIG->DIR_ROOT . "/modulos/" . $MODULO . ".php")) {
                        require($CONFIG->DIR_ROOT . "/modulos/" . $MODULO . ".php");
                    } else {
                        require($CONFIG->DIR_ROOT . "/modulos/404.php");
                    }
                    ?>
                    <!-- FIM MODULO -->
                    <?php
                    if ($MODULO == "home") {
                        if (file_exists($CONFIG->DIR_ROOT . "/templates/" . $EVENTO['TEMPLATE'] . "/popup.php")) {
                            require($CONFIG->DIR_ROOT . "/templates/" . $EVENTO['TEMPLATE'] . "/popup.php");
                        }
                    }
                    ?>
                    <br><br class="clear"/>&nbsp;
                </div> 
            </div>
            <?php
            if (isset($header['js'])):
                foreach ($header['js'] as $js):
                    ?>
                    <script type="text/javascript" src="<?php echo $js['src'] ?>"></script>
                <?php endforeach; ?>
            <? endif ?>
            <?php
            if (isset($header['css'])):
                foreach ($header['css'] as $css):
                    ?>
                    <link type="text/css" rel="stylesheet" href="<?php echo $css['href'] ?>" media="<?php echo isset($css['media']) ? $css['media'] : "all" ?>" />
                <?php endforeach; ?>
            <? endif ?>
            <div id="rodape">
                <?php
                if (file_exists($CONFIG->DIR_ROOT . "/templates/" . $EVENTO['TEMPLATE'] . "/rodape.php")) {
                    require($CONFIG->DIR_ROOT . "/templates/" . $EVENTO['TEMPLATE'] . "/rodape.php");
                }
                ?>      
            </div>
        </div>

        <div class="noprint"><center>Desenvolvido por <strong><a href="<?php echo $CONFIG->URL_ROOT ?>/?pag=sobre">Equipe</a></strong></center><br></div>
                <?
                if (isset($Return_URL)) {
                    header("Location: $Return_URL");
                    unset($Return_URL);
                }
                ?>
                <?php
                /*                 * ********************************************** */
                /*                 * ***** EXIBE MENSAGENS DE ERRO SE HOUVER ****** */
                /*                 * ********************************************** */
                echo $Temp['erro_login'];
                if (isset($Temp['erro_login'])):
                    echo '<script type="text/javascript">' . "\n";
                    switch ($Temp['erro_login']) {
                        case 1:
                            //Usuário não cadastrado
                            include $CONFIG->DIR_ROOT . "/includes/js/ErrorLogin1.js";
                            unset($Temp['erro_login']);
                            break;

                        case 2:
                            //Senha incorreta
                            include $CONFIG->DIR_ROOT . "/includes/js/ErrorLogin2.js";
                            unset($Temp['erro_login']);
                            break;

                        case 3:
                            //Pendente de confirmação
                            include $CONFIG->DIR_ROOT . "/includes/js/ErrorLogin3.js";
                            unset($Temp['erro_login']);
                            break;
                    }
                    echo "\t" . '</script>';
                endif;
                /*                 * ********************************************** */
                if (file_exists($CONFIG->DIR_ROOT . "/templates/" . $EVENTO['TEMPLATE'] . "/fotos.php")) {
                    ?>

            <script>
                        $(document).ready(function() {
                            $('.fancybox').fancybox({
                                prevEffect: 'none',
                                nextEffect: 'none',
                                width: '90%',
                                height: '90%',
                                autoSize: false
                            });


                        });
                        $(document).ready(function() {
                            $(".fancybox-button").fancybox({
                                prevEffect: 'none',
                                nextEffect: 'none',
                                closeBtn: false,
                                helpers: {
                                    title: {type: 'inside'},
                                    buttons: {}
                                }
                            });
                        });
                        $("#caroufredsel").carouFredSel();
                        $("#caroufredsel a").fancybox({
                            cyclic: true,
                            onStart: function() {
                                $("#caroufredsel").trigger("pause");
                            },
                            onClosed: function() {
                                $("#caroufredsel").trigger("play");
                            }
                        });

            </script>
        <?php } ?>

    </body>
</html>