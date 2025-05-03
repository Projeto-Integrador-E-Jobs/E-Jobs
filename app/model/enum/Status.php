<?php

class Status{
    
    public static string $SEPARADOR = "|";

    const ATIVO = "Ativo";
    const INATIVO = "Inativo";

    public static function getAllAsArray() {
        return [Status::ATIVO, Status::INATIVO];
    }
}