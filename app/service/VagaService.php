<?php

require_once(__DIR__ . "/../model/Vaga.php");

class VagaService{
        
        public function validarDados(Vaga $vaga) {
            $erros = array();
        
            // Validar campos obrigatórios
            if (! $vaga->getTitulo())
                array_push($erros, "O campo [Título] é obrigatório.");
        
            if (! $vaga->getModalidade())
                array_push($erros, "O campo [Modalidade] é obrigatório.");
        
            if (! $vaga->getHorario())
                array_push($erros, "O campo [Horário] é obrigatório.");
        
            if (! $vaga->getRegime()) 
                array_push($erros, "O campo [Regime] é obrigatório.");
        
            if (! $vaga->getSalario())
                array_push($erros, "O campo [Salário] é obrigatório.");
        
            if (! $vaga->getDescricao())
                array_push($erros, "O campo [Descrição] é obrigatório.");
        
            if (! $vaga->getRequisitos())
                array_push($erros, "O campo [Requisitos] é obrigatório.");
        
            if (! $vaga->getCargo())
                array_push($erros, "O campo [Cargo] é obrigatório.");

            if (! $vaga->getCategoria())
                array_push($erros, "O campo [Categoria] é obrigatório.");
        
            if (! $vaga->getEmpresa())
                array_push($erros, "O campo [Empresa] é obrigatório.");
        
        
            return $erros;
        }
        
}