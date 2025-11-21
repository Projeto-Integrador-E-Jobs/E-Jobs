<?php
include_once(__DIR__ . "/../dao/NotificacaoDAO.php");
include_once(__DIR__ . "/../model/Notificacao.php");
include_once(__DIR__ . "/../model/Usuario.php");
class NotificacaoService
{
    private NotificacaoDAO $notificacaoDao;

    public function __construct(NotificacaoDAO $notificacaoDao)
    {
        $this->notificacaoDao = $notificacaoDao;
    }

    public function criarNotificacao($origemId, $destinoId, $tipo, $mensagem, $vagaId)
    {
        $notificacao = new Notificacao();
        $usuarioOrigem = new Usuario();
        $usuarioOrigem->setId($origemId);
        $notificacao->setOrigem($usuarioOrigem);
        $usuarioDestino = new Usuario();
        $usuarioDestino->setId($destinoId);
        $notificacao->setDestino($usuarioDestino);
        $notificacao->setTipo($tipo);
        $notificacao->setMensagem($mensagem);
        $vaga = new Vaga();
        $vaga->setId($vagaId);
        $notificacao->setVaga($vaga);

        $this->notificacaoDao->insert($notificacao);
    }
}
