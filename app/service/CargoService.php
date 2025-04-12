<?php
    
require_once(__DIR__ . "/../model/Cargo.php");

class CargoService {

    public function validarDados(Cargo $cargo) {
        $erros = array();

        //Validar campos vazios
        if(! $cargo->getNome())
            array_push($erros, "O campo [Nome] é obrigatório.");
        
        return $erros;
    }

}
