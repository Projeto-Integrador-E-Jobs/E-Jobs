<?php 

include_once(__DIR__ . "/../connection/Connection.php");
include_once(__DIR__ . "/../model/Categoria.php");

class CategoriaDAO { 
    
     public function list() {
        $conn = Connection::getConn();

        $sql = "SELECT *
                FROM categorias c  
                ORDER BY c.nome DESC ";
        $stm = $conn->prepare($sql);    
        $stm->execute();
        $result = $stm->fetchAll();
        
        return $this->mapCategoria($result);
    }

    public function listHome() {
        $conn = Connection::getConn();

        $sql = "SELECT c.id, c.nome, c.icone, COUNT(v.id) AS total_vagas
                FROM categorias c  
                LEFT JOIN vaga v ON v.categoria_id = c.id AND v.status = 'Ativo'
                GROUP BY c.id, c.nome, c.icone
                ORDER BY c.nome ASC Limit 4" ;
        $stm = $conn->prepare($sql);    
        $stm->execute();
        $result = $stm->fetchAll();
        
        return $this->mapCategoria($result);
    }

    public function findById(int $id) {
        $conn = Connection::getConn();

        $sql = "SELECT * FROM categorias " .
               " WHERE id = ?";
        $stm = $conn->prepare($sql);    
        $stm->execute([$id]);
        $result = $stm->fetchAll();

        $categorias = $this->mapCategoria($result);

        if(count($categorias) == 1)
            return $categorias[0];
        elseif(count($categorias) == 0)
            return null;

    }
    

    public function insert(Categoria $categoria) {
        $conn = Connection::getConn();

        $sql = "INSERT INTO categorias (nome, icone)" .
               " VALUES (:nome, :icone)";
        
        $stm = $conn->prepare($sql);
        $stm->bindValue("nome", $categoria->getNome());
        $stm->bindValue("icone", $categoria->getIcone());
        $stm->execute();
    }

    public function update(categoria $categoria) {
        $conn = Connection::getConn();
    
        $sql = "UPDATE categorias SET nome = :nome, icone = :icone WHERE id = :id";        
        $stm = $conn->prepare($sql);
        $stm->bindValue("id", $categoria->getId());
        $stm->bindValue("nome", $categoria->getNome());
        $stm->bindValue("icone", $categoria->getIcone());
    
        $stm->execute();
    }
    

    public function deleteById(int $id) {
        $conn = Connection::getConn();
    
        $sql = "DELETE FROM categorias WHERE id = :id";
        
        $stm = $conn->prepare($sql);
        $stm->bindValue("id", $id);
        $stm->execute();
    }
    

    private function mapCategoria($result) {
        $categorias = array();
        foreach ($result as $dado) {
            $categoria = new Categoria();
            $categoria->setId($dado['id']);
            $categoria->setNome($dado['nome']);
            $categoria->setIcone($dado['icone']);
            $categoria->setTotalVagas($dado['total_vagas'] ?? 0);
            array_push($categorias, $categoria);
        }

        return $categorias;
    }

}