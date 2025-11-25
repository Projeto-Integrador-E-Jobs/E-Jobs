<?php
ob_clean();
ob_start();
error_reporting(0);
ini_set('display_errors', 0);

header("Content-Type: application/json; charset=UTF-8");

require_once(__DIR__ . "/../dao/UsuarioDAO.php");
require_once(__DIR__ . "/../model/Usuario.php");

$usuarioDAO = new UsuarioDAO();


if ($_GET["action"] === "listAllAdmin") {
    try {
        $usuarios = $usuarioDAO->list();

        $arr = array_map(function ($u) {
            return [
                "id" => $u->getId(),
                "nome" => $u->getNome(),
                "email" => $u->getEmail(),
                "documento" => $u->getDocumento(),
                "telefone" => $u->getTelefone(),
                "status" => $u->getStatus(),
                "tipo" => $u->getTipoUsuario()->getId()
            ];
        }, $usuarios);

        echo json_encode(["success" => true, "usuarios" => $arr]);
    } catch (Exception $e) {
        echo json_encode(["success" => false, "error" => $e->getMessage()]);
    }
    exit;
}

if ($_GET["action"] === "listarPendentes") {
    try {
        $usuarios = $usuarioDAO->listEmpresasPendentes();

        $arr = array_map(function ($u) {
            return [
                "id" => $u->getId(),
                "nome" => $u->getNome(),
                "email" => $u->getEmail(),
                "documento" => $u->getDocumento(),
                "telefone" => $u->getTelefone(),
                "status" => $u->getStatus(),
                "tipo" => $u->getTipoUsuario()->getId()
            ];
        }, $usuarios);

        echo json_encode(["success" => true, "usuarios" => $arr]);
    } catch (Exception $e) {
        echo json_encode(["success" => false, "error" => $e->getMessage()]);
    }
    exit;
}

if ($_GET["action"] === "aprovarEmpresa") {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data["id"])) {
        echo json_encode(["success" => false, "error" => "ID inválido"]);
        exit;
    }

    try {
        $usuario = $usuarioDAO->findById($data["id"]);
        if (!$usuario) {
            echo json_encode(["success" => false, "error" => "Empresa não encontrada"]);
            exit;
        }

        $usuarioDAO->alterarStatus($usuario->getId(), "Ativo");

        echo json_encode(["success" => true, "message" => "Empresa aprovada com sucesso"]);
    } catch (Exception $e) {
        echo json_encode(["success" => false, "error" => $e->getMessage()]);
    }

    exit;
}




if ($_GET["action"] === "alterarStatus") {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data["id"]) || !isset($data["status"])) {
        echo json_encode(["success" => false, "error" => "Dados inválidos"]);
        exit;
    }

    try {
        $usuarioDAO->alterarStatus($data["id"], $data["status"]);

        echo json_encode([
            "success" => true,
            "message" => "Status atualizado com sucesso",
            "status" => $data["status"]
        ]);
    } catch (Exception $e) {
        echo json_encode(["success" => false, "error" => $e->getMessage()]);
    }

    exit;
}


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
    exit;
}


echo json_encode(["success" => false, "error" => "Ação inválida"]);
exit;
