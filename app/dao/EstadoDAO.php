<?php
include_once(__DIR__ . "/../connection/Connection.php");
include_once(__DIR__ . "/../model/Estado.php");

class EstadoDAO { 
    
    public function list() {
        $conn = Connection::getConn();

        $sql = "SELECT * FROM estado";
        $stm = $conn->prepare($sql);    
        $stm->execute();
        $result = $stm->fetchAll();
        
        return $this->mapEstado($result);
    }

    public function findById(int $id) {
        $conn = Connection::getConn();

        $sql = "SELECT * FROM estado e" .
               " WHERE e.id = ?";
        $stm = $conn->prepare($sql);    
        $stm->execute([$id]);
        $result = $stm->fetchAll();

        $tipoUsuarios = $this->mapEstado($result);

        if(count($tipoUsuarios) == 1)
            return $tipoUsuarios[0];
        elseif(count($tipoUsuarios) == 0)
            return null;

        die("EstadoDAO.findById()" . 
            " - Erro: mais de um usuário encontrado.");
    }
    

    private function mapEstado($result) {
        $estados = array();
        foreach ($result as $dado) {
            $estado = new Estado();
            $estado->setId($dado['id']);
            $estado->setNome($dado['nome']);
            $estado->setSigla($dado['sigla']);
            array_push($estados, $estado);
        }

        return $estados;
    }

}