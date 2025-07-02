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

    public function listByFiltros($search, $idCategoria, $modalidade, $cargaHoraria, $regime, $salario, $cargo, $limit, $offset, $idCidade) {
        $conn = Connection::getConn();

        $sql = "SELECT v.* FROM vaga v 
                JOIN usuario u ON v.empresa_id = u.id
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
        if(!empty($search))
            $sql .= " AND v.titulo LIKE :search";
        if ($idCidade > 0)
            $sql .= " AND u.cidade_id = :id_cidade";

        $sql .= " ORDER BY v.titulo LIMIT :limit OFFSET :offset";

        $stm = $conn->prepare($sql);

        if(!empty($search)){
            $titulo = "%" . $search . "%";
            $stm->bindValue("search", $titulo);
        }
        if($idCategoria > 0)
            $stm->bindValue("id_categoria", $idCategoria, PDO::PARAM_INT);
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
            $stm->bindValue("cargo_id", $cargo, PDO::PARAM_INT);
        $stm->bindValue("limit", (int)$limit, PDO::PARAM_INT);
        $stm->bindValue("offset", (int)$offset, PDO::PARAM_INT);
        if ($idCidade > 0)
            $stm->bindValue("id_cidade", $idCidade, PDO::PARAM_INT);

        $stm->execute();
        $result = $stm->fetchAll();

        return $this->mapVagas($result);
    }


    public function countFiltros($search, $idCategoria, $modalidade, $cargaHoraria, $regime, $salario, $cargo, $idCidade) {
    $conn = Connection::getConn();

    $sql = "SELECT COUNT(*) as total FROM vaga v 
            JOIN usuario u ON v.empresa_id = u.id
            WHERE v.status = 'Ativo'";

    if (!empty($search))
        $sql .= " AND v.titulo = :search";
    if ($idCategoria > 0)
        $sql .= " AND v.categoria_id = :id_categoria";
    if (!empty($modalidade))
        $sql .= " AND v.modalidade = :modalidade";
    if (!empty($cargaHoraria))
        $sql .= " AND v.horario = :horario";
    if (!empty($regime))
        $sql .= " AND v.regime = :regime";
    if ($salario > 0)
        $sql .= " AND v.salario >= :salario";
    if ($cargo > 0)
        $sql .= " AND v.cargos_id = :cargo_id";
    if ($idCidade > 0)
        $sql .= " AND u.cidade_id = :id_cidade";

    $stm = $conn->prepare($sql);

    if (!empty($search))
        $stm->bindValue(":search", $search);
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
    if ($idCidade > 0)
        $stm->bindValue(":id_cidade", $idCidade, PDO::PARAM_INT);

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

        $sql = "DELETE FROM vaga WHERE id = :id";
        
        $stm = $conn->prepare($sql);
        $stm->bindValue("id", $id);
        $stm->execute();
    }

    public function inativarVaga(int $id) {
        $conn = Connection::getConn();

        $sql = "UPDATE vaga SET status = 'Inativo'".     
               " WHERE id = :id";
        
        $stm = $conn->prepare($sql);
        $stm->bindValue("id", $id);
        $stm->execute();
    }

    public function searchByTitle($title) {
        $conn = Connection::getConn();

        $sql = "SELECT * FROM vaga v WHERE LOWER(v.titulo) LIKE LOWER(:title) ORDER BY v.titulo";
        $stm = $conn->prepare($sql);    
        $stm->bindValue("title", "%" . $title . "%");
        $stm->execute();
        $result = $stm->fetchAll();
        
        return $this->mapVagas($result);
    }

    public function filterByStatus($status) {
        $conn = Connection::getConn();

        $sql = "SELECT * FROM vaga v WHERE v.status = :status ORDER BY v.titulo";
        $stm = $conn->prepare($sql);    
        $stm->bindValue("status", $status);
        $stm->execute();
        $result = $stm->fetchAll();
        
        return $this->mapVagas($result);
    }

    public function filterByStatusAndEmpresa($status, $empresaId) {
        $conn = Connection::getConn();

        $sql = "SELECT * FROM vaga v WHERE v.status = :status AND v.empresa_id = :empresa_id ORDER BY v.titulo";
        $stm = $conn->prepare($sql);    
        $stm->bindValue("status", $status);
        $stm->bindValue("empresa_id", $empresaId);
        $stm->execute();
        $result = $stm->fetchAll();
        
        return $this->mapVagas($result);
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
            $vaga->setStatus($reg['status']);
            $vaga->setEmpresa($this->usuarioDao->findById($reg['empresa_id']));
            $vaga->setCargo($this->cargoDao->findById($reg['cargos_id']));
            $vaga->setCategoria($this->categoriaDao->findById($reg['categoria_id']));
            array_push($vagas, $vaga);
        }

        return $vagas;
    }

}