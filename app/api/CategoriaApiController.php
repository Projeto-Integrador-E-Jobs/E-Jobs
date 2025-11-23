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

            default:
                echo json_encode(["success" => false, "error" => "Ação inválida"]);
        }
    }

    private function listar()
    {
        try {
            $dao = new CategoriaDAO();
            $categorias = $dao->list();

            $categoriasArray = array_map(function ($categoria) {
                return [
                    "id" => $categoria->getId(),
                    "nome" => $categoria->getNome(),
                    "icone" => $categoria->getIcone(),
                    "total_vagas" => $categoria->getTotalVagas()
                ];
            }, $categorias);

            echo json_encode([
                "success" => true,
                "categorias" => $categoriasArray
            ]);
        } catch (Exception $e) {
            echo json_encode([
                "success" => false,
                "error" => "Erro ao listar categorias"
            ]);
        }
    }


    private function save()
    {
        $input = json_decode(file_get_contents("php://input"), true);

        $nome = $input["nome"] ?? null;
        $icone = $input["icone"] ?? null;

        if (!$nome || !$icone) {
            echo json_encode(["success" => false, "error" => "Campos obrigatórios"]);
            return;
        }

        $categoria = new Categoria();
        $categoria->setNome($nome);
        $categoria->setIcone($icone);

        $dao = new CategoriaDAO();
        $dao->insert($categoria);

        echo json_encode([
            "success" => true,
            "message" => "Categoria criada com sucesso"
        ]);
    }
}

$controller = new CategoriaApiController();
$controller->handle();
