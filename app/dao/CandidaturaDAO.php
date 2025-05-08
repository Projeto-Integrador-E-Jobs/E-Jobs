<?php

include_once(__DIR__ . "/../connection/Connection.php");
include_once(__DIR__ . "/../model/Candidatura.php");

class CandidaturaDAO {
    
    public function findByCandidatoAndVaga($candidatoId, $vagaId) {
        $conn = Connection::getConn();

        $sql = "SELECT * FROM candidatura WHERE candidato_id = :candidato_id AND vaga_id = :vaga_id";
        $stm = $conn->prepare($sql);    
        $stm->bindValue("candidato_id", $candidatoId);
        $stm->bindValue("vaga_id", $vagaId);
        $stm->execute();
        $result = $stm->fetchAll();
        $candidaturas = $this->mapCandidaturas($result);

        if($candidaturas) 
            return $candidaturas[0];

        return null;
    }

    public function insert(Candidatura $candidatura) {
        $conn = Connection::getConn();
        $sql = "INSERT INTO candidatura (candidato_id, vaga_id, data_candidatura, status)" .
               " VALUES (:candidato_id, :vaga_id, now(), :status)";
        
        $stm = $conn->prepare($sql); 
        $stm->bindValue("candidato_id", $candidatura->getCandidato()->getId());
        $stm->bindValue("vaga_id", $candidatura->getVaga()->getId());
        $stm->bindValue("status", $candidatura->getStatus()); 
    
        
        $stm->execute();
    }

    private function mapCandidaturas($result) {
        $candidaturas = array();
        foreach ($result as $dado) {
            $candidatura = new Candidatura();
            $candidatura->setId($dado['id']);

            $candidato = new Usuario();
            $candidato->setId($dado['candidato_id']);
            $candidatura->setCandidato($candidato);

            $vaga = new Vaga();
            $vaga->setId($dado['vaga_id']);
            $candidatura->setVaga($vaga);
            
            $candidatura->setDataCandidatura($dado['data_candidatura']);
            $candidatura->setStatus($dado['status']);
            
            array_push($candidaturas, $candidatura);
        }
        return $candidaturas;
    }


        


}




