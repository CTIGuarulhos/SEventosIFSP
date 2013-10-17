<?php

#------------------------------------#
# CLASSE INUTILIZADA / NAO TERMINADA #
#------------------------------------#
exit;

// no direct access
defined('URL_ROOT') or exit('Acesso Restrito');

class Config {

    private $file;
    private $error;

    const READ_MODE = 'r';
    const WRITE_MODE = 'w';
    const EXTENSION_REQUIRED = true;
    const EXTENSION = '.cfg.php';
    const IGNORE_LIST = "<?,/*,#,\r\n,\n,*/,?>";

    function __construct($_file) {

        # Verifica se o arquivo de confguração existe
        if (@file_exists($_file)) {
            if (!is_readable($_file)) {
                $this->error = "O arquivo de configuração '{$_file}' não pode ser lido.";
                return false;
            }
            $this->file = $_file;
            $this->openFile();
        } else {
            $this->error = "O arquivo de configuração '{$_file}' não existe.";
            return false;
        }

        # Verifica se o arquivo possui extensão requrida
        if (self::EXTENSION_REQUIRED) {
            if (self::EXTENSION != substr($_file, strlen(self::EXTENSION) * -1)) {
                $this->error = "Extensão do arquivo de configuração inválida.";
                return false;
            }
        }
    }

    private function openFile() {

        $file = file($this->file);
        //array_replace(array1, array2);

        $ignore_list = explode(',', self::IGNORE_LIST);

        echo "<pre>";
        print_r($file);
        echo "</pre>";

        foreach ($file as $key => $text) {
            $text = trim($text);
            foreach ($ignore_list as $ignore) {
                if (strpos($text, $ignore) === 0 || strlen($text) <= 0) {
                    unset($file[$key]);
                    break;
                }
            }
        }

        echo "<pre>";
        print_r($file);
        echo "</pre>";
    }

    public function getError() {
        return $this->error;
    }

}

?>