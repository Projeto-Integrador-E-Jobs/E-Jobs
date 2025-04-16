<?php
#Nome do arquivo: UsuarioDAO.php
#Objetivo: classe DAO para o model de Usuario

include_once(__DIR__ . "/../connection/Connection.php");
include_once(__DIR__ . "/../dao/TipoUsuarioDAO.php");
include_once(__DIR__ . "/../dao/EstadoDAO.php");
include_once(__DIR__ . "/../model/Usuario.php");
include_once(__DIR__ . "/../model/TipoUsuario.php");

class UsuarioDAO {
    private TipoUsuarioDAO $tipoUsuarioDao;
    private EstadoDAO $estadoDAO;

    public function __construct() {

        $this->estadoDAO = new EstadoDAO;
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
        documento, descricao, estado_id, cidade, end_logradouro,
        end_bairro, end_numero,end_complemento, telefone, status, tipo_usuario_id)" .
               " VALUES (:nome, :email, :senha, :documento, :descricao,
               :estado, :cidade, :endLogradouro, :endBairro, :endNumero,
               :endCompleto, :telefone, :status, :tipoUsuario)";
        
        $stm = $conn->prepare($sql);
        $stm->bindValue("nome", $usuario->getNome());
        $stm->bindValue("email", $usuario->getEmail());
        $stm->bindValue("senha", password_hash($usuario->getSenha(), PASSWORD_DEFAULT));
        $stm->bindValue("documento", $usuario->getDocumento());
        $stm->bindValue("descricao", $usuario->getDescricao());
        $stm->bindValue("estado", $usuario->getEstado()->getId());
        $stm->bindValue("cidade", $usuario->getCidade());
        $stm->bindValue("endLogradouro", $usuario->getEndLogradouro());
        $stm->bindValue("endBairro", $usuario->getEndBairro());
        $stm->bindValue("endNumero", $usuario->getEndNumero());
        $stm->bindValue("endCompleto", $usuario->getEndCompleto());
        $stm->bindValue("telefone", $usuario->getTelefone());
        $stm->bindValue("status", $usuario->getStatus());
        $stm->bindValue("tipoUsuario", $usuario->getTipoUsuario()->getId());
        $stm->execute();
    }

    //Método para atualizar um Usuario
    public function update(Usuario $usuario) {
        $conn = Connection::getConn();

        $sql = "UPDATE usuario SET nome = :nome, email = :email," . 
               " senha = :senha, documento = :documento, descricao = :descricao," .
               "estado_id = :estado, cidade = :cidade, end_logradouro = :endLogradouro," .
               "end_bairro = :endBairro, end_numero = :endNumero, end_complemento = :endCompleto," . 
               "telefone = :telefone, status = :status, tipo_usuario_id = :tipoUsuario" .     
               " WHERE id = :id";
        
        $stm = $conn->prepare($sql);
        $stm->bindValue("nome", $usuario->getNome());
        $stm->bindValue("email", $usuario->getEmail());
        $stm->bindValue("senha", password_hash($usuario->getSenha(), PASSWORD_DEFAULT));
        $stm->bindValue("documento", $usuario->getDocumento());
        $stm->bindValue("descricao", $usuario->getDescricao());
        $stm->bindValue("estado", $usuario->getEstado()->getId());
        $stm->bindValue("cidade", $usuario->getCidade());
        $stm->bindValue("endLogradouro", $usuario->getEndLogradouro());
        $stm->bindValue("endBairro", $usuario->getEndBairro());
        $stm->bindValue("endNumero", $usuario->getEndNumero());
        $stm->bindValue("endCompleto", $usuario->getEndCompleto());
        $stm->bindValue("telefone", $usuario->getTelefone());
        $stm->bindValue("status", $usuario->getStatus());
        $stm->bindValue("tipoUsuario", $usuario->getTipoUsuario()->getId());
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
            $usuario->setEstado($this->estadoDAO->findById($reg['estado_id']));
            $usuario->setCidade($reg['cidade']);
            $usuario->setEndLogradouro($reg['end_logradouro']);
            $usuario->setEndBairro($reg['end_bairro']);
            $usuario->setEndNumero($reg['end_numero']);
            $usuario->setEndCompleto($reg['end_complemento']);
            $usuario->setTelefone($reg['telefone']);
            $usuario->setStatus($reg['status']);
            $usuario->setTipoUsuario($this->tipoUsuarioDao->findById($reg['tipo_usuario_id']));
            array_push($usuarios, $usuario);
        }

        return $usuarios;
    }

}