<?php
# Classe controller padrão para API
require_once(__DIR__ . "/../util/config.php");

class ApiController {

    // Método que processa a ação enviada via GET (?action=...)
    protected function handleAction() {
        $action = $_GET['action'] ?? null;

        if ($action && method_exists($this, $action)) {
            $this->$action();
        } else {
            $this->jsonResponse(
                ["error" => "Ação inválida ou não encontrada."],
                400
            );
        }
    }

    // Resposta padrão em JSON
    protected function jsonResponse($data, int $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
        exit;
    }

    // Verifica se o usuário está logado via sessão (opcional)
    protected function usuarioLogado() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION[SESSAO_USUARIO_ID])) {
            $this->jsonResponse(
                ["error" => "Usuário não autenticado."],
                401
            );
        }
    }
}
