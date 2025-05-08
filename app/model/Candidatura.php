<?php
require_once(__DIR__ . "/Usuario.php");
require_once(__DIR__ . "/Vaga.php");

class Candidatura {
    private ?int $id;
    private ?Usuario $candidato;
    private ?Vaga $vaga;
    private $dataCandidatura;
    private ?string $status;

    public function __construct() {
        $this->id = null;
        $this->candidato = null;
        $this->vaga = null;
        $this->dataCandidatura = null;
        $this->status = "PENDENTE";
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function setId(?int $id): self {
        $this->id = $id;
        return $this;
    }

    public function getCandidato(): ?Usuario {
        return $this->candidato;
    }

    public function setCandidato(?Usuario $candidato): self {
        $this->candidato = $candidato;
        return $this;
    }

    public function getVaga(): ?Vaga {
        return $this->vaga;
    }

    public function setVaga(?Vaga $vaga): self {
        $this->vaga = $vaga;
        return $this;
    }

    public function getDataCandidatura() {
        return $this->dataCandidatura;
    }

    public function setDataCandidatura($dataCandidatura): self {
        $this->dataCandidatura = $dataCandidatura;
        return $this;
    }

    public function getStatus(): ?string {
        return $this->status;
    }

    public function setStatus(?string $status): self {
        $this->status = $status;
        return $this;
    }
} 