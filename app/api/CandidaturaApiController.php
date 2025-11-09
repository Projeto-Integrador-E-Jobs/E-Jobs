<?php
require_once(__DIR__ . "/ApiController.php");
require_once(__DIR__ . "/../dao/CandidaturaDAO.php");
require_once(__DIR__ . "/../model/Candidatura.php");
require_once(__DIR__ . "/../model/Usuario.php");
require_once(__DIR__ . "/../model/Vaga.php");

class CandidaturaApiController extends ApiController
{
    private CandidaturaDAO $dao;

    public function __construct()
    {
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
}

new CandidaturaApiController();
