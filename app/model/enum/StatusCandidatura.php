<?php

class StatusCandidatura {

    const PENDENTE = "PENDENTE";
    const APROVADO = "APROVADO";
    const RECUSADO = "RECUSADO";
    const EM_ANDAMENTO = "EM_ANDAMENTO";
    const FINALIZADO = "FINALIZADO";

    public static function getAllAsArray() {
        return [
            StatusCandidatura::PENDENTE,
            StatusCandidatura::APROVADO,
            StatusCandidatura::RECUSADO,
            StatusCandidatura::EM_ANDAMENTO,
            StatusCandidatura::FINALIZADO
        ];
    }
}
