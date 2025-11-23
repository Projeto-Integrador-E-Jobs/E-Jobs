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

        $sql = "SELECT 
                n.id,
                n.id_origem,
                u1.nome AS nome_origem,
                n.id_destino,
                u2.nome AS nome_destino,
                n.tipo,
                n.mensagem,
                n.id_vaga,
                v.titulo AS titulo_vaga,
                n.lida,
                n.data_criacao
            FROM notificacao n
            JOIN usuario u1 ON u1.id = n.id_origem
            JOIN usuario u2 ON u2.id = n.id_destino
            JOIN vaga v ON v.id = n.id_vaga
            WHERE n.id_destino = :id_destino
            ORDER BY n.data_criacao DESC";
        $stm = $conn->prepare($sql);
        $stm->bindValue("id_destino", $idDestino);
        $stm->execute();
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);

        return $this->mapNotificacoes($result);
    }

    public function findById(int $id)
    {
        $conn = Connection::getConn();

        $sql = "SELECT 
                    n.id,
                    n.id_origem,
                    u1.nome AS nome_origem,
                    n.id_destino,
                    u2.nome AS nome_destino,
                    n.tipo,
                    n.mensagem,
                    n.id_vaga,
                    v.titulo AS titulo_vaga,
                    n.lida,
                    n.data_criacao
                FROM notificacao n
                JOIN usuario u1 ON u1.id = n.id_origem
                JOIN usuario u2 ON u2.id = n.id_destino
                JOIN vaga v ON v.id = n.id_vaga
                WHERE n.id = :id";

        $stm = $conn->prepare($sql);
        $stm->bindValue(":id", $id, PDO::PARAM_INT);
        $stm->execute();

        $result = $stm->fetchAll();

        $notificacoes = $this->mapNotificacoes($result);

        if (count($notificacoes) == 1)
            return $notificacoes[0];
        elseif (count($notificacoes) == 0)
            return null;

        die("NotificacaoDAO.findById() - Erro: mais de uma notificação encontrada.");
    }

    public function deleteById(int $id)
    {
        $conn = Connection::getConn();
        $sql = "DELETE FROM notificacao WHERE id = :id";
        $stm = $conn->prepare($sql);
        $stm->bindValue(":id", $id, PDO::PARAM_INT);
        $stm->execute();

        return $stm->rowCount() > 0;
    }

    public function marcarLido($idNotificacao)
    {
        $conn = Connection::getConn();

        $sql = "UPDATE notificacao 
            SET lida = 1 
            WHERE id = :id";

        $stm = $conn->prepare($sql);
        $stm->bindValue(':id', $idNotificacao, PDO::PARAM_INT);
        return $stm->execute();
    }


    private function mapNotificacoes($result)
    {
        $notificacoes = array();
        foreach ($result as $reg) {

            $notificacao = new Notificacao();
            $origem = new Usuario();
            $destino = new Usuario();
            $vaga = new Vaga();

            $notificacao->setId($reg['id']);
            $notificacao->setTipo($reg['tipo']);
            $notificacao->setMensagem($reg['mensagem']);
            $notificacao->setLida($reg['lida']);
            $notificacao->setDataCriacao($reg['data_criacao']);
            $origem->setId($reg['id_origem']);
            $origem->setNome($reg['nome_origem']);
            $notificacao->setOrigem($origem);
            $destino->setId($reg['id_destino']);
            $destino->setNome($reg['nome_destino']);
            $notificacao->setDestino($destino);
            $vaga->setId($reg['id_vaga']);
            $vaga->setTitulo($reg['titulo_vaga']);
            $notificacao->setVaga($vaga);

            $notificacoes[] = $notificacao;
        }

        return $notificacoes;
    }
}