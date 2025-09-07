<?php 
#Nome do arquivo: Usuario.php
#Objetivo: classe Model para Usuario

//require_once(__DIR__ . "");

class Usuario {

    private ?int $id;
    private ?string $nome;
    private ?string $email;
    private ?string $senha;
    private ?string $documento;
    private ?string $descricao;
    private ?Cidade $cidade;
    private ?string $endLogradouro;
    private ?string $endBairro;
    private ?string $endNumero;
    private ?string $telefone;
    private ?string $status;
    private ?TipoUsuario $tipoUsuario;
    
    public function getEnderecoCompleto() {
        return $this->endLogradouro . ", " . $this->endBairro . ", " . $this->endNumero;
    }

    /**
     * Get the value of id
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     */
    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of nome
     */
    public function getNome(): ?string
    {
        return $this->nome;
    }

    /**
     * Set the value of nome
     */
    public function setNome(?string $nome): self
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Get the value of email
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Set the value of email
     */
    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of senha
     */
    public function getSenha(): ?string
    {
        return $this->senha;
    }

    /**
     * Set the value of senha
     */
    public function setSenha(?string $senha): self
    {
        $this->senha = $senha;

        return $this;
    }

    /**
     * Get the value of documento
     */
    public function getDocumento(): ?string
    {
        return $this->documento;
    }

    /**
     * Set the value of documento
     */
    public function setDocumento(?string $documento): self
    {
        $this->documento = $documento;

        return $this;
    }

    /**
     * Get the value of descricao
     */
    public function getDescricao(): ?string
    {
        return $this->descricao;
    }

    /**
     * Set the value of descricao
     */
    public function setDescricao(?string $descricao): self
    {
        $this->descricao = $descricao;

        return $this;
    }


    /**
     * Get the value of cidade
     */
    public function getCidade(): ?Cidade
    {
        return $this->cidade;
    }

    /**
     * Set the value of cidade
     */
    public function setCidade(?Cidade $cidade): self
    {
        $this->cidade = $cidade;

        return $this;
    }

    /**
     * Get the value of endLogradouro
     */
    public function getEndLogradouro(): ?string
    {
        return $this->endLogradouro;
    }

    /**
     * Set the value of endLogradouro
     */
    public function setEndLogradouro(?string $endLogradouro): self
    {
        $this->endLogradouro = $endLogradouro;

        return $this;
    }

    /**
     * Get the value of endBairro
     */
    public function getEndBairro(): ?string
    {
        return $this->endBairro;
    }

    /**
     * Set the value of endBairro
     */
    public function setEndBairro(?string $endBairro): self
    {
        $this->endBairro = $endBairro;

        return $this;
    }

    /**
     * Get the value of endNumero
     */
    public function getEndNumero(): ?string
    {
        return $this->endNumero;
    }

    /**
     * Set the value of endNumero
     */
    public function setEndNumero(?string $endNumero): self
    {
        $this->endNumero = $endNumero;

        return $this;
    }

    
    /**
     * Get the value of telefone
     */
    public function getTelefone(): ?string
    {
        return $this->telefone;
    }

    /**
     * Set the value of telefone
     */
    public function setTelefone(?string $telefone): self
    {
        $this->telefone = $telefone;

        return $this;
    }

    /**
     * Get the value of status
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * Set the value of status
     */
    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get the value of tipoUsuario
     */
    public function getTipoUsuario(): ?TipoUsuario
    {
        return $this->tipoUsuario;
    }

    /**
     * Set the value of tipoUsuario
     */
    public function setTipoUsuario(?TipoUsuario $tipoUsuario): self
    {
        $this->tipoUsuario = $tipoUsuario;

        return $this;
    }
}