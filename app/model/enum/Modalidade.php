<?php

class Modalidade{
    
    public static string $SEPARADOR = "|";

    const HOME_OFFICE = "HOME OFFICE";
    const PRESENCIAL = "PRESENCIAL";
    const HIBRIDO = "HIBRIDO";
    

    public static function getAllAsArray() {
        return [Modalidade::HOME_OFFICE, Modalidade::PRESENCIAL, Modalidade::HIBRIDO];
    }
}