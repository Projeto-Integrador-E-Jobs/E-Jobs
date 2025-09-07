<?php

class Horario{

    const H20 = "20h";
    const H30 = "30h";
    const H40 = "40h";
    const H44 = "44h";
    const OUTROS = "Outros";

    public static function getAllAsArray() {
        return [Horario::H20, Horario::H30, Horario::H40,
                Horario::H44, Horario::OUTROS];
    }
}