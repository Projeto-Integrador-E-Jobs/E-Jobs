<?php

class Vaga {
    private ?int $id;
    private ?string $titulo;
    private ?string $modalidade;
    private ?string $horario;
    private ?string $regime;
    private ?float $salario;
    private ?string $descricao;
    private ?string $requisitos;
    private ?Usuario $empresa;
    private ?Cargo $cargo;   
    
    

    /**
     * Get the value of id
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of titulo
     */
    public function getTitulo(): string
    {
        return $this->titulo;
    }

    /**
     * Set the value of titulo
     */
    public function setTitulo(string $titulo): self
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * Get the value of modalidade
     */
    public function getModalidade(): string
    {
        return $this->modalidade;
    }

    /**
     * Set the value of modalidade
     */
    public function setModalidade(string $modalidade): self
    {
        $this->modalidade = $modalidade;

        return $this;
    }

    /**
     * Get the value of horario
     */
    public function getHorario(): string
    {
        return $this->horario;
    }

    /**
     * Set the value of horario
     */
    public function setHorario(string $horario): self
    {
        $this->horario = $horario;

        return $this;
    }

    /**
     * Get the value of regime
     */
    public function getRegime(): string
    {
        return $this->regime;
    }

    /**
     * Set the value of regime
     */
    public function setRegime(string $regime): self
    {
        $this->regime = $regime;

        return $this;
    }

    /**
     * Get the value of salrio
     */
    public function getSalario(): float
    {
        return $this->salario;
    }

    /**
     * Set the value of salrio
     */
    public function setSalario(float $salrio): self
    {
        $this->salario = $salrio;

        return $this;
    }

    /**
     * Get the value of descricao
     */
    public function getDescricao(): string
    {
        return $this->descricao;
    }

    /**
     * Set the value of descricao
     */
    public function setDescricao(string $descricao): self
    {
        $this->descricao = $descricao;

        return $this;
    }

    /**
     * Get the value of requisitos
     */
    public function getRequisitos(): string
    {
        return $this->requisitos;
    }

    /**
     * Set the value of requisitos
     */
    public function setRequisitos(string $requisitos): self
    {
        $this->requisitos = $requisitos;

        return $this;
    }

    /**
     * Get the value of empresa
     */
    public function getEmpresa(): ?Usuario
    {
        return $this->empresa;
    }

    /**
     * Set the value of empresa
     */
    public function setEmpresa(?Usuario $empresa): self
    {
        $this->empresa = $empresa;

        return $this;
    }

    /**
     * Get the value of gargo
     */
    public function getCargo(): ?Cargo
    {
        return $this->cargo;
    }

    /**
     * Set the value of gargo
     */
    public function setCargo(?Cargo $cargo): self
    {
        $this->cargo = $cargo;

        return $this;
    }
}