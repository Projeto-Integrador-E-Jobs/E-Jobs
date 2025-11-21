<?php
include_once(__DIR__ . "/../connection/Connection.php");
include_once(__DIR__ . "/../dao/UsuarioDAO.php");
include_once(__DIR__ . "/../dao/VagaDAO.php");
include_once(__DIR__ . "/../model/Usuario.php");
include_once(__DIR__ . "/../model/Vaga.php");
include_once(__DIR__ . "/../model/Notificacao.php");

class NotificacaoDAO{

    private UsuarioDAO $usuarioDao;
    private VagaDAO $vagaDao;

      public function __construct()
    {

        $this->usuarioDao = new UsuarioDAO();
        $this->vagaDao = new VagaDAO();
    }

    public function insert(Notificacao $notificacao)
    {
        $conn = Connection::getConn();

        $sql = "INSERT INTO notificacao (id_origem, id_destino, tipo, mensagem,
         id_vaga)" .
            " VALUES (:id_origem, :id_destino, :tipo, :mensagem, :id_vaga)";

        $stm = $conn->prepare($sql);
        $stm->bindValue("id_origem", $notificacao->getOrigem()->getId());
        $stm->bindValue("id_destino", $notificacao->getDestino()->getId());
        $stm->bindValue("tipo", $notificacao->getTipo());
        $stm->bindValue("mensagem", $notificacao->getMensagem());
        $stm->bindValue("id_vaga", $notificacao->getVaga()->getId());

        $stm->execute();
    }

    public function list($idDestino)
    {
        $conn = Connection::getConn();

        $sql = "SELECT n.* FROM notificacao n 
                WHERE  id_destino = :id_destino";
        $stm = $conn->prepare($sql);
        $stm->bindValue("id_destino", $idDestino);
        $stm->execute();
        $result = $stm->fetchAll();

        return $this->mapNotificacoes($result);
    }


      private function mapNotificacoes($result)
    {
        $notificacoes = array();
        foreach ($result as $reg) {
            $notificacao = new Notificacao();
            $notificacao->setId($reg['id']);
            $notificacao->setTipo($reg['tipo']);
            $notificacao->setMensagem($reg['mensagem']);
            $notificacao->setVaga($this->vagaDao->findById($reg['id_vaga']));
            $notificacao->setLida($reg['lida']);
            $notificacao->setDataCriacao($reg['data_criacao']);           
            $notificacao->setOrigem($this->usuarioDao->findById($reg['id_origem']));
            $notificacao->setDestino($this->usuarioDao->findById($reg['id_destino']));
            
            array_push($notificacoes, $notificacao);
        }

        return $notificacoes;
    }
}