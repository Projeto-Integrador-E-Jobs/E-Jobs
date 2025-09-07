<?php 

class Categoria { 
    private ?int $id; 
    private ?string $nome;
    private ?string $icone;
    private ?int $total_vagas;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(?string $nome): self
    {
        $this->nome = $nome;

        return $this;
    }

    public function getIcone(): ?string
    {
        return $this->icone;
    }

    public function setIcone(?string $icone): self
    {
        $this->icone = $icone;

        return $this;
    }

    public function getTotalVagas(): ?int
    {
        return $this->total_vagas;
    }

    public function setTotalVagas(?int $total_vagas): self
    {
        $this->total_vagas = $total_vagas;

        return $this;
    }
}