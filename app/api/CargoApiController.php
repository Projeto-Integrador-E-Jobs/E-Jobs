<?php

require_once __DIR__ . '/../dao/CargoDAO.php';
require_once __DIR__ . '/../model/Cargo.php';

class CargoApiController
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
                echo json_encode([
                    "success" => false,
                    "error" => "Ação inválida"
                ]);
        }
    }

    private function listar()
    {
        try {
            $dao = new CargoDAO();
            $cargos = $dao->list();

            // 👇 Converte objetos Cargo em arrays
            $cargosArray = array_map(function ($cargo) {
                return [
                    "id" => $cargo->getId(),
                    "nome" => $cargo->getNome()
                ];
            }, $cargos);

            echo json_encode([
                "success" => true,
                "cargos" => $cargosArray
            ]);
        } catch (Exception $e) {
            echo json_encode([
                "success" => false,
                "error" => "Erro ao listar cargos"
            ]);
        }
    }

    private function save()
    {
        try {
            $input = json_decode(file_get_contents("php://input"), true);

            $nome = trim($input["nome"] ?? "");

            if (empty($nome)) {
                echo json_encode([
                    "success" => false,
                    "error" => "O nome do cargo é obrigatório"
                ]);
                return;
            }

            $cargo = new Cargo();
            $cargo->setNome($nome);

            $dao = new CargoDAO();
            $dao->insert($cargo);

            echo json_encode([
                "success" => true,
                "message" => "Cargo cadastrado com sucesso"
            ]);
        } catch (Exception $e) {
            echo json_encode([
                "success" => false,
                "error" => "Erro ao salvar cargo"
            ]);
        }
    }
}

$controller = new CargoApiController();
$controller->handle();
