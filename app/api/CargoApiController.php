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

            case "update":
                $this->update();
                break;


            case "save":
                $this->save();
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
            $dao = new CargoDAO();
            $cargos = $dao->list();

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

    private function delete()
    {
        try {
            $input = json_decode(file_get_contents("php://input"), true);
            $id = $input["id"] ?? null;

            if (!$id) {
                echo json_encode([
                    "success" => false,
                    "error" => "ID não informado"
                ]);
                return;
            }

            $dao = new CargoDAO();
            $dao->deleteById($id);

            echo json_encode([
                "success" => true,
                "message" => "Cargo excluído com sucesso"
            ]);
        } catch (Exception $e) {
            echo json_encode([
                "success" => false,
                "error" => "Erro ao excluir cargo"
            ]);
        }
    }

    private function update()
    {
        try {
            $input = json_decode(file_get_contents("php://input"), true);

            $id = $input["id"] ?? null;
            $nome = trim($input["nome"] ?? "");

            if (!$id || empty($nome)) {
                echo json_encode([
                    "success" => false,
                    "error" => "ID ou nome inválidos"
                ]);
                return;
            }

            $cargo = new Cargo();
            $cargo->setId($id);
            $cargo->setNome($nome);

            $dao = new CargoDAO();
            $dao->update($cargo);

            echo json_encode([
                "success" => true,
                "message" => "Cargo atualizado com sucesso"
            ]);
        } catch (Exception $e) {
            echo json_encode([
                "success" => false,
                "error" => "Erro ao atualizar cargo"
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
