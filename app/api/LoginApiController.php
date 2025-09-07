<?php
require_once __DIR__ . "/../dao/UsuarioDAO.php";
require_once __DIR__ . "/../model/Usuario.php";
require_once __DIR__ . "/../model/TipoUsuario.php";


header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=utf-8");

class LoginApiController {
    private $usuarioDAO;

    public function __construct() {
        $this->usuarioDAO = new UsuarioDAO();
    }

    public function login() {

        $input = json_decode(file_get_contents("php://input"), true);

        $email = $input["email"] ?? null;
        $senha = $input["senha"] ?? null;

        if (!$email || !$senha) {
            http_response_code(400);
            echo json_encode(["error" => "E-mail e senha são obrigatórios"]);
            return;
        }

        try {
            $usuario = $this->usuarioDAO->findByLoginSenha($email, $senha);

            if ($usuario) {
                echo json_encode([
                    "success" => true,
                    "usuario" => [
                        "id"    => $usuario->getId(),
                        "nome"  => $usuario->getNome(),
                        "email" => $usuario->getEmail(),
                        "tipo"  => $usuario->getTipoUsuario()->getNome(), 
                        "status"=> $usuario->getStatus()
                    ]
                ]);
            } else {
                http_response_code(401);
                echo json_encode(["error" => "E-mail ou senha inválidos"]);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                "error" => "Erro no login",
                "details" => $e->getMessage()
            ]);
        }
    }
}

$action = $_GET['action'] ?? null;
$controller = new LoginApiController();

if ($action === "login") {
    $controller->login();
} else {
    http_response_code(400);
    echo json_encode(["error" => "Ação inválida"]);
}
