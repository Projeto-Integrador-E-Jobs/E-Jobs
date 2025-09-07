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

    public function findByCandidato($candidatoId) {
        $conn = Connection::getConn();

        $sql = "SELECT c.*,c.status AS candidatura_status, v.*, u.nome as empresa_nome, car.nome as cargo_nome 
                FROM candidatura c 
                JOIN vaga v ON c.vaga_id = v.id 
                JOIN usuario u ON v.empresa_id = u.id 
                JOIN cargos car ON v.cargos_id = car.id 
                WHERE c.candidato_id = :candidato_id 
                ORDER BY c.data_candidatura DESC";
        
        $stm = $conn->prepare($sql);    
        $stm->bindValue("candidato_id", $candidatoId);
        $stm->execute();
        $result = $stm->fetchAll();
        
        return $this->mapCandidaturasComVaga($result);
    }

    private function mapCandidaturasComVaga($result) {
        $candidaturas = array();
        foreach ($result as $dado) {
            $candidatura = new Candidatura();
            $candidatura->setId($dado['id']);
            
            $candidato = new Usuario();
            $candidato->setId($dado['candidato_id']);
            $candidatura->setCandidato($candidato);

            $vaga = new Vaga();
            $vaga->setId($dado['vaga_id']);
            $vaga->setTitulo($dado['titulo']);
            $vaga->setModalidade($dado['modalidade']);
            $vaga->setHorario($dado['horario']);
            $vaga->setRegime($dado['regime']);
            $vaga->setSalario($dado['salario']);
            $vaga->setDescricao($dado['descricao']);
            $vaga->setRequisitos($dado['requisitos']);
            $vaga->setStatus($dado['status']);

            $empresa = new Usuario();
            $empresa->setId($dado['empresa_id']);
            $empresa->setNome($dado['empresa_nome']);
            $vaga->setEmpresa($empresa);

            $cargo = new Cargo();
            $cargo->setId($dado['cargos_id']);
            $cargo->setNome($dado['cargo_nome']);
            $vaga->setCargo($cargo);

            $candidatura->setVaga($vaga);
            $candidatura->setDataCandidatura($dado['data_candidatura']);
            $candidatura->setStatus($dado['candidatura_status']);
            
            array_push($candidaturas, $candidatura);
        }
        return $candidaturas;
    }

    public function findByVaga(int $vagaId) {
        $conn = Connection::getConn();

        $sql = "SELECT c.*, u.nome, u.email 
                FROM candidatura c 
                JOIN usuario u ON c.candidato_id = u.id 
                WHERE c.vaga_id = ?";
        $stm = $conn->prepare($sql);    
        $stm->execute([$vagaId]);
        $result = $stm->fetchAll();

        return $this->mapCandidaturasComCandidato($result);
    }

    private function mapCandidaturasComCandidato($result) {
        $candidaturas = array();
        foreach ($result as $dado) {
            $candidatura = new Candidatura();
            $candidatura->setId($dado['id']);
            
            $candidato = new Usuario();
            $candidato->setId($dado['candidato_id']);
            $candidato->setNome($dado['nome']);
            $candidato->setEmail($dado['email']);
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




