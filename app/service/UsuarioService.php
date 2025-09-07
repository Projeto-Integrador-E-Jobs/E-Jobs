<?php
    
require_once(__DIR__ . "/../model/Usuario.php");
require_once(__DIR__ . "/../dao/UsuarioDAO.php");

class UsuarioService {

    private UsuarioDAO $usuarioDAO;

    public function __construct() {
        $this->usuarioDAO = new UsuarioDAO();
    }

    /* Método para validar os dados do usuário que vem do formulário */
    public function validarDados(Usuario $usuario, ?string $confSenha) {
        $erros = array();
    
        // Validar campos obrigatórios
        if (! $usuario->getTipoUsuario()) 
            array_push($erros, "O campo [Papel] é obrigatório.");
        
        if (! $usuario->getNome())
            array_push($erros, "O campo [Nome] é obrigatório.");
    
        if (! $usuario->getEmail())
            array_push($erros, "O campo [Email] é obrigatório.");
    
        if (! $usuario->getSenha())
            array_push($erros, "O campo [Senha] é obrigatório.");
    
        if (! $confSenha)
            array_push($erros, "O campo [Confirmação da senha] é obrigatório.");
    
        
        if (! $usuario->getDocumento())
            array_push($erros, "O campo [Documento] é obrigatório.");
    
        if (! $usuario->getDescricao())
            array_push($erros, "O campo [Descrição] é obrigatório.");

        if (! $usuario->getCidade()->getCodigoIbge())
            array_push($erros, "O campo [Cidade] é obrigatório.");
    
        if (! $usuario->getEndLogradouro())
            array_push($erros, "O campo [Logradouro] é obrigatório.");
    
        if (! $usuario->getEndBairro())
            array_push($erros, "O campo [Bairro] é obrigatório.");
    
        if (! $usuario->getEndNumero())
            array_push($erros, "O campo [Número] é obrigatório.");
    
        if (! $usuario->getTelefone())
            array_push($erros, "O campo [Telefone] é obrigatório.");
    
        // Validar se a senha é igual à confirmação
        if ($usuario->getSenha() && $confSenha && $usuario->getSenha() != $confSenha)
            array_push($erros, "O campo [Senha] deve ser igual ao [Confirmação da senha].");
    
        return $erros;
    }

    public function validarDocumento(string $documento){
        $erros = array();
        $usuario = $this->usuarioDAO->findByDocumento($documento);
        if($usuario != null)
            array_push($erros, "Já existe um usuário utilizando esse documento");
          
        return $erros;
    }

    public function validarEmail(string $email) {
        $erros = array();
        $usuario = $this->usuarioDAO->findByEmail($email);
        if($usuario != null)
            array_push($erros, "Já existe um usuário utilizando esse email");
          
        return $erros; 
    }

    public function validarCPF(string $cpf): bool {
        // Remove caracteres não numéricos
        $cpf = preg_replace('/[^0-9]/', '', $cpf);
    
        // Verifica se tem 11 dígitos ou se é uma sequência repetida (ex: 11111111111)
        if (strlen($cpf) != 11 || preg_match('/^(\d)\1{10}$/', $cpf)) {
            return false;
        }
    
        // Calcula e verifica o primeiro dígito verificador
        for ($t = 9; $t < 11; $t++) {
            $soma = 0;
            for ($i = 0; $i < $t; $i++) {
                $soma += $cpf[$i] * (($t + 1) - $i);
            }
    
            $digito = (10 * $soma) % 11;
            $digito = $digito == 10 ? 0 : $digito;
    
            if ($cpf[$t] != $digito) {
                return false;
            }
        }
    
        return true;
    }
    
    
}
