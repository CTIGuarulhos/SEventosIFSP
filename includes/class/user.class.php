<?php

#-------------------------------------------------------------------#
#              CLASSE PARA GERENCIAMENTO DE USUÁRIO                 #
#-------------------------------------------------------------------#

class User {

    private $cpf, $nome;
    private $email, $permissao;

    /**
     * Metodo construtor
     * Devera ser instanciado apenas pela pagina de login
     * @param array $arrayUser - array com os dados do usuario
     */
    public function __construct($arrayUser) {
        if (!is_array($arrayUser))
            return false;

        $this->cpf = $arrayUser['cpf'];
        $this->nome = $arrayUser['nome'];
        $this->email = $arrayUser['email'];
        $this->permissao = $arrayUser['permissao'];
    }

    #---------------------------------------------------------------#
    #                      METODOS SET/GET                          #
    #---------------------------------------------------------------#

    public function getCpf() {
        return $this->cpf;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPermissao() {
        return $this->permissao;
    }

}

?>