<?php

class StatusCandidatura {
    
    const FINALIZADO = "FINALIZADO";
    const EM_ANDAMENTO = "EM_ANDAMENTO";

    public static function getAllAsArray() {
        return [StatusCandidatura::FINALIZADO, StatusCandidatura::EM_ANDAMENTO];
    }
}