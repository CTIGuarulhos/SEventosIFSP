<?php

// no direct access
isset($CONFIG) or exit('Acesso Restrito');

/* * *************************************************************************** */
/* * ***************** FUNÇÃO PARA "FILTRAR" STRINGS SQL *********************** */
/* * *************************************************************************** */

function safe_sql($var, $drop_chars = false) {
    if (get_magic_quotes_gpc()) {
        if (is_array($drop_chars)) {
            return safe_sql_dropchar($var, $drop_chars);
        } else {
            return $var;
        }
    }

    /*
      get_magic_quotes_gpc() - indica se o PHP está configurado automaticamente para
      'filtrar' strings (GET/POST/COOKIE), afim de evitar SQL injection.
      (0) OFF / (1) ON
     */

    if (is_array($var)) {
        foreach ($var as $key => $value) {
            $var[$key] = addslashes($value);
            if (is_array($drop_chars)) {
                $var[$key] = safe_sql_dropchar($var[$key], $drop_chars);
            }
        }
        return $var;
    } else {
        if (is_array($drop_chars)) {
            $var = safe_sql_dropchar($var, $drop_chars);
        }
        return addslashes($var);
    }
}

//fim function safe_sql()
# Elimina os caracteres do array $char_array da string

function safe_sql_dropchar($var, $char_array) {
    if (is_array($var)) {
        foreach ($var as $key => $value) {
            foreach ($char_array as $char) {
                $var[$key] = str_replace($char, "", $value);
            }
        }
    } else {
        foreach ($char_array as $char) {
            $var = str_replace($char, "", $var);
        }
    }

    return $var;
}

//fim function safe_sql_dropchar()
?>
