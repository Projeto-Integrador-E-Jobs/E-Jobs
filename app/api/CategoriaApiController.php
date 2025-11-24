<?php

require_once __DIR__ . '/../dao/CategoriaDAO.php';
require_once __DIR__ . '/../model/Categoria.php';

class CategoriaApiController
{
    public function handle()
    {
        $action = $_GET["action"] ?? "";

        switch ($action) {
            case "listar":
                $this->listar();
                break;

            case "save":
                $this->save();
                break;

            case "update":
                $this->update();
                break;

            case "delete":
                $this->delete();
                break;

            default:
                echo json_encode([
                    "success" => false,
                    "error" => "Ação inválida"
                ]);
        }
    }

    private function listar()
    {
        try {
            $dao = new CategoriaDAO();
            $categorias = $dao->list();

            $categoriasArray = array_map(function ($c) {
                return [
                    "id" => $c->getId(),
                    "nome" => $c->getNome(),
                    "icone" => $c->getIcone(),
                    "total_vagas" => $c->getTotalVagas()
                ];
            }, $categorias);

            echo json_encode([
                "success" => true,
                "categorias" => $categoriasArray
            ]);

        } catch (Exception $e) {
            echo json_encode([ "success" => false, "error" => "Erro ao listar categorias" ]);
        }
    }

    private function save()
    {
        try {
            $input = json_decode(file_get_contents("php://input"), true);

            $nome = trim($input["nome"] ?? "");
            $icone = trim($input["icone"] ?? "");

            if (empty($nome) || empty($icone)) {
                echo json_encode([
                    "success" => false,
                    "error" => "Nome e ícone são obrigatórios"
                ]);
                return;
            }

            $categoria = new Categoria();
            $categoria->setNome($nome);
            $categoria->setIcone($icone);

            $dao = new CategoriaDAO();
            $dao->insert($categoria);

            echo json_encode([
                "success" => true,
                "message" => "Categoria cadastrada com sucesso"
            ]);

        } catch (Exception $e) {
            echo json_encode([ "success" => false, "error" => "Erro ao salvar" ]);
        }
    }

    private function update()
    {
        try {
            $input = json_decode(file_get_contents("php://input"), true);

            $id = $input["id"] ?? null;
            $nome = trim($input["nome"] ?? "");
            $icone = trim($input["icone"] ?? "");

            if (!$id || empty($nome) || empty($icone)) {
                echo json_encode([
                    "success" => false,
                    "error" => "Dados inválidos"
                ]);
                return;
            }

            $categoria = new Categoria();
            $categoria->setId($id);
            $categoria->setNome($nome);
            $categoria->setIcone($icone);

            $dao = new CategoriaDAO();
            $dao->update($categoria);

            echo json_encode([
                "success" => true,
                "message" => "Categoria atualizada com sucesso"
            ]);

        } catch (Exception $e) {
            echo json_encode([ "success" => false, "error" => "Erro ao atualizar" ]);
        }
    }

    private function delete()
    {
        try {
            $input = json_decode(file_get_contents("php://input"), true);
            $id = $input["id"] ?? null;

            if (!$id) {
                echo json_encode([
                    "success" => false,
                    "error" => "ID inválido"
                ]);
                return;
            }

            $dao = new CategoriaDAO();
            $dao->deleteById($id);

            echo json_encode([
                "success" => true,
                "message" => "Categoria excluída com sucesso"
            ]);

        } catch (Exception $e) {
            echo json_encode([ "success" => false, "error" => "Erro ao excluir" ]);
        }
    }
}

$controller = new CategoriaApiController();
$controller->handle();
