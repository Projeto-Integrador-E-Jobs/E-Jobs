<?php
#Nome do arquivo: LoginService.php
#Objetivo: classe service para Login

require_once(__DIR__ . "/../model/Usuario.php");

class LoginService {

    public function validarCampos(?string $email, ?string $senha) {
        $arrayMsg = array();

        //Valida o campo nome
        if(! $email)
            array_push($arrayMsg, "O campo [Login] é obrigatório.");

        //Valida o campo login
        if(! $senha)
            array_push($arrayMsg, "O campo [Senha] é obrigatório.");

        return $arrayMsg;
    }

    public function salvarUsuarioSessao(Usuario $usuario) {
        //Habilitar o recurso de sessão no PHP nesta página
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        //Setar usuário na sessão do PHP
        $_SESSION[SESSAO_USUARIO_ID]   = $usuario->getId();
        $_SESSION[SESSAO_USUARIO_NOME] = $usuario->getNome();
        $_SESSION[SESSAO_USUARIO_PAPEL] = $usuario->getTipoUsuario()->getId();
        $_SESSION['usuario'] = $usuario;
    }

    public function removerUsuarioSessao() {
        //Habilitar o recurso de sessão no PHP nesta página
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        //Remover variáveis
        session_unset();

        //Destroi a sessão 
        session_destroy();
    }

}