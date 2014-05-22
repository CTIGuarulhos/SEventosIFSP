<?php

$_arraySearch = array('á', 'é', 'í', 'ó', 'ú', 'ã', 'õ', 'â', 'ê', 'ô', 'ç');
$_arrayReplace = array('Á', 'É', 'Í', 'Ó', 'Ú', 'Ã', 'Õ', 'Â', 'Ê', 'Ô', 'Ç');

function deletar_album($albumadeletar) {
    global $_arraySearch, $_arrayReplace, $DB, $CONFIG;
    $query = "DELETE FROM album WHERE id = '$albumadeletar';";
    $result = $DB->Query($query);
}

?>
