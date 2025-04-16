<?php

class Regime{
    
    public static string $SEPARADOR = "|";

    const CLT = "CLT";
    const PJ = "PJ";
    const ESTAGIO = "Estágio";

    public static function getAllAsArray() {
        return [Regime::CLT, Regime::PJ, Regime::ESTAGIO];
    }
}