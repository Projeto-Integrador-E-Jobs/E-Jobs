<?php
require_once(__DIR__ . "/ApiController.php");
require_once(__DIR__ . "/../dao/NotificacaoDAO.php");
require_once(__DIR__ . "/../model/Notificacao.php");



class NotificacaoApiController extends ApiController{

    private NotificacaoDAO $notificacaoDao;

    public function __construct()
    {
        $action = $_GET["action"];
        $allowedActions = ["listar"];

        // if (!in_array($action, $allowedActions) && !$this->usuarioLogado()) {
        //     header("location: " . BASEURL . "/controller/LoginController.php?action=login");
        //     exit;
        // }

        header('Content-Type: application/json; charset=utf-8');
        $this->notificacaoDao = new NotificacaoDAO();
     

        $this->handleAction();
    }

    public function listar()
    {
        // Inicia a sessão (caso ainda não tenha sido iniciada)
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

       
        $usuarioLogado = $_SESSION['usuario'] ?? null;
        $idDestino = $usuarioLogado->getTipoUsuario()->getId();


        
        if ($idDestino) {
            $notificacoes = $this->notificacaoDao->list($idDestino);
        } else {
            $this->jsonResponse([
                "success" => false,
                "errors" => ["ID não informado."]
            ]);
            return;
        }

        // Monta o array de resposta
        $response = [];
        foreach ($notificacoes as $notitificacao) {
            $response[] = [
                'id'         => $notitificacao->getId(),
                'id_origem'     => $notitificacao->getOrigem()->getId(),
                'nome_origem'     => $notitificacao->getOrigem()->getNome(),
                'id_destino'     => $notitificacao->getDestino()->getId(),
                'nome_destino'     => $notitificacao->getDestino()->getNome(),
                'tipo' => $notitificacao->getTipo(),
                'mensagem'    => $notitificacao->getMensagem(),
                'id_vaga'     => $notitificacao->getVaga()->getId(),
                'titulo_vaga'     => $notitificacao->getVaga()->getTitulo(),
                'lida'    => $notitificacao->getLida(),
                'data_criacao'  => $notitificacao->getDataCriacao(),
                
            ];
        }

        echo json_encode($response);
    }

}