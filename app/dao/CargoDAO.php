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

    public function findById(int $id) {
        $conn = Connection::getConn();

        $sql = "SELECT * FROM cargos " .
               " WHERE id = ?";
        $stm = $conn->prepare($sql);    
        $stm->execute([$id]);
        $result = $stm->fetchAll();

        $cargos = $this->mapCargos($result);

        if(count($cargos) == 1)
            return $cargos[0];
        elseif(count($cargos) == 0)
            return null;

    }
    

    public function insert(Cargo $cargo) {
        $conn = Connection::getConn();

        $sql = "INSERT INTO cargos (nome)" .
               " VALUES (:nome)";
        
        $stm = $conn->prepare($sql);
        $stm->bindValue("nome", $cargo->getNome());
        $stm->execute();
    }

    public function update(Cargo $cargo) {
        $conn = Connection::getConn();
    
        $sql = "UPDATE cargos SET nome = :nome WHERE id = :id";        
        $stm = $conn->prepare($sql);
        $stm->bindValue("id", $cargo->getId());
        $stm->bindValue("nome", $cargo->getNome());
    
        $stm->execute();
    }
    

    public function deleteById(int $id) {
        $conn = Connection::getConn();
    
        $sql = "DELETE FROM cargos WHERE id = :id";
        
        $stm = $conn->prepare($sql);
        $stm->bindValue("id", $id);
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