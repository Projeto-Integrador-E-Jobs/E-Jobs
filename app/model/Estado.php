<?php

class Estado {

    private ?int $codigoUf;
    private ?string $uf;
    private ?string $nome;
    private ?float $latitude;
    private ?float $longitude;
    private ?string $regiao;

    /**
     * Get the value of codigoUf
     */
    public function getCodigoUf(): ?int
    {
        return $this->codigoUf;
    }

    /**
     * Set the value of codigoUf
     */
    public function setCodigoUf(?int $codigoUf): self
    {
        $this->codigoUf = $codigoUf;

        return $this;
    }

    /**
     * Get the value of uf
     */
    public function getUf(): ?string
    {
        return $this->uf;
    }

    /**
     * Set the value of uf
     */
    public function setUf(?string $uf): self
    {
        $this->uf = $uf;

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
     * Get the value of regiao
     */
    public function getRegiao(): ?string
    {
        return $this->regiao;
    }

    /**
     * Set the value of regiao
     */
    public function setRegiao(?string $regiao): self
    {
        $this->regiao = $regiao;

        return $this;
    }
}
