<?php
#Nome do arquivo: UsuarioDAO.php
#Objetivo: classe DAO para o model de Usuario

include_once(__DIR__ . "/../connection/Connection.php");
include_once(__DIR__ . "/../dao/EstadoDAO.php");
include_once(__DIR__ . "/../model/Cidade.php");
include_once(__DIR__ . "/../model/Estado.php");

class CidadeDAO {
    private EstadoDAO $estadoDAO;

    public function __construct() {

        $this->estadoDAO = new EstadoDAO;
       
    }

    public function list() {
        $conn = Connection::getConn();

        $sql = "SELECT * FROM cidades c ORDER BY c.nome";
        $stm = $conn->prepare($sql);    
        $stm->execute();
        $result = $stm->fetchAll();
        
        return $this->mapCidades($result);
    }

    public function findById(int $id) {
        $conn = Connection::getConn();

        $sql = "SELECT * FROM cidades c" .
               " WHERE c.codigo_ibge = ?";
        $stm = $conn->prepare($sql);    
        $stm->execute([$id]);
        $result = $stm->fetchAll();

        $cidades = $this->mapCidades($result);

        if(count($cidades) == 1)
            return $cidades[0];
        elseif(count($cidades) == 0)
            return null;

        die("CidadeDAO.findById()" . 
            " - Erro: mais de uma cidade encontrada.");
    }

    public function findByEstado(int $id) {
        $conn = Connection::getConn();

        $sql = "SELECT * FROM cidades c" .
               " WHERE c.codigo_uf = ?";
        $stm = $conn->prepare($sql);    
        $stm->execute([$id]);
        $result = $stm->fetchAll();

        return $this->mapCidades($result);

    }

    public function findByNome(string $nome) {
        $conn = Connection::getConn();

         $sql = "SELECT c.*, e.uf 
            FROM cidades c
            INNER JOIN estados e ON c.codigo_uf = e.codigo_uf
            WHERE c.nome LIKE ?
            ORDER BY c.nome
            LIMIT 10";

        $stm = $conn->prepare($sql);
        $nomeBusca = "%" . $nome . "%";    
        $stm->execute([$nomeBusca]);
        $result = $stm->fetchAll();

        return $this->mapCidadesComEstadoSigla($result);

    }

    //Método para converter um registro da base de dados em um objeto Usuario
    private function mapCidades($result) {
        $cidades = array();
        foreach ($result as $reg) {
            $cidade = new Cidade();
            $cidade->setCodigoIbge($reg['codigo_ibge']);
            $cidade->setNome($reg['nome']);
            $cidade->setLatitude($reg['latitude']);
            $cidade->setLongitude($reg['longitude']);
            $cidade->setCapital($reg['capital']);
            $cidade->setDdd($reg['ddd']);
            $cidade->setFusoHorario($reg['fuso_horario']);
            $cidade->setSiafiId($reg['siafi_id']);
            $cidade->setEstado($this->estadoDAO->findById($reg['codigo_uf']));
    
            array_push($cidades, $cidade);
        }

        return $cidades;
    }

    private function mapCidadesComEstadoSigla($result) {
        $cidades = array();
        foreach ($result as $reg) {
            $cidade = new Cidade();
            $cidade->setCodigoIbge($reg['codigo_ibge']);
            $cidade->setNome($reg['nome']);
            $cidade->setLatitude($reg['latitude']);
            $cidade->setLongitude($reg['longitude']);
            $cidade->setCapital($reg['capital']);
            $cidade->setDdd($reg['ddd']);
            $cidade->setFusoHorario($reg['fuso_horario']);
            $cidade->setSiafiId($reg['siafi_id']);

            // Cria um estado com apenas a sigla
            $estado = new Estado();
            $estado->setUf($reg['uf']);
            $cidade->setEstado($estado);

            array_push($cidades, $cidade);
        }

        return $cidades;
    }


}