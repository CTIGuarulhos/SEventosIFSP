<meta http-equiv="Content-Type" content="text/html; charset=<?= $CONFIG->CHARSET ?>">

<meta property="og:title" content="<?php echo $EVENTO['NOME'] ?>" />
<meta property="og:type" content="website" />
<meta property="og:url" content="<?php echo $CONFIG->URL_ROOT ?>" />
<meta property="og:image" content="<?php echo $CONFIG->URL_ROOT ?>/templates/<?php echo $EVENTO['TEMPLATE'] ?>/imgs/LogoFB.png" />
<meta property="og:site_name" content="<?php echo $EVENTO['NOME'] ?>" />
<meta property="og:description" content="<?php echo $EVENTO['NOME'] ?>" />
<meta property="og:locale" content="pt_br" />
<meta property="fb:admins" content="652294089" />


<meta name="author" content="IFSP - São Carlos + IFSP - Campus Guarulhos" />
<meta name="robots" content="index,follow" />

<!-- Javascript -->
<script type="text/javascript" src="<?php echo $CONFIG->URL_ROOT ?>/includes/js/jquery.js"></script>       
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo $CONFIG->URL_ROOT ?>/includes/js/jquery.corner.js"></script>
<script type="text/javascript" src="<?php echo $CONFIG->URL_ROOT ?>/includes/js/dragable.js"></script>
<script type="text/javascript" src="<?php echo $CONFIG->URL_ROOT ?>/includes/js/jquery.alerts.js"></script>
<script type="text/javascript" src="<?php echo $CONFIG->URL_ROOT ?>/includes/js/layout.js.php"></script>
<!-- FIM Javascript -->
<!-- INICIO Editor -->
<script type="text/javascript" src="http://js.nicedit.com/nicEdit-latest.js"></script> 
<script type="text/javascript">
//<![CDATA[
    bkLib.onDomLoaded(function() {
        nicEditors.allTextAreas({fullPanel: true})
    });
    //]]>
</script>
<!-- FIM Editor -->
<!-- INICIO CarouFredSel -->
<link rel="stylesheet" href="<?php echo $CONFIG->URL_ROOT ?>/carouFredSel/jquery.carouFredSel-6.2.1.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?php echo $CONFIG->URL_ROOT ?>/carouFredSel/jquery.carouFredSel-6.2.1.js"></script>
<!-- FIM CarouFredSel -->
<!-- INICIO FancyBox -->
<link rel="stylesheet" href="<?php echo $CONFIG->URL_ROOT ?>/fancybox/jquery.fancybox.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?php echo $CONFIG->URL_ROOT ?>/fancybox/jquery.fancybox.pack.js"></script>
<!--FIM FancyBox -->

<script type="text/javascript">
    <!--
     function AbreCracha(url) {
        window.open(url, "Cracha", "status = 1, height = 450, width = 365, resizable = 0")
    }
    // -->
</script>

<!-- Redes sociais flutuantes Baseado em http://www.gerenciandoblog.com.br -->
<script src='https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js' type='text/javascript'></script>
<script type='text/javascript'>
    var $floatbox = jQuery.noConflict();
    $floatbox(function() {
        var offset = $floatbox("#fblog-box").offset();
        var topPadding = 100;
        $floatbox(window).scroll(function() {
            if ($floatbox(window).scrollTop() > offset.top) {
                $floatbox("#fblog-box").stop().animate({
                    marginTop: $floatbox(window).scrollTop() - offset.top + topPadding
                });
            } else {
                $floatbox("#fblog-box").stop().animate({
                    marginTop: 0
                });
            }
            ;
        });
    });</script>
<script src="http://connect.facebook.net/pt_BR/all.js#xfbml=1"></script>
<script src='http://platform.twitter.com/widgets.js' type='text/javascript'></script>
<script src='https://apis.google.com/js/plusone.js' type='text/javascript'>
    {
        lang: 'pt-BR';
    }
</script>
<style type='text/css'>
    #floating-fblog {width:60px;}
    #fblog-box {border:1px solid #ccc; padding:5px; background:#fff; z-index:8009; display:block; position:absolute; top:226px; float:left; margin:0 0 0 -350px; text-align:center;}
    #fblog-box div {margin:0 0 5px;}
</style>
<!-- FIM Redes sociais flutuantes Baseado em http://www.gerenciandoblog.com.br --> 

<!-- TESTE DE CTRL -->
<script>
    function disableCtrlModifer(evt)
    {
        var disabled = {a: 0, c: 0, x: 0, v: 0};
        var ctrlMod = (window.event) ? window.event.ctrlKey : evt.ctrlKey;
        var key = (window.event) ? window.event.keyCode : evt.which;
        key = String.fromCharCode(key).toLowerCase();
        return (ctrlMod && (key in disabled)) ? false : true;
    }
</script>
<script>
    <!--
    var mensagem = "";
    function clickIE() {
        if (document.all) {
            (mensagem);
            return false;
        }
    }
    function clickNS(e) {
        if
                (document.layers || (document.getElementById && !document.all)) {
            if (e.which == 2 || e.which == 3) {
                (mensagem);
                return false;
            }
        }
    }
    if (document.layers)
    {
        document.captureEvents(Event.MOUSEDOWN);
        document.onmousedown = clickNS;
    }
    else {
        document.onmouseup = clickNS;
        document.oncontextmenu = clickIE;
    }
    document.oncontextmenu = new Function("return false")
    // --> 
</script>
<!-- FIM TESTE DE CTRL -->

<!-- CSS -->
<link type="text/css" rel="stylesheet" href="<?php echo $CONFIG->URL_ROOT ?>/includes/css/site.css" />
<link type="text/css" rel="stylesheet" href="<?php echo $CONFIG->URL_ROOT ?>/templates/<?php echo $EVENTO['TEMPLATE'] ?>/css/estilo.css" />
<link type="text/css" rel="stylesheet" href="<?php echo $CONFIG->URL_ROOT ?>/templates/<?php echo $EVENTO['TEMPLATE'] ?>/css/jquery.alerts.css" />
<link href='http://fonts.googleapis.com/css?family=Roboto:400,400italic,700&subset=latin' rel='stylesheet' type='text/css'>
<!-- FIM CSS -->

<title><?php echo $EVENTO['NOME'] ?></title>