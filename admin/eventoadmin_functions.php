<?php

$_arraySearch = array('á', 'é', 'í', 'ó', 'ú', 'ã', 'õ', 'â', 'ê', 'ô', 'ç');
$_arrayReplace = array('Á', 'É', 'Í', 'Ó', 'Ú', 'Ã', 'Õ', 'Â', 'Ê', 'Ô', 'Ç');

function deletar_evento($eventoadeletar) {
    global $_arraySearch, $_arrayReplace, $DB, $CONFIG;
    $query = "DELETE FROM eventos WHERE id = '$eventoadeletar';";
    $result = $DB->Query($query);
}

function deletar_palestrante($palestranteadeletar) {
    global $_arraySearch, $_arrayReplace, $DB, $CONFIG;
    $query = "DELETE FROM part_palestrante WHERE codigo = '$palestranteadeletar';";
    $result = $DB->Query($query);
}

?>
