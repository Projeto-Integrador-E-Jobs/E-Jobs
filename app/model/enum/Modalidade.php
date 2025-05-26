<?php

class Modalidade{
    
    const HOME_OFFICE = "Home Office";
    const PRESENCIAL = "Presencial";
    const HIBRIDO = "Híbrido";
    

    public static function getAllAsArray() {
        return [Modalidade::HOME_OFFICE, Modalidade::PRESENCIAL, Modalidade::HIBRIDO];
    }
}