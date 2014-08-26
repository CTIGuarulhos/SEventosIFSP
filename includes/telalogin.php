
<div id = "login">
    <?php if (!$SESSION->IsLoggedIn()): ?>

        <span class = "title lock"> Login </span>
        <form name = "login-form" method = "post" action = "<?php echo $CONFIG->URL_ROOT ?>/login.php">            
            <label for = "login"> E - MAIL: </label>
            <input type = "text" name = "login" id = "login" maxlength = "50" class = "textfield" />
            <br />
            <label for = "senha"> SENHA: </label>
            <input type = "password" name = "senha" id = "senha" maxlength = "99" class = "passfield" />
            <input type = "hidden" name = "redir" value = "<?php echo $Esta_Pagina ?>" />
            <input type = "submit" value = "&nbsp;entrar&nbsp;" class="submit" />    
            <!--<div style="float: right;"><br><a href = "javascript:RecuperarSenha();"> Não consigo acessar </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>-->
            <br class = "clear" />
        </form>
    </div>

    <div id = "login">
        <span class = "title lock"> Não consegue acessar? </span>
        <form name = "login-form" method = "post" action = "<?php echo $CONFIG->URL_ROOT ?>/login.php">            
            <input type = "hidden" name = "redir" value = "<?php echo $Esta_Pagina ?>" />
            <div style="float: left;">
                <input type = "button" value = "Recuperar senha" class = "submit" onclick="javascript:RecuperarSenha();" /></div>
            <br class = "clear" />
        </form>

        <span class = "title lock"> Primeiro acesso? </span>
        <form name = "login-form" method = "post" action = "<?php echo $CONFIG->URL_ROOT ?>/login.php">
            <!--<a href = "<?php echo $CONFIG->URL_ROOT ?>/?pag=cadastro">Primeiro acesso? CADASTRE-SE!</a><br>-->
            <input type = "hidden" name = "redir" value = "<?php echo $Esta_Pagina ?>" />
            <div style="float: left;">
                <input type = "button" value = "Cadastre-se" class = "submit" onclick="window.location = '<?php echo $CONFIG->URL_ROOT ?>/?pag=cadastro';" /></div>
            <br class = "clear" />
        </form>


    <?php else: ?>

        <span
            class = "title user"> Usuário </span>
        <span class = "box">
            <label> Nome </label>
            <font><?php echo $USER->getNome() ?> </font>
            <!--
            <label> CPF </label>
            <span id = "showHideCpf"> exibir </span>
            <font id = "showCPF"> </font> -->

            <label> E - mail </label>
            <font><?php echo $USER->getEmail() ?> </font>
            <!--
            <a href = "#"> <input type = "button" value = "alterar" /> </a>
            <a href = "<?php echo $CONFIG->URL_ROOT ?>/logout.php"> <input type = "button" value = "sair" /> </a>
            -->
        </span>

        <script type = "text/javascript">
            var _cpfFull = '<?php printf("%s.%s.%s-%s", substr($USER->getCpf(), 0, 3), substr($USER->getCpf(), 3, 3), substr($USER->getCpf(), 6, 3), substr($USER->getCpf(), 9, 2)) ?>';
            var _cpfHidden = '<?php printf("%s . *** . *** - %s", substr($USER->getCpf(), 0, 3), substr($USER->getCpf(), 9, 2)) ?>';
            $("#showCPF").html(_cpfHidden);
            $("#showHideCpf").css("float", "right");
            $("#showHideCpf").css("cursor", "pointer");
            $("#showHideCpf").css("color", "#00f");
            $("#showHideCpf").css("padding-right", "15px");
            $("#showHideCpf").css("background", "url('<?php echo $CONFIG->URL_ROOT ?>/templates/<?php echo $EVENTO['TEMPLATE'] ?>/imgs/arrow-down.png') top right no-repeat");

            $("#showHideCpf").click(function() {
                tempo = 200;
                if ($("#showCPF").html() == _cpfFull) {
                    $("#showCPF").fadeOut(tempo, function() {
                        $("#showCPF").html(_cpfHidden);
                        $("#showCPF").fadeIn(tempo);
                    });
                    $("#showHideCpf").html('exibir');
                    $("#showHideCpf").css("background", "url('<?php echo $CONFIG->URL_ROOT ?>/templates/<?php echo $EVENTO['TEMPLATE'] ?>/imgs/arrow-down.png') top right no-repeat");
                } else {
                    $("#showCPF").fadeOut(tempo, function() {
                        $("#showCPF").html(_cpfFull);
                        $("#showCPF").fadeIn(tempo);
                    });
                    $("#showHideCpf").html('ocultar');
                    $("#showHideCpf").css("background", "url('<?php echo $CONFIG->URL_ROOT ?>/templates/<?php echo $EVENTO['TEMPLATE'] ?>/imgs/arrow-up.png') top right no-repeat");
                }
            });
        </script>

    <?php endif ?>
</div>


