<?php 

include_once(__DIR__ . "/../connection/Connection.php");
include_once(__DIR__ . "/../model/Cargo.php");

class CargoDAO { 
    
    public function list() {
        $conn = Connection::getConn();

        $sql = "SELECT * FROM cargos";
        $stm = $conn->prepare($sql);    
        $stm->execute();
        $result = $stm->fetchAll();
        
        return $this->mapCargos($result);
    }
    

    public function insert(Cargo $cargo) {
        $conn = Connection::getConn();

        $sql = "INSERT INTO cargos (nome)" .
               " VALUES (:nome)";
        
        $stm = $conn->prepare($sql);
        $stm->bindValue("nome", $cargo->getNome());
        $stm->execute();
    }

    private function mapCargos($result) {
        $cargos = array();
        foreach ($result as $dado) {
            $cargo = new Cargo();
            $cargo->setId($dado['id']);
            $cargo->setNome($dado['nome']);
            array_push($cargos, $cargo);
        }

        return $cargos;
    }

}