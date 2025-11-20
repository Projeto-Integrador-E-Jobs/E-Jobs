<?php
require_once(__DIR__ . "/ApiController.php");
require_once(__DIR__ . "/../dao/CandidaturaDAO.php");
require_once(__DIR__ . "/../model/Candidatura.php");
require_once(__DIR__ . "/../model/Usuario.php");
require_once(__DIR__ . "/../model/Vaga.php");

class CandidaturaApiController extends ApiController
{
    private CandidaturaDAO $candidaturaDao;
    private UsuarioDAO $usuarioDao;
    private CandidaturaDAO $dao;

    public function __construct()
    {
        $allowedActions = ["aprovar, listarPorVaga"];

        $this->dao = new CandidaturaDAO();
        $this->handleAction();
    }

    protected function candidatar()
    {
        $input = json_decode(file_get_contents("php://input"), true);
        $idUsuario = $input["id_usuario"] ?? null;
        $idVaga = $input["id_vaga"] ?? null;

        if (!$idUsuario || !$idVaga) {
            $this->jsonResponse(["success" => false, "errors" => ["Parâmetros inválidos."]]);
            return;
        }

        $jaExiste = $this->dao->findByCandidatoAndVaga($idUsuario, $idVaga);
        if ($jaExiste) {
            $this->jsonResponse([
                "success" => false,
                "errors" => ["Você já se candidatou a esta vaga."],
                "jaCandidatado" => true
            ]);
            return;
        }

        try {
            $candidato = new Usuario();
            $candidato->setId($idUsuario);

            $vaga = new Vaga();
            $vaga->setId($idVaga);

            $candidatura = new Candidatura();
            $candidatura->setCandidato($candidato);
            $candidatura->setVaga($vaga);
            $candidatura->setStatus("EM_ANDAMENTO");

            $this->dao->insert($candidatura);

            $this->jsonResponse([
                "success" => true,
                "message" => "Candidatura registrada com sucesso!"
            ]);
        } catch (Exception $e) {
            $this->jsonResponse([
                "success" => false,
                "errors" => ["Erro ao salvar no banco: " . $e->getMessage()]
            ]);
        }
    }

    protected function verificar()
    {
        $idUsuario = $_GET["id_usuario"] ?? null;
        $idVaga = $_GET["id_vaga"] ?? null;

        if (!$idUsuario || !$idVaga) {
            $this->jsonResponse(["success" => false, "errors" => ["Parâmetros inválidos."]]);
            return;
        }

        $jaExiste = $this->dao->findByCandidatoAndVaga($idUsuario, $idVaga);
        $this->jsonResponse(["success" => true, "jaCandidatado" => (bool)$jaExiste]);
    }

    protected function minhasCandidaturas(string $msgErro = "", string $msgSucesso = "")
    {
        // if (!$this->usuarioLogado()) {
        //     header("location: " . BASEURL . "/controller/LoginController.php?action=login");
        //     exit;
        // }

        $input = json_decode(file_get_contents("php://input"), true);
        $idUsuario = $input["id_usuario"] ?? null;
        $candidaturas = $this->dao->findByCandidato($idUsuario);

        $response = [];
        foreach ($candidaturas as $candidatura) {
            $response[] = [
                'id'         => $candidatura->getId(),
                'candidato_id'     => $candidatura->getCandidato()->getId(),
                'vaga_id' => $candidatura->getVaga()->getId(),
                'vaga_titulo' => $candidatura->getVaga()->getTitulo(),
                'empresa' => $candidatura->getVaga()->getEmpresa()->getNome(),
                'vaga_cargo' => $candidatura->getVaga()->getCargo()->getNome(),
                'data_candidatura'    => $candidatura->getDataCandidatura(),
                'status'     => $candidatura->getStatus(),

            ];
        }

        echo json_encode($response);
    }

    protected function cancelarCandidatura()
    {
        $input = json_decode(file_get_contents("php://input"), true);
        $idCandidatura = $input["id_candidatura"] ?? null;

        if (!$idCandidatura) {
            echo json_encode([
                'success' => false,
                'message' => 'ID da candidatura não informado.'
            ]);
            return;
        }
        $delete = $this->dao->deleteById($idCandidatura);
        echo json_encode([
            'success' => $delete,
            'message' => $delete
                ? 'Candidatura cancelada com sucesso.'
                : 'Nenhuma candidatura encontrada com esse ID.'
        ]);
    }

    protected function listarPorVaga()
    {
        if (!isset($_GET['id_vaga'])) {
            echo json_encode(['success' => false, 'errors' => ['ID da vaga não informado.']]);
            return;
        }

        $idVaga = $_GET['id_vaga'];
        $dao = new CandidaturaDAO();
        $candidatos = $dao->listByVaga($idVaga);

        echo json_encode([
            'success' => true,
            'candidatos' => $candidatos
        ]);
    }

    protected function aprovar()
    {
        // Tenta ler pelo GET
        $id = $_GET["id"] ?? null;

        // Caso não venha via GET, tenta pelo corpo POST JSON
        if (!$id) {
            $input = json_decode(file_get_contents("php://input"), true);
            $id = $input["id"] ?? null;
        }

        if (!$id) {
            echo json_encode(["success" => false, "errors" => ["ID inválido"]]);
            return;
        }

        $ok = $this->dao->aprovar($id);

        if ($ok) {
            echo json_encode(["success" => true, "message" => "Candidato aprovado!"]);
        } else {
            echo json_encode(["success" => false, "errors" => ["Erro ao aprovar"]]);
        }
    }
}

new CandidaturaApiController();
