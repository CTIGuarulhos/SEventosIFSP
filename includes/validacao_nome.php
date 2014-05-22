<?php

// no direct access
isset($CONFIG) or exit('Acesso Restrito');

function nome_invalido($nome) {
    /**
     * @$nome = string a ser verificada
     * @return = retorna true se $nome for INv�lido
     */
    //Caracteres inv�lidos
    $char_invalidos = array('!', '@', '#', '$', '%', '�', '&', '*', '(', ')', '/', '"', '�', '`', '[', ']', '{', '}', '^', '~', '�', '�', ',', '.', '<', '>', ';', ':', '?', '�', '-', '=', '+', '�');

    return str_search($nome, $char_invalidos);
}

function str_search($string, $char_array) {
    /**
     * @$string = string a ser verificada
     * @$char_array = array de caracteres a ser procurado em $string
     * @return = retorna true se alguma ocorr�ncia for encontrada em $string
     */
    foreach ($char_array as $char) {
        if (strstr($string, $char) !== false)
            return true;
    }

    return false;
}

?>
