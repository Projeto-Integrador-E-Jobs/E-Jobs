<?php
    
require_once(__DIR__ . "/../model/Categoria.php");

class CategoriaService {

    public function validarDados(Categoria $categoria) {
        $erros = array();

        //Validar campos vazios
        if(! $categoria->getNome())
            array_push($erros, "O campo [Nome] é obrigatório.");
            if(! $categoria->getIcone())
            array_push($erros, "O campo [Icone] é obrigatório.");
        
        return $erros;
    }

}
