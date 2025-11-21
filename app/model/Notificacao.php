<?php

class Notificacao
{
    private ?int $id;
    private ?Usuario $usuarioOrigem;
    private ?Usuario $usuarioDestino;
    private ?string $tipo;
    private ?string $mensagem;
    private ?Vaga $vaga;
    private ?int $lida;
    private $dataCriacao;

     public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getOrigem(): ? Usuario
    {
        return $this->usuarioOrigem;
    }

    public function setOrigem(?Usuario $usuarioOrigem): self
    {
        $this->usuarioOrigem = $usuarioOrigem;

        return $this;
    }

    public function getDestino(): ?Usuario
    {
        return $this->usuarioDestino;
    }

    public function setDestino(?Usuario $usuarioDestino): self
    {
        $this->$usuarioDestino = $usuarioDestino;

        return $this;
    }

    public function getTipo(): ?string
    {
        return $this->tipo;
    }

    public function setTipo(?string $tipo) : self
    {
        $this->tipo = $tipo;

        return $this;
    }

    public function getMensagem(): ?string
    {
        return $this->mensagem;
    }

    public function setMensagem(?string $mensagem) : self
    {
        $this->mensagem = $mensagem;

        return $this;
    }


    public function getVaga(): ?Vaga
    {
        return $this->vaga;
    }

    public function setVaga(?Vaga $vaga) : self 
    {
        $this->vaga = $vaga;
        
        return $this;
    }

    public function getLida() : ?int 
    {
        return $this->lida;   
    }

    public function setLida(?int $lida) : self 
    {
        $this->lida = $lida;
        
        return $this;
    }

    public function getDataCriacao() 
    {
        return $this->dataCriacao;
    }

    public function setDataCriacao($dataCriacao)  
    {
        $this->dataCriacao = $dataCriacao;
        
        return $this;
    }
}
