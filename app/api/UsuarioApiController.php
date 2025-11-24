<?php
ob_clean();        
ob_start();             
error_reporting(0);      
ini_set('display_errors', 0);

header("Content-Type: application/json; charset=UTF-8");

require_once(__DIR__ . "/../dao/UsuarioDAO.php");
require_once(__DIR__ . "/../model/Usuario.php");

$usuarioDAO = new UsuarioDAO();

if ($_GET["action"] === "update") {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!$data || !isset($data["id"])) {
        echo json_encode(["success" => false, "errors" => ["Dados inválidos."]]);
        exit;
    }

    try {
        $usuarioAtual = $usuarioDAO->findById($data["id"]);
        if (!$usuarioAtual) {
            echo json_encode(["success" => false, "errors" => ["Usuário não encontrado."]]);
            exit;
        }

        // Preservar o email atual se não vier no JSON
        $email = isset($data["email"]) && !empty($data["email"])
            ? $data["email"]
            : $usuarioAtual->getEmail();

        $usuario = new Usuario();
        $usuario->setId($data["id"]);
        $usuario->setNome($data["nome"]);
        $usuario->setEmail($email); 
        $usuario->setDocumento($data["documento"]);
        $usuario->setTelefone($data["telefone"]);

        $usuarioDAO->update($usuario);

        ob_clean();

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
