<?php

class Status{
    
    public static string $SEPARADOR = "|";

    const ATIVO = "Ativo";
    const INATIVO = "Inativo";
    const PENDENTE = "Pendente";

    public static function getAllAsArray() {
        return [Status::ATIVO, Status::INATIVO, Status::PENDENTE];
    }
}