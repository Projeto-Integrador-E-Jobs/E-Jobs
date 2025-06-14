<?php
#Nome do arquivo: UsuarioDAO.php
#Objetivo: classe DAO para o model de Usuario

include_once(__DIR__ . "/../connection/Connection.php");
include_once(__DIR__ . "/../dao/TipoUsuarioDAO.php");
include_once(__DIR__ . "/../dao/CidadeDAO.php");
include_once(__DIR__ . "/../model/Usuario.php");
include_once(__DIR__ . "/../model/TipoUsuario.php");

class UsuarioDAO {
    private TipoUsuarioDAO $tipoUsuarioDao;
    private CidadeDAO $cidadeDAO;

    public function __construct() {

        $this->cidadeDAO = new CidadeDAO;
        $this->tipoUsuarioDao = new TipoUsuarioDAO;
       
    }

    //Método para listar os usuaários a partir da base de dados
    public function list() {
        $conn = Connection::getConn();

        $sql = "SELECT * FROM usuario u ORDER BY u.nome";
        $stm = $conn->prepare($sql);    
        $stm->execute();
        $result = $stm->fetchAll();
        
        return $this->mapUsuarios($result);
    }

     public function listEmpresasPendentes() {
        $conn = Connection::getConn();

        $sql = "SELECT * FROM usuario u 
                WHERE u.status = 'Pendente' 
                AND tipo_usuario_id = 3
                ORDER BY u.nome";
        $stm = $conn->prepare($sql);    
        $stm->execute();
        $result = $stm->fetchAll();
        
        return $this->mapUsuarios($result);
    }

    //Método para buscar um usuário por seu ID
    public function findById(int $id) {
        $conn = Connection::getConn();

        $sql = "SELECT * FROM usuario u" .
               " WHERE u.id = ?";
        $stm = $conn->prepare($sql);    
        $stm->execute([$id]);
        $result = $stm->fetchAll();

        $usuarios = $this->mapUsuarios($result);

        if(count($usuarios) == 1)
            return $usuarios[0];
        elseif(count($usuarios) == 0)
            return null;

        die("UsuarioDAO.findById()" . 
            " - Erro: mais de um usuário encontrado.");
    }

    public function findByDocumento(string $documento) {
        $conn = Connection::getConn();

        $sql = "SELECT * FROM usuario u" .
               " WHERE u.documento = ?";
        $stm = $conn->prepare($sql);    
        $stm->execute([$documento]);
        $result = $stm->fetchAll();

        $usuarios = $this->mapUsuarios($result);

        if(count($usuarios) == 1)
            return $usuarios[0];
        elseif(count($usuarios) == 0)
            return null;
    }

    public function findByEmail(string $email) {
        $conn = Connection::getConn();

        $sql = "SELECT * FROM usuario u" .
               " WHERE u.email = ?";
        $stm = $conn->prepare($sql);    
        $stm->execute([$email]);
        $result = $stm->fetchAll();

        $usuarios = $this->mapUsuarios($result);

        if(count($usuarios) == 1)
            return $usuarios[0];
        elseif(count($usuarios) == 0)
            return null;
    }


    //Método para buscar um usuário por seu login e senha
    public function findByLoginSenha(string $email, string $senha) {
        $conn = Connection::getConn();

        $sql = "SELECT * FROM usuario u" .
               " WHERE BINARY u.email = ?";
        $stm = $conn->prepare($sql);    
        $stm->execute([$email]);
        $result = $stm->fetchAll();

        $usuarios = $this->mapUsuarios($result);

        if(count($usuarios) == 1) {
            //Tratamento para senha criptografada
            if(password_verify($senha, $usuarios[0]->getSenha()))
                return $usuarios[0];
            else
                return null;
        } elseif(count($usuarios) == 0)
            return null;

        die("UsuarioDAO.findByLoginSenha()" . 
            " - Erro: mais de um usuário encontrado.");
    }

    //Método para inserir um Usuario
    public function insert(Usuario $usuario) {
        $conn = Connection::getConn();

        $sql = "INSERT INTO usuario (nome, email, senha,
        documento, descricao, cidade_id, end_logradouro,
        end_bairro, end_numero, telefone, status, tipo_usuario_id)" .
               " VALUES (:nome, :email, :senha, :documento, :descricao,
               :cidade, :endLogradouro, :endBairro, :endNumero,
               :telefone, :status, :tipoUsuario)";
        
        $stm = $conn->prepare($sql);
        $stm->bindValue("nome", $usuario->getNome());
        $stm->bindValue("email", $usuario->getEmail());
        $stm->bindValue("senha", password_hash($usuario->getSenha(), PASSWORD_DEFAULT));
        $stm->bindValue("documento", $usuario->getDocumento());
        $stm->bindValue("descricao", $usuario->getDescricao());
        $stm->bindValue("cidade", $usuario->getCidade()->getCodigoIbge());
        $stm->bindValue("endLogradouro", $usuario->getEndLogradouro());
        $stm->bindValue("endBairro", $usuario->getEndBairro());
        $stm->bindValue("endNumero", $usuario->getEndNumero());
        $stm->bindValue("telefone", $usuario->getTelefone());
        $stm->bindValue("status", $usuario->getStatus());
        $stm->bindValue("tipoUsuario", $usuario->getTipoUsuario()->getId());
        $stm->execute();
    }

    //Método para atualizar um Usuario
    public function update(Usuario $usuario) {
        $conn = Connection::getConn();

        $sql = "UPDATE usuario SET nome = :nome, email = :email," . 
               " documento = :documento, telefone = :telefone" .     
               " WHERE id = :id";
        
        $stm = $conn->prepare($sql);
        $stm->bindValue("nome", $usuario->getNome());
        $stm->bindValue("email", $usuario->getEmail());
        $stm->bindValue("documento", $usuario->getDocumento());
        $stm->bindValue("telefone", $usuario->getTelefone());
        $stm->bindValue("id", $usuario->getId());
        $stm->execute();
    }

    //Método para excluir um Usuario pelo seu ID
    public function deleteById(int $id) {
        $conn = Connection::getConn();

        $sql = "DELETE FROM usuario WHERE id = :id";
        
        $stm = $conn->prepare($sql);
        $stm->bindValue("id", $id);
        $stm->execute();
    }

    public function aprovarEmpresa(Usuario $usuario) {
        $conn = Connection::getConn();

        $sql = "UPDATE usuario SET status = 'Ativo'".     
               " WHERE id = :id";
        
        $stm = $conn->prepare($sql);
        $stm->bindValue("id", $usuario->getId());
        $stm->execute();
    }

    public function inativarUsuario(Usuario $usuario) {
        $conn = Connection::getConn();

        $sql = "UPDATE usuario SET status = 'Inativo'".     
               " WHERE id = :id";
        
        $stm = $conn->prepare($sql);
        $stm->bindValue("id", $usuario->getId());
        $stm->execute();
    }

    //Método para converter um registro da base de dados em um objeto Usuario
    private function mapUsuarios($result) {
        $usuarios = array();
        foreach ($result as $reg) {
            $usuario = new Usuario();
            $usuario->setId($reg['id']);
            $usuario->setNome($reg['nome']);
            $usuario->setEmail($reg['email']);
            $usuario->setSenha($reg['senha']);
            $usuario->setDocumento($reg['documento']);
            $usuario->setDescricao($reg['descricao']);
            $usuario->setCidade($this->cidadeDAO->findById($reg['cidade_id']));
            $usuario->setEndLogradouro($reg['end_logradouro']);
            $usuario->setEndBairro($reg['end_bairro']);
            $usuario->setEndNumero($reg['end_numero']);
            $usuario->setTelefone($reg['telefone']);
            $usuario->setStatus($reg['status']);
            $usuario->setTipoUsuario($this->tipoUsuarioDao->findById($reg['tipo_usuario_id']));
            array_push($usuarios, $usuario);
        }

        return $usuarios;
    }

}