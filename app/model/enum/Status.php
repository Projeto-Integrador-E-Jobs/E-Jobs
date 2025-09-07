<?php

class Status{
    
    const ATIVO = "Ativo";
    const INATIVO = "Inativo";
    const PENDENTE = "Pendente";

    public static function getAllAsArray() {
        return [Status::ATIVO, Status::INATIVO];
    }
}