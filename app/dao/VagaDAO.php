<?php

include_once(__DIR__ . "/../connection/Connection.php");
include_once(__DIR__ . "/../model/Vaga.php");
include_once(__DIR__ . "/../model/enum/Salario.php");
include_once(__DIR__ . "/../dao/UsuarioDAO.php");
include_once(__DIR__ . "/../dao/CargoDAO.php");
include_once(__DIR__ . "/../dao/CategoriaDAO.php");

class VagaDAO {

    private UsuarioDAO $usuarioDao;
    private CargoDAO $cargoDao;
    private CategoriaDAO $categoriaDao;

    public function __construct() {

        $this->usuarioDao = new UsuarioDAO();
        $this->cargoDao = new CargoDAO();
        $this->categoriaDao = new CategoriaDAO();
       
    }

    public function list() {
        $conn = Connection::getConn();

        $sql = "SELECT * FROM vaga v ORDER BY v.titulo";
        $stm = $conn->prepare($sql);    
        $stm->execute();
        $result = $stm->fetchAll();
        
        return $this->mapVagas($result);
    }

        public function listByFiltros($idCategoria, $modalidade, $cargaHoraria, $regime, $salario, $cargo, $limit, $offset) {
        $conn = Connection::getConn();

        $sql = "SELECT * FROM vaga v 
                WHERE v.status = 'Ativo'";

        if($idCategoria > 0)
            $sql .= " AND v.categoria_id = :id_categoria";
        if(!empty($modalidade))
            $sql .= " AND v.modalidade = :modalidade";
        if(!empty($cargaHoraria))
            $sql .= " AND v.horario = :horario";
        if(!empty($regime))
            $sql .= " AND v.regime = :regime";
        if(!empty($salario))
            $sql .= " AND v.salario >= :salario";
        if($cargo > 0)
            $sql .= " AND v.cargos_id = :cargo_id";
        

        $sql .= " ORDER BY v.titulo LIMIT :limit OFFSET :offset";
        $stm = $conn->prepare($sql); 
        
        if($idCategoria > 0)
            $stm->bindValue("id_categoria", $idCategoria);
        if(!empty($modalidade))
            $stm->bindValue("modalidade", $modalidade);
        if(!empty($cargaHoraria))
            $stm->bindValue("horario", $cargaHoraria);
        if(!empty($regime))
            $stm->bindValue("regime", $regime);
        if(!empty($salario)){
            $salario = Salario::getValorNumerico($salario);
            $stm->bindValue("salario", $salario);
        }            
        if($cargo > 0)
            $stm->bindValue("cargo_id", $cargo);
        $stm->bindValue("limit", (int)$limit, PDO::PARAM_INT);
        $stm->bindValue("offset", (int)$offset, PDO::PARAM_INT);
        
        $stm->execute();
        $result = $stm->fetchAll();
        
        return $this->mapVagas($result);
    }

    public function countFiltros($idCategoria, $modalidade, $cargaHoraria, $regime, $salario, $cargo) {
    $conn = Connection::getConn();

    $sql = "SELECT COUNT(*) as total FROM vaga v WHERE v.status = 'Ativo'";
    
    if ($idCategoria > 0)
        $sql .= " AND v.categoria_id = :id_categoria";
    if (!empty($modalidade))
        $sql .= " AND v.modalidade = :modalidade";
    if (!empty($cargaHoraria))
        $sql .= " AND v.horario = :horario";
    if (!empty($regime))
        $sql .= " AND v.regime = :regime";
    if ($salario > 0)
        $sql .= " AND v.salario = :salario";
    if ($cargo > 0)
        $sql .= " AND v.cargos_id = :cargo_id";

    $stm = $conn->prepare($sql);

    if ($idCategoria > 0)
        $stm->bindValue(":id_categoria", $idCategoria, PDO::PARAM_INT);
    if (!empty($modalidade))
        $stm->bindValue(":modalidade", $modalidade);
    if (!empty($cargaHoraria))
        $stm->bindValue(":horario", $cargaHoraria);
    if (!empty($regime))
        $stm->bindValue(":regime", $regime);
    if ($salario > 0)
        $stm->bindValue(":salario", $salario);
    if ($cargo > 0)
        $stm->bindValue(":cargo_id", $cargo, PDO::PARAM_INT);

    $stm->execute();
    $result = $stm->fetch();
    return $result['total'];
}

    public function findByEmpresa(int $id) {
        $conn = Connection::getConn();

        $sql = "SELECT * FROM vaga v" .
               " WHERE v.empresa_id = ?";
        $stm = $conn->prepare($sql);    
        $stm->execute([$id]);
        $result = $stm->fetchAll();

        $vagas = $this->mapVagas($result);

        return $vagas;
        

        die("VagaDAO.findById()" . 
            " - Erro: mais de um usuário encontrado.");
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
         salario, descricao, requisitos, status, empresa_id, cargos_id, categoria_id)" .
               " VALUES (:titulo, :modalidade, :horario, :regime, :salario,
               :descricao, :requisitos, :status, :empresa_id, :cargos_id, :categoria_id)";
        
        $stm = $conn->prepare($sql);
        $stm->bindValue("titulo", $vaga->getTitulo());
        $stm->bindValue("modalidade", $vaga->getModalidade());
        $stm->bindValue("horario", $vaga->getHorario());
        $stm->bindValue("regime", $vaga->getRegime());
        $stm->bindValue("salario", $vaga->getSalario());
        $stm->bindValue("descricao", $vaga->getDescricao());
        $stm->bindValue("requisitos", $vaga->getRequisitos());
        $stm->bindValue("status", $vaga->getStatus());
        $stm->bindValue("empresa_id", $vaga->getEmpresa()->getId());
        $stm->bindValue("cargos_id", $vaga->getCargo()->getId());
        $stm->bindValue("categoria_id", $vaga->getCategoria()->getId());
        
        
        $stm->execute();
    }

    public function update(Vaga $vaga) {
        $conn = Connection::getConn();

        $sql = "UPDATE vaga SET titulo = :titulo, modalidade = :modalidade," . 
               " horario = :horario, regime = :regime, salario = :salario, descricao = :descricao," .
               " requisitos = :requisitos, status = :status, empresa_id = :empresa_id, cargos_id = :cargos_id, categoria_id = :categoria_id" .   
               " WHERE id = :id";
        
        $stm = $conn->prepare($sql);
        $stm->bindValue("titulo", $vaga->getTitulo());
        $stm->bindValue("modalidade", $vaga->getModalidade());
        $stm->bindValue("horario", $vaga->getHorario());
        $stm->bindValue("regime", $vaga->getRegime());
        $stm->bindValue("salario", $vaga->getSalario());
        $stm->bindValue("descricao", $vaga->getDescricao());
        $stm->bindValue("requisitos", $vaga->getRequisitos());
        $stm->bindValue("status", $vaga->getStatus());
        $stm->bindValue("empresa_id", $vaga->getEmpresa()->getId());
        $stm->bindValue("cargos_id", $vaga->getCargo()->getId());
        $stm->bindValue("categoria_id", $vaga->getCategoria()->getId());
        $stm->bindValue("id", $vaga->getId());
        $stm->execute();
    }

    public function deleteById(int $id) {
        $conn = Connection::getConn();

        $sql = "DELETE FROM vaga WHERE id = ?";
        $stm = $conn->prepare($sql);
        $stm->execute([$id]);
    }

    public function searchByTitle($title) {
        $conn = Connection::getConn();

        $sql = "SELECT * FROM vaga v" .
               " WHERE v.titulo LIKE ?";
        $stm = $conn->prepare($sql);
        $stm->execute(["%" . $title . "%"]);
        $result = $stm->fetchAll();
        
        return $this->mapVagas($result);
    }

    public function filterByStatus($status) {
        $conn = Connection::getConn();

        $sql = "SELECT * FROM vaga v" .
               " WHERE v.status = ?";
        $stm = $conn->prepare($sql);
        $stm->execute([$status]);
        $result = $stm->fetchAll();

        return $this->mapVagas($result);
    }

    public function filterByStatusAndEmpresa($status, $empresaId) {
        $conn = Connection::getConn();

        $sql = "SELECT * FROM vaga v" .
               " WHERE v.status = ? AND v.empresa_id = ?";
        $stm = $conn->prepare($sql);
        $stm->execute([$status, $empresaId]);
        $result = $stm->fetchAll();
        
        return $this->mapVagas($result);
    }

    private function mapVagas($result) {
        $vagas = array();
        foreach ($result as $dado) {
            $vaga = new Vaga();
            $vaga->setId($dado['id']);
            $vaga->setTitulo($dado['titulo']);
            $vaga->setModalidade($dado['modalidade']);
            $vaga->setHorario($dado['horario']);
            $vaga->setRegime($dado['regime']);
            $vaga->setSalario($dado['salario']);
            $vaga->setDescricao($dado['descricao']);
            $vaga->setRequisitos($dado['requisitos']);
            $vaga->setStatus($dado['status']);

            //Carregar empresa
            $empresa = $this->usuarioDao->findById($dado['empresa_id']);
            $vaga->setEmpresa($empresa);

            //Carregar cargo
            $cargo = $this->cargoDao->findById($dado['cargos_id']);
            $vaga->setCargo($cargo);

            //Carregar categoria
            if(isset($dado['categoria_id'])) {
                $categoria = $this->categoriaDao->findById($dado['categoria_id']);
                $vaga->setCategoria($categoria);
            }
            
            array_push($vagas, $vaga);
        }

        return $vagas;
    }

}