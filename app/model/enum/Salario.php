<?php

class Salario{

    const s1000 = "A partir de R$1.000";
    const s2000 = "A partir de R$2.000";
    const s3000 = "A partir de R$3.000";
    const s4000 = "A partir de R$4.000";
    const s5000 = "A partir de R$5.000";
    const s6000 = "A partir de R$6.000";
    const s7000 = "A partir de R$7.000";
    const s8000 = "A partir de R$8.000";
    const s9000 = "A partir de R$9.000";
    const s10000 = "A partir de R$10.000";

    public static function getAllAsArray() {
        return [Salario::s1000, Salario::s2000, Salario::s3000, Salario::s4000,
                Salario::s5000, Salario::s6000, Salario::s7000, Salario::s8000,
                Salario::s9000, Salario::s10000];
    }

    public static function getValorNumerico(string $nome){
    $map = [
        self::s1000 => 1000.0,
        self::s2000 => 2000.0,
        self::s3000 => 3000.0,
        self::s4000 => 4000.0,
        self::s5000 => 5000.0,
        self::s6000 => 6000.0,
        self::s7000 => 7000.0,
        self::s8000 => 8000.0,
        self::s9000 => 9000.0,
        self::s10000 => 10000.0
    ];
    return $map[$nome];
}

}