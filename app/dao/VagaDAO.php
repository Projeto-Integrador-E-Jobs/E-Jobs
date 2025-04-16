<?php

include_once(__DIR__ . "/../connection/Connection.php");
include_once(__DIR__ . "/../model/Vaga.php");
include_once(__DIR__ . "/../dao/UsuarioDAO.php");
include_once(__DIR__ . "/../dao/CargoDAO.php");

class VagaDAO {

    private UsuarioDAO $usuarioDao;
    private CargoDAO $cargoDao;

    public function __construct() {

        $this->usuarioDao = new UsuarioDAO();
        $this->cargoDao = new CargoDAO();
       
    }

    public function list() {
        $conn = Connection::getConn();

        $sql = "SELECT * FROM vaga v ORDER BY v.titulo";
        $stm = $conn->prepare($sql);    
        $stm->execute();
        $result = $stm->fetchAll();
        
        return $this->mapVagas($result);
    }

    
    public function findById(int $id) {
        $conn = Connection::getConn();

        $sql = "SELECT * FROM vaga v" .
               " WHERE v.id = ?";
        $stm = $conn->prepare($sql);    
        $stm->execute([$id]);
        $result = $stm->fetchAll();

        $vagas = $this->mapVagas($result);

        if(count($vagas) == 1)
            return $vagas[0];
        elseif(count($vagas) == 0)
            return null;

        die("VagaDAO.findById()" . 
            " - Erro: mais de um usuário encontrado.");
    }


   
    public function insert(Vaga $vaga) {
        $conn = Connection::getConn();

        $sql = "INSERT INTO vaga (titulo, modalidade, horario, regime,
         salario, descricao, requisitos, empresa_id, cargos_id)" .
               " VALUES (:titulo, :modalidade, :horario, :regime, :salario,
               :descricao, :descricao, :requisitos, :empresa_id, :cargos_id)";
        
        $stm = $conn->prepare($sql);
        $stm->bindValue("titulo", $vaga->getTitulo());
        $stm->bindValue("modalidade", $vaga->getModalidade());
        $stm->bindValue("horario", $vaga->getHorario());
        $stm->bindValue("regime", $vaga->getRegime());
        $stm->bindValue("salario", $vaga->getSalario());
        $stm->bindValue("descricao", $vaga->getDescricao());
        $stm->bindValue("requisitos", $vaga->getRequisitos());
        $stm->bindValue("empresa_id", $vaga->getEmpresa()->getId());
        $stm->bindValue("cargos_id", $vaga->getCargo()->getId());
        
        
        $stm->execute();
    }

    public function update(Vaga $vaga) {
        $conn = Connection::getConn();

        $sql = "UPDATE vaga SET titulo = :titulo, modalidade = :modalidade," . 
               " horario = :horario, regime = :regime, salario = :salario, descricao = :descricao," .
               " requisitos = :requisitos, empresa_id = :empresa_id, cargos_id = :cargos_id" .   
               " WHERE id = :id";
        
        $stm = $conn->prepare($sql);
        $stm->bindValue("titulo", $vaga->getTitulo());
        $stm->bindValue("modalidade", $vaga->getModalidade());
        $stm->bindValue("horario", $vaga->getHorario());
        $stm->bindValue("regime", $vaga->getRegime());
        $stm->bindValue("salario", $vaga->getSalario());
        $stm->bindValue("descricao", $vaga->getDescricao());
        $stm->bindValue("requisitos", $vaga->getRequisitos());
        $stm->bindValue("empresa_id", $vaga->getEmpresa()->getId());
        $stm->bindValue("cargos_id", $vaga->getCargo()->getId());
        $stm->bindValue("id", $vaga->getId());
        $stm->execute();
    }

    public function deleteById(int $id) {
        $conn = Connection::getConn();

        $sql = "DELETE FROM vaga WHERE id = :id";
        
        $stm = $conn->prepare($sql);
        $stm->bindValue("id", $id);
        $stm->execute();
    }

    private function mapVagas($result) {
        $vagas = array();
        foreach ($result as $reg) {
            $vaga = new Vaga();
            $vaga->setId($reg['id']);
            $vaga->setTitulo($reg['titulo']);
            $vaga->setModalidade($reg['modalidade']);
            $vaga->setHorario($reg['horario']);
            $vaga->setRegime($reg['regime']);
            $vaga->setSalario($reg['salario']);
            $vaga->setDescricao($reg['descricao']);
            $vaga->setRequisitos($reg['requisitos']);
            $vaga->setEmpresa($this->usuarioDao->findById($reg['empresa_id']));
            $vaga->setCargo($this->cargoDao->findById($reg['cargos_id']));
            array_push($vagas, $vaga);
        }

        return $vagas;
    }

}