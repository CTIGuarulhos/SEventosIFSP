<?php

#-------------------------------------------------------------------#
#               CLASSE PARA GERENCIAMENTO DE SESSÃO                 #
#-------------------------------------------------------------------#

class Session {

    //Tempo de vida padrao (em minutos)

    const DEFAULT_LIFETIME = 30;

    private $sessionID, $sessionName, $sessionLifeTime = -1;
    private $logged = false, $expired = false;
    public $loginPage;

    /**
     * Metodo construtor
     * @param class $ConfigClass - classe de configuracao
     */
    public function __construct($ConfigClass = false) {
        if ($ConfigClass) {
            $this->loginPage = $ConfigClass->URL_ROOT;
            $SESSIONTIME = 30;
            $this->sessionLifeTime = $SESSIONTIME * 60;
            session_name("EVENTO" . $ConfigClass->SCT_ID);
            session_cache_expire($SESSIONTIME);
            session_set_cookie_params($SESSIONTIME * 60, "/");
        } else {
            $this->loginPage = basename(__FILE__);
            $this->sessionLifeTime = self::DEFAULT_LIFETIME * 60;
        }

        session_start();
        $this->sessionID = session_id();
        $this->sessionName = session_name();

        //Sera executao no momento de criacao da sessao
        if (!isset($_SESSION['lifetime'])) {
            $_SESSION['lifetime'] = time() + $this->sessionLifeTime;
        }

        //Verifica o tempo de vida da sessao
        if ($_SESSION['lifetime'] < time()) {
            $this->Destroy();
        } else {
            $_SESSION['lifetime'] = time() + $this->sessionLifeTime;
            setcookie($this->sessionName, $this->sessionID, time() + $this->sessionLifeTime, "/");
        }

        //Verifica se o usuario ja foi autenticado
        if (isset($_SESSION['USER']) && is_object($_SESSION['USER'])) {
            $this->logged = true;
        }
    }

    #---------------------------------------------------------------#
    #                      METODOS PUBLICO                          #
    #---------------------------------------------------------------#

    /**
     * Verifica autenticacao do usuario
     * @return bool
     */
    public function VerifyAuth($redir_to_login_page = true) {
        if ($this->logged && !$this->expired) {
            return true;
        } else {
            if ($redir_to_login_page) {
                header("Location: {$this->loginPage}");
                exit;
            }
            return false;
        }
    }

    /**
     * Faz logoff, fecha a sessao
     * @return void
     */
    public function Destroy() {
        $this->expired = true;
        $this->loged = false;
        session_unset();
        session_destroy();
    }

    /**
     * Verifica se o usuario esta autenticado
     * @return bool
     */
    public function IsLoggedIn() {
        return $this->logged;
    }

}

?>