<?php
include_once(__DIR__ . "/../connection/Connection.php");
include_once(__DIR__ . "/../model/Estado.php");

class EstadoDAO { 
    
    public function list() {
        $conn = Connection::getConn();

        $sql = "SELECT * FROM estados ORDER BY nome";
        $stm = $conn->prepare($sql);    
        $stm->execute();
        $result = $stm->fetchAll();
        
        return $this->mapEstado($result);
    }

    public function findById(int $id) {
        $conn = Connection::getConn();

        $sql = "SELECT * FROM estados e" .
               " WHERE e.codigo_uf = ?";
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
            $estado->setCodigoUf($dado['codigo_uf']);
            $estado->setNome($dado['nome']);
            $estado->setUf($dado['uf']);
            $estado->setLatitude($dado['latitude']);
            $estado->setLongitude($dado['longitude']);
            $estado->setRegiao($dado['regiao']);
            array_push($estados, $estado);
        }

        return $estados;
    }

}