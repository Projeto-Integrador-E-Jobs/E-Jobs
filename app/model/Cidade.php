<?php

class Cidade implements JsonSerializable {

    private ?int $codigoIbge;
    private ?string $nome;
    private ?float $latitude;
    private ?float $longitude;
    private ?bool $capital;
    private ?int $ddd;
    private ?string $fusoHorario;
    private ?string $siafiId;
    private ?Estado $estado; // relação com Estado

    public function jsonSerialize(): array
    {
        return array(
            "id" => $this->codigoIbge,
            "nome" => $this->nome,
            "uf" => $this->estado ? $this->estado->getUf() : null
        );
    }

    /**
     * Get the value of codigoIbge
     */
    public function getCodigoIbge(): ?int
    {
        return $this->codigoIbge;
    }

    /**
     * Set the value of codigoIbge
     */
    public function setCodigoIbge(?int $codigoIbge): self
    {
        $this->codigoIbge = $codigoIbge;

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
     * Get the value of latitude
     */
    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    /**
     * Set the value of latitude
     */
    public function setLatitude(?float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get the value of longitude
     */
    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    /**
     * Set the value of longitude
     */
    public function setLongitude(?float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get the value of capital
     */
    public function isCapital(): ?bool
    {
        return $this->capital;
    }

    /**
     * Set the value of capital
     */
    public function setCapital(?bool $capital): self
    {
        $this->capital = $capital;

        return $this;
    }

    /**
     * Get the value of ddd
     */
    public function getDdd(): ?int
    {
        return $this->ddd;
    }

    /**
     * Set the value of ddd
     */
    public function setDdd(?int $ddd): self
    {
        $this->ddd = $ddd;

        return $this;
    }

    /**
     * Get the value of fusoHorario
     */
    public function getFusoHorario(): ?string
    {
        return $this->fusoHorario;
    }

    /**
     * Set the value of fusoHorario
     */
    public function setFusoHorario(?string $fusoHorario): self
    {
        $this->fusoHorario = $fusoHorario;

        return $this;
    }

    /**
     * Get the value of siafiId
     */
    public function getSiafiId(): ?string
    {
        return $this->siafiId;
    }

    /**
     * Set the value of siafiId
     */
    public function setSiafiId(?string $siafiId): self
    {
        $this->siafiId = $siafiId;

        return $this;
    }

    /**
     * Get the Estado object
     */
    public function getEstado(): ?Estado
    {
        return $this->estado;
    }

    /**
     * Set the Estado object
     */
    public function setEstado(?Estado $estado): self
    {
        $this->estado = $estado;

        return $this;
    }
}
