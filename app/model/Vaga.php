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
    private ?string $status;
    private ?Usuario $empresa;
    private ?Cargo $cargo;
    private ?Categoria $categoria;   
    
    public function getId(): ?int {
        return $this->id;
    }

    public function setId(?int $id): void {
        $this->id = $id;
    }

    public function getTitulo(): ?string {
        return $this->titulo;
    }

    public function setTitulo(?string $titulo): void {
        $this->titulo = $titulo;
    }

    public function getModalidade(): ?string {
        return $this->modalidade;
    }

    public function setModalidade(?string $modalidade): void {
        $this->modalidade = $modalidade;
    }

    public function getHorario(): ?string {
        return $this->horario;
    }

    public function setHorario(?string $horario): void {
        $this->horario = $horario;
    }

    public function getRegime(): ?string {
        return $this->regime;
    }

    public function setRegime(?string $regime): void {
        $this->regime = $regime;
    }

    public function getSalario(): ?float {
        return $this->salario;
    }

    public function setSalario(?float $salario): void {
        $this->salario = $salario;
    }

    public function getDescricao(): ?string {
        return $this->descricao;
    }

    public function setDescricao(?string $descricao): void {
        $this->descricao = $descricao;
    }

    public function getRequisitos(): ?string {
        return $this->requisitos;
    }

    public function setRequisitos(?string $requisitos): void {
        $this->requisitos = $requisitos;
    }
  
    public function getStatus(): ?string
    {
        return $this->status;
    }
    
    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getEmpresa(): ?Usuario {
        return $this->empresa;
    }

    public function setEmpresa(?Usuario $empresa): void {
        $this->empresa = $empresa;
    }

    public function getCargo(): ?Cargo {
        return $this->cargo;
    }

    public function setCargo(?Cargo $cargo): void {
        $this->cargo = $cargo;
    }
    
    public function getCategoria(): ?Categoria
    {
        return $this->categoria;
    }

    public function setCategoria(?Categoria $categoria): self
    {
        $this->categoria = $categoria;

        return $this;
    }
}