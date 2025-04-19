<?php
include_once(__DIR__ . "/../connection/Connection.php");
include_once(__DIR__ . "/../model/TipoUsuario.php");

class TipoUsuarioDAO { 
    
    public function list() {
        $conn = Connection::getConn();

        $sql = "SELECT * FROM tipo_usuario";
        $stm = $conn->prepare($sql);    
        $stm->execute();
        $result = $stm->fetchAll();
        
        return $this->mapTipoUsuario($result);
    }

    public function listSemADM() {
        $conn = Connection::getConn();

        $sql = "SELECT * FROM tipo_usuario WHERE nome != 'ADMINISTRADOR'";
        $stm = $conn->prepare($sql);    
        $stm->execute();
        $result = $stm->fetchAll();
        
        return $this->mapTipoUsuario($result);
    }

    public function findById(int $id) {
        $conn = Connection::getConn();

        $sql = "SELECT * FROM tipo_usuario t" .
               " WHERE t.id = ?";
        $stm = $conn->prepare($sql);    
        $stm->execute([$id]);
        $result = $stm->fetchAll();

        $tipoUsuarios = $this->mapTipoUsuario($result);

        if(count($tipoUsuarios) == 1)
            return $tipoUsuarios[0];
        elseif(count($tipoUsuarios) == 0)
            return null;

        die("TipoUsuarioDAO.findById()" . 
            " - Erro: mais de um usuário encontrado.");
    }
    

    private function mapTipoUsuario($result) {
        $tipoUsuarios = array();
        foreach ($result as $dado) {
            $tipoUsuario = new TipoUsuario();
            $tipoUsuario->setId($dado['id']);
            $tipoUsuario->setNome($dado['nome']);
            array_push($tipoUsuarios, $tipoUsuario);
        }

        return $tipoUsuarios;
    }

}