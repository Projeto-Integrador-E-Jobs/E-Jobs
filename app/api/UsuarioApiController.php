<?php
require_once(__DIR__ . "/../dao/UsuarioDAO.php");
require_once(__DIR__ . "/../model/Usuario.php");

header("Content-Type: application/json; charset=UTF-8");

$usuarioDAO = new UsuarioDAO();

if ($_GET["action"] === "update") {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!$data || !isset($data["id"])) {
        echo json_encode(["success" => false, "errors" => ["Dados inválidos."]]);
        exit;
    }

    try {
        $usuario = new Usuario();
        $usuario->setId($data["id"]);
        $usuario->setNome($data["nome"]);
        $usuario->setEmail($data["email"]);
        $usuario->setDocumento($data["documento"]);
        $usuario->setTelefone($data["telefone"]);

        $usuarioDAO->update($usuario);

        echo json_encode([
            "success" => true,
            "message" => "Usuário atualizado com sucesso.",
            "usuario" => [
                "id" => $usuario->getId(),
                "nome" => $usuario->getNome(),
                "email" => $usuario->getEmail(),
                "documento" => $usuario->getDocumento(),
                "telefone" => $usuario->getTelefone()
            ]
        ]);
    } catch (Exception $e) {
        echo json_encode(["success" => false, "errors" => [$e->getMessage()]]);
    }
}
?>
