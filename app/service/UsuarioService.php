<?php
    
require_once(__DIR__ . "/../model/Usuario.php");

class UsuarioService {

    /* Método para validar os dados do usuário que vem do formulário */
    public function validarDados(Usuario $usuario, ?string $confSenha) {
        $erros = array();
    
        // Validar campos obrigatórios
        if (! $usuario->getNome())
            array_push($erros, "O campo [Nome] é obrigatório.");
    
        if (! $usuario->getEmail())
            array_push($erros, "O campo [Email] é obrigatório.");
    
        if (! $usuario->getSenha())
            array_push($erros, "O campo [Senha] é obrigatório.");
    
        if (! $confSenha)
            array_push($erros, "O campo [Confirmação da senha] é obrigatório.");
    
        if (! $usuario->getTipoUsuario()) 
            array_push($erros, "O campo [Papel] é obrigatório.");
    
        if (! $usuario->getDocumento())
            array_push($erros, "O campo [Documento] é obrigatório.");
    
        if (! $usuario->getDescricao())
            array_push($erros, "O campo [Descrição] é obrigatório.");
    
        if (! $usuario->getEstado())
            array_push($erros, "O campo [Estado] é obrigatório.");
    
        if (! $usuario->getCidade())
            array_push($erros, "O campo [Cidade] é obrigatório.");
    
        if (! $usuario->getEndLogradouro())
            array_push($erros, "O campo [Logradouro] é obrigatório.");
    
        if (! $usuario->getEndBairro())
            array_push($erros, "O campo [Bairro] é obrigatório.");
    
        if (! $usuario->getEndNumero())
            array_push($erros, "O campo [Número] é obrigatório.");
    
        if (! $usuario->getTelefone())
            array_push($erros, "O campo [Telefone] é obrigatório.");
    
        if (! $usuario->getStatus())
            array_push($erros, "O campo [Status] é obrigatório.");
    
        // Validar se a senha é igual à confirmação
        if ($usuario->getSenha() && $confSenha && $usuario->getSenha() != $confSenha)
            array_push($erros, "O campo [Senha] deve ser igual ao [Confirmação da senha].");
    
        return $erros;
    }
    

}
