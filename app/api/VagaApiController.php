<?php
require_once __DIR__ . "/../dao/VagaDAO.php";
require_once __DIR__ . "/../model/Vaga.php";

class VagaApiController {
    private $vagaDAO;

    public function __construct() {
        $this->vagaDAO = new VagaDAO();
        header('Content-Type: application/json; charset=utf-8');
    }

    // Listar todas as vagas
    public function listar() {
        $vagas = $this->vagaDAO->list();

        $response = [];
        foreach ($vagas as $vaga) {
            $response[] = [
                'id'        => $vaga->getId(),
                'titulo'    => $vaga->getTitulo(),
                'modalidade'=> $vaga->getModalidade(),
                'horario'   => $vaga->getHorario(),
                'regime'    => $vaga->getRegime(),
                'salario'   => $vaga->getSalario(),
                'descricao' => $vaga->getDescricao(),
                'requisitos'=> $vaga->getRequisitos(),
                'status'    => $vaga->getStatus(),
                'empresa'   => $vaga->getEmpresa()->getNome(),
                'cargo'     => $vaga->getCargo()->getNome(),
                'categoria' => $vaga->getCategoria()->getNome()
            ];
        }

        echo json_encode($response);
    }


    public function detalhes($id) {
        $vaga = $this->vagaDAO->findById($id); 

        if (!$vaga) {
            http_response_code(404);
            echo json_encode(['error' => 'Vaga não encontrada']);
            return;
        }

        $response = [
            'id'        => $vaga->getId(),
            'titulo'    => $vaga->getTitulo(),
            'modalidade'=> $vaga->getModalidade(),
            'horario'   => $vaga->getHorario(),
            'regime'    => $vaga->getRegime(),
            'salario'   => $vaga->getSalario(),
            'descricao' => $vaga->getDescricao(),
            'requisitos'=> $vaga->getRequisitos(),
            'status'    => $vaga->getStatus(),
            'empresa'   => $vaga->getEmpresa()->getNome(),
            'cargo'     => $vaga->getCargo()->getNome(),
            'categoria' => $vaga->getCategoria()->getNome()
        ];

        echo json_encode($response);
    }
}

$action = $_GET['action'] ?? null;
$controller = new VagaApiController();

if ($action === 'listar') {
    $controller->listar();
} elseif ($action === 'detalhes') {
    $id = $_GET['id'] ?? null;
    if ($id) {
        $controller->detalhes($id);
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'ID da vaga não informado']);
    }
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Ação inválida']);
}
