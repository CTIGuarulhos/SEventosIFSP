<?php

//Caso você queira executar vários sites com o mesmo sistema 
//gerenciando eventos diferentes copie toda a class Config{} dentro
//de um if deste genero
//if ($_SERVER[HTTP_HOST] == "sitedoevento.com") {
// }
//Você pode fazer isso com quantos sites quiser tendo uma unica pasta para gerenciar.

class Config {
#-------------------------------------------------------------------#
# Banco de dados MySQL                                              #
#-------------------------------------------------------------------#

    var $DB_HOST = "localhost";
    var $DB_USER = "usuario";
    var $DB_PSWD = "senha";
    var $DB_NAME = "banco";
    var $DB_PORT = 3306;

#-------------------------------------------------------------------#
# Envio de e-mail / Servidor SMTP                                   #
#-------------------------------------------------------------------#
//Configuração de Rementente
    var $MAIL_FROM = "email@gmail.com";
    var $CONTATO_EMAIL = array("email1@email.com", "email2@email.com");
//Se TRUE, utiliza a função mail() do PHP
    var $USE_SENDMAIL = false;
//Configuração abaixo desnecessária se o parâmetro
// $USE_SENDMAIL for setada como TRUE (verdadeiro)
    var $MAIL_AUTH = true;
    var $MAIL_SMTP = "smtp.gmail.com";
    var $MAIL_USER = "email@gmail.com";
    var $MAIL_PSWD = "senha";

#-------------------------------------------------------------------#
# Cabeçalho HTML                                                    #
#-------------------------------------------------------------------#
    var $CHARSET = "UTF-8";

#-------------------------------------------------------------------#
# Sistema                                                           #
#-------------------------------------------------------------------#
//ID da semana de ciência e tecnologia atual (vide banco de dados)
    var $SCT_ID = "2013";

#-------------------------------------------------------------------#
# Servidor - URL / DiretÃ³rios / TEMPLATE                           #
#-------------------------------------------------------------------#
    var $URL_ROOT = "http://sitedoevento.com";
    var $DIR_ROOT = "/var/www/evento";

}

?>