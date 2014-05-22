<?php
// no direct access
global $CONFIG, $EVENTO, $DB;
isset($CONFIG) or exit('Acesso Restrito');

/**
 * Escreve uma mensagem padrão para informar os campos obrigatórios
 * [@param string $message - mensagem a ser exibida]
 * @return string - retorna o HTML com a mensagem formatada
 */
function HTML_RequiredMessage($message = false) {

    if ($message === false) {
        $message = '<span class="required-field">*</span> Campos de preenchimento obrigatório.';
    }
    ?>

    <span class="required-message">
        <?php echo $message ?>
    </span>

    <?php
}

function HTML_DocumentoMessage($message = false) {

    if ($message === false)
        $message = '<span class="required-field">**</span> O documento informado será impresso nos certificados de participação dos eventos. <b><font color="red">ATENÇÃO!</font></b> Este número não poderá ser modificado após a realização do cadastro.';
    ?>

    <span class="required-message">
        <?php echo $message ?>
    </span>

    <?php
}

//end of function HTML_RequiredMessage()

/**
 * Escreve um asterisco indcando obrigatoriedade de preenchimento
 * [@param string $message - mensagem a ser exibida]
 * @return string - retorna o HTML com a mensagem formatada 
 */
function HTML_RequiredField($message = false) {

    if ($message === false)
        $message = '*';
    echo '<span class="required-field">' . $message . '</span> ';
}

//end of function HTML_RequiredField()

/**
 * 
 */
function HTML_ErrorMessage($stringArray) {

    echo '<div class="error-message">';
    if (is_array($stringArray)) {
        foreach ($stringArray as $erro)
            echo "<p>{$erro}</p>";
    } else {
        echo "<p>{$stringArray}</p>";
    }
    echo '</div>';
}

//end of function HTML_ErrorMessage()

/**
 * 
 */
function HTML_SuccessMessage($message) {
    ?>

    <div class="success-message">
        <?php echo $message ?>
    </div>

    <?php
}

//end of function HTML_SuccessMessage()

/**
 * 
 */
function HTML_ListFilter($listFilterID, $tableID) {
//Prepara os parametros
    $listFilterID = (substr($listFilterID, 0, 1) == '#') ? substr($listFilterID, 1) : $listFilterID;
    $tableID = (substr($tableID, 0, 1) == '#') ? $tableID : '#' . $tableID;

    $listItens = array('A-Z', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
    $listLabel = array('all', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');

    echo "<div id=\"{$listFilterID}\" class=\"listFilter\">\n\t\t\t";

    foreach ($listItens as $index => $item) {
        echo "<span title=\"{$listLabel[$index]}\">{$item}</span>&nbsp;";
    }

    echo "\n\t\t\t</div>\n\t\t\t";
    echo "<script type=\"text/javascript\">";
    echo "\$(document).ready(function(){ activeListFilter('{$listFilterID}','{$tableID}'); });";
    echo "</script>";
}

//end of function HTML_ListFilter()

function pinclude($file, $type, $get = null) {
    $p = explode('/', $file);
    $file = end($p);
    $dir = '';
    $n = count($p) - 1;

    for ($i = 0; $i < $n; $i++)
        $dir .= $p[$i] . '/';

    if ($get !== null) {
        $tmp = $_GET; // back up
        $_GET = array();
        $get = explode('&', $get);
        $n = count($get);

        for ($i = 0; $i < $n; $i++) {
            if (strpos($get[$i], '=') === false)
                $_GET[$get[$i]] = 1;
            else {
                list($name, $val) = explode('=', $get[$i], 2);
                $_GET[$name] = $val;
            }
        }
    }

    ob_start();
//echo $dir;
    ini_set('display_errors', 'Off');
    chdir($dir);
    ini_set('display_errors', 'On');
    require $file;
    $out = ob_get_clean();

    if ($tmp)
        $_GET = $tmp;

    return $out;
}

function exibir_fotos_picasa($userid, $album) {
    echo '<div id="vlightbox">';
    $feedURL = "http://picasaweb.google.com/data/feed/api/user/$userid/album/$album?imgmax=912";
    $sxml = simplexml_load_file($feedURL);
    if (!$sxml) {
        $feedURL = "http://picasaweb.google.com/data/feed/api/user/$userid/albumid/$album?imgmax=912";
        $sxml = simplexml_load_file($feedURL);
    }
    echo'<h2>Album: ' . $sxml->title . '</h2>';
    foreach ($sxml->entry as $entry) {
        $title = $entry->title;
        $summary = $entry->summary;
        $gphoto = $entry->children('http://schemas.google.com/photos/2007');
        $size = $gphoto->size;
        $height = $gphoto->height;
        $width = $gphoto->width;
        $media = $entry->children('http://search.yahoo.com/mrss/');
        $thumbnail = $media->group->thumbnail[1];
        $content = $media->group->content;
        $tags = $media->group->keywords;
        echo "<a href=\"";
        echo $content->attributes()->{'url'};
        echo "\" class=\"fancybox-button\" target=\"_blank\" rel=\"$album\" title=\"";
        echo $summary;
        echo "\"> <img src=\"";
        echo $thumbnail->attributes()->{'url'};
        echo "\" /></a>";
        echo "\n";
    }
    echo '</div>';
}

function exibir_caroufredsel_picasa($userid, $album) {
    echo "<center>";
    echo "<div style=\"background-color: white; height:140px\">";
    echo "<div class=\"image_carousel\"><div id=\"caroufredsel\">";
    $feedURL = "http://picasaweb.google.com/data/feed/api/user/$userid/album/$album?imgmax=912";
    $sxml = simplexml_load_file($feedURL);
    if (!$sxml) {
        $feedURL = "http://picasaweb.google.com/data/feed/api/user/$userid/albumid/$album?imgmax=912";
        $sxml = simplexml_load_file($feedURL);
    }
    foreach ($sxml->entry as $entry) {
        $title = $entry->title;
        $summary = $entry->summary;
        $gphoto = $entry->children('http://schemas.google.com/photos/2007');
        $size = $gphoto->size;
        $height = $gphoto->height;
        $width = $gphoto->width;
        $media = $entry->children('http://search.yahoo.com/mrss/');
        $thumbnail = $media->group->thumbnail[1];
        $content = $media->group->content;
        $tags = $media->group->keywords;
        echo "<a rel=\"fancybox\" href=\"";
        echo $content->attributes()->{'url'};
        echo "\"><img src=\"";
        echo $thumbnail->attributes()->{'url'};
        echo "\" title=\"";
        echo $summary;
        echo "\"/></a>";
        echo "\n";
    }
    echo "</div><div class=\"clearfix\"></div></div></div>";
    echo "</center>";
}

function substituir_acentos($msgact) {
    $msgact = str_replace("º", '&deg;', $msgact);
    $msgact = str_replace("´", '&acute;', $msgact);
    $msgact = str_replace(",", ',', $msgact);
    $msgact = str_replace("¸", ',', $msgact);
    $msgact = str_replace("...", '…', $msgact);
    $msgact = str_replace("^", 'ˆ', $msgact);
    $msgact = str_replace("–", '–', $msgact);
    $msgact = str_replace("~", '˜', $msgact);
    $msgact = str_replace("¬", '&not;', $msgact);
    $msgact = str_replace("À", '&Agrave;', $msgact);
    $msgact = str_replace("Á", '&Aacute;', $msgact);
    $msgact = str_replace("Â", '&Acirc;', $msgact);
    $msgact = str_replace("Ã", '&Atilde;', $msgact);
    $msgact = str_replace("Ä", '&Auml;', $msgact);
    $msgact = str_replace("à", '&agrave;', $msgact);
    $msgact = str_replace("á", '&aacute;', $msgact);
    $msgact = str_replace("â", '&acirc;', $msgact);
    $msgact = str_replace("ã", '&atilde;', $msgact);
    $msgact = str_replace("ä", '&auml;', $msgact);
    $msgact = str_replace("È", '&Egrave;', $msgact);
    $msgact = str_replace("É", '&Eacute;', $msgact);
    $msgact = str_replace("Ê", '&Ecirc;', $msgact);
    $msgact = str_replace("Ë", '&Euml;', $msgact);
    $msgact = str_replace("è", '&egrave;', $msgact);
    $msgact = str_replace("é", '&eacute;', $msgact);
    $msgact = str_replace("ê", '&ecirc;', $msgact);
    $msgact = str_replace("ë", '&euml;', $msgact);
    $msgact = str_replace("Ì", '&Igrave;', $msgact);
    $msgact = str_replace("Í", '&Iacute;', $msgact);
    $msgact = str_replace("Î", '&Icirc;', $msgact);
    $msgact = str_replace("Ï", '&Iuml;', $msgact);
    $msgact = str_replace("ì", '&igrave;', $msgact);
    $msgact = str_replace("í", '&iacute;', $msgact);
    $msgact = str_replace("î", '&icirc;', $msgact);
    $msgact = str_replace("ï", '&iuml;', $msgact);
    $msgact = str_replace("Ò", '&Ograve;', $msgact);
    $msgact = str_replace("Ó", '&Oacute;', $msgact);
    $msgact = str_replace("Ô", '&Ocirc;', $msgact);
    $msgact = str_replace("Õ", '&Otilde;', $msgact);
    $msgact = str_replace("Ö", '&Ouml;', $msgact);
    $msgact = str_replace("ò", '&ograve;', $msgact);
    $msgact = str_replace("ó", '&oacute;', $msgact);
    $msgact = str_replace("ô", '&ocirc;', $msgact);
    $msgact = str_replace("õ", '&otilde;', $msgact);
    $msgact = str_replace("ö", '&ouml;', $msgact);
    $msgact = str_replace("Ù", '&Ugrave;', $msgact);
    $msgact = str_replace("Ú", '&Uacute;', $msgact);
    $msgact = str_replace("Û", '&Ucirc;', $msgact);
    $msgact = str_replace("Ü", '&Uuml;', $msgact);
    $msgact = str_replace("ù", '&ugrave;', $msgact);
    $msgact = str_replace("ú", '&uacute;', $msgact);
    $msgact = str_replace("û", '&ucirc;', $msgact);
    $msgact = str_replace("ü", '&uuml;', $msgact);
    $msgact = str_replace("ç", '&ccedil;', $msgact);
    $msgact = str_replace("Ç", '&Ccedil;', $msgact);
    return $msgact;
}

function remover_acentos($msgsact) {
    $msgsact = substituir_acentos($msgsact);
    $msgsact = str_replace('&deg;', "", $msgsact);
    $msgsact = str_replace('&acute;', "", $msgsact);
    $msgsact = str_replace('&cedil;', "", $msgsact);
    $msgsact = str_replace('…', "", $msgsact);
    $msgsact = str_replace('ˆ', "", $msgsact);
    $msgsact = str_replace('–', "", $msgsact);
    $msgsact = str_replace('˜', "", $msgsact);
    $msgsact = str_replace('&not;', "", $msgsact);
    $msgsact = str_replace('&Agrave;', "A", $msgsact);
    $msgsact = str_replace('&Aacute;', "A", $msgsact);
    $msgsact = str_replace('&Acirc;', "A", $msgsact);
    $msgsact = str_replace('&Atilde;', "A", $msgsact);
    $msgsact = str_replace('&Auml;', "A", $msgsact);
    $msgsact = str_replace('&agrave;', "a", $msgsact);
    $msgsact = str_replace('&aacute;', "a", $msgsact);
    $msgsact = str_replace('&acirc;', "a", $msgsact);
    $msgsact = str_replace('&atilde;', "a", $msgsact);
    $msgsact = str_replace('&auml;', "a", $msgsact);
    $msgsact = str_replace('&Egrave;', "E", $msgsact);
    $msgsact = str_replace('&Eacute;', "E", $msgsact);
    $msgsact = str_replace('&Ecirc;', "E", $msgsact);
    $msgsact = str_replace('&Euml;', "E", $msgsact);
    $msgsact = str_replace('&egrave;', "e", $msgsact);
    $msgsact = str_replace('&eacute;', "e", $msgsact);
    $msgsact = str_replace('&ecirc;', "e", $msgsact);
    $msgsact = str_replace('&euml;', "e", $msgsact);
    $msgsact = str_replace('&Igrave;', "I", $msgsact);
    $msgsact = str_replace('&Iacute;', "I", $msgsact);
    $msgsact = str_replace('&Icirc;', "I", $msgsact);
    $msgsact = str_replace('&Iuml;', "I", $msgsact);
    $msgsact = str_replace('&igrave;', "i", $msgsact);
    $msgsact = str_replace('&iacute;', "i", $msgsact);
    $msgsact = str_replace('&icirc;', "i", $msgsact);
    $msgsact = str_replace('&iuml;', "i", $msgsact);
    $msgsact = str_replace('&Ograve;', "O", $msgsact);
    $msgsact = str_replace('&Oacute;', "O", $msgsact);
    $msgsact = str_replace('&Ocirc;', "O", $msgsact);
    $msgsact = str_replace('&Otilde;', "O", $msgsact);
    $msgsact = str_replace('&Ouml;', "O", $msgsact);
    $msgsact = str_replace('&ograve;', "o", $msgsact);
    $msgsact = str_replace('&oacute;', "o", $msgsact);
    $msgsact = str_replace('&ocirc;', "o", $msgsact);
    $msgsact = str_replace('&otilde;', "o", $msgsact);
    $msgsact = str_replace('&ouml;', "o", $msgsact);
    $msgsact = str_replace('&Ugrave;', "U", $msgsact);
    $msgsact = str_replace('&Uacute;', "U", $msgsact);
    $msgsact = str_replace('&Ucirc;', "U", $msgsact);
    $msgsact = str_replace('&Uuml;', "U", $msgsact);
    $msgsact = str_replace('&ugrave;', "u", $msgsact);
    $msgsact = str_replace('&uacute;', "u", $msgsact);
    $msgsact = str_replace('&ucirc;', "u", $msgsact);
    $msgsact = str_replace('&uuml;', "u", $msgsact);
    $msgsact = str_replace('&ccedil;', "c", $msgsact);
    $msgsact = str_replace('&Ccedil;', "C", $msgsact);
    return $msgsact;
}

function showDir($dir, $selected, $subdir = 0, $showsubs = 0) {
    if (!is_dir($dir)) {
        return false;
    }

    $scan = scandir($dir);

    foreach ($scan as $key => $val) {
        if ($val[0] == ".") {
            continue;
        }

        if (is_dir($dir . "/" . $val)) {
            echo "<option value=\"" . str_repeat("--", $subdir) . $val . "\"";
            if ($val == $selected) {
                echo " selected";
            }
            echo ">" . str_repeat("--", $subdir) . $val . "</option>\n";
            if ($showsubs == 1) {
                if ($val[0] != ".") {
                    showDir($dir . "/" . $val, $subdir + 1);
                }
            }
        }
    }

    return true;
}

function tipoadmin($tipo, $cpf, $SCT, $mensagem = 1) {
    global $CONFIG, $DB, $EVENTO;
    require_once('initialize.php');
    $query = "SELECT admin FROM participantes WHERE cpf='$cpf' AND (eventos LIKE '%$SCT%' OR admin='8')";
    $result = mysql_fetch_array($DB->Query($query));
    if ($result['admin'] < $tipo) {
        if ($mensagem == "1") {
            echo "Acesso Negado";
        }
        return false;
    } else {

        return true;
    }
}

function gerarLetras() {
    $var = "";
    for ($i = 1; $i <= 3; $i++)
        $var .= substr("ABCDEFGHIJKLMNOPQRSTUVWXYZ", rand(0, 25), 1);
    return str_shuffle($var);
}

function retira_acentos($texto) {
    $array1 = array("á", "à", "â", "ã", "ä", "é", "è", "ê", "ë", "í", "ì", "î", "ï", "ó", "ò", "ô", "õ", "ö", "ú", "ù", "û", "ü", "ç"
        , "Á", "À", "Â", "Ã", "Ä", "É", "È", "Ê", "Ë", "Í", "Ì", "Î", "Ï", "Ó", "Ò", "Ô", "Õ", "Ö", "Ú", "Ù", "Û", "Ü", "Ç");
    $array2 = array("a", "a", "a", "a", "a", "e", "e", "e", "e", "i", "i", "i", "i", "o", "o", "o", "o", "o", "u", "u", "u", "u", "c"
        , "A", "A", "A", "A", "A", "E", "E", "E", "E", "I", "I", "I", "I", "O", "O", "O", "O", "O", "U", "U", "U", "U", "C");
    return str_replace($array1, $array2, $texto);
}

function formata_data($date_time_string) {
    $data = date_create($date_time_string);
    return date_format($data, 'd/m/Y H:i');
}
?>
