<?php

class Regime{
    
    const CLT = "CLT";
    const PJ = "PJ";
    const ESTAGIO = "Estágio";

    public static function getAllAsArray() {
        return [Regime::CLT, Regime::PJ, Regime::ESTAGIO];
    }
}