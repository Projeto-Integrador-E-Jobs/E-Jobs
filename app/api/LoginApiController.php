<?php
require_once(__DIR__ . "/ApiController.php");

require_once(__DIR__ . "/../dao/UsuarioDAO.php");
require_once(__DIR__ . "/../service/LoginService.php");
require_once(__DIR__ . "/../model/Usuario.php");
require_once(__DIR__ . "/../model/TipoUsuario.php");
require_once(__DIR__ . "/../model/enum/Status.php");

class LoginApiController extends ApiController
{
    private LoginService $loginService;
    private UsuarioDAO $usuarioDao;

    public function __construct()
    {
        $this->loginService = new LoginService();
        $this->usuarioDao = new UsuarioDAO();
        $this->handleAction();
    }

    protected function logon()
    {
        $input = json_decode(file_get_contents("php://input"), true);
        $email = isset($input['email']) ? trim($input['email']) : null;
        $senha = isset($input['senha']) ? trim($input['senha']) : null;


        $erros = $this->loginService->validarCampos($email, $senha);
        if (empty($erros)) {
            $usuario = $this->usuarioDao->findByLoginSenha($email, $senha);
            if ($usuario) {
                if ($usuario->getStatus() === Status::ATIVO) {
                    session_start();
                    $_SESSION['usuario_id'] = $usuario->getId();

                    $this->jsonResponse([
                        "success" => true,
                        "usuario" => [
                            "id" => $usuario->getId(),
                            "nome" => $usuario->getNome(),
                            "email" => $usuario->getEmail(),
                            "tipo" => $usuario->getTipoUsuario()->getId(),
                            "telefone" => $usuario->getTelefone(),
                            "documento" => $usuario->getDocumento(),
                            "descricao" => $usuario->getDescricao()
                        ]
                    ]);
                }
            }
            $erros[] = "Usuário inválido ou inativo.";
        }

        $this->jsonResponse([
            "success" => false,
            "errors" => $erros
        ], 401);
    }

    protected function logout()
    {
        session_start();
        session_destroy();

        $this->jsonResponse(["success" => true, "message" => "Logout efetuado."]);
    }
}

new LoginApiController();
