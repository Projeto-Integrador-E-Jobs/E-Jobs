<?php
require_once(__DIR__ . "/ApiController.php");
require_once(__DIR__ . "/../dao/VagaDAO.php");
require_once(__DIR__ . "/../dao/UsuarioDAO.php");
require_once(__DIR__ . "/../dao/CargoDAO.php");
require_once(__DIR__ . "/../dao/CategoriaDAO.php");
require_once(__DIR__ . "/../dao/CandidaturaDAO.php");
require_once(__DIR__ . "/../service/VagaService.php");
require_once(__DIR__ . "/../model/Vaga.php");
require_once(__DIR__ . "/../model/Candidatura.php");
require_once(__DIR__ . "/../model/enum/Modalidade.php");
require_once(__DIR__ . "/../model/enum/Regime.php");
require_once(__DIR__ . "/../model/enum/Horario.php");
require_once(__DIR__ . "/../model/enum/Status.php");
require_once(__DIR__ . "/../model/enum/Salario.php");


class VagaApiController extends ApiController
{

    private VagaDAO $vagaDao;
    private UsuarioDAO $usuarioDao;
    private CargoDAO $cargoDao;
    private CategoriaDAO $categoriaDao;
    private CandidaturaDAO $candidaturaDao;
    private VagaService $vagaService;

    public function __construct()
    {
        $action = $_GET["action"];
        $allowedActions = ["listPublic", "viewVagas", "listar", "create"];

        // if (!in_array($action, $allowedActions) && !$this->usuarioLogado()) {
        //     header("location: " . BASEURL . "/controller/LoginController.php?action=login");
        //     exit;
        // }

        header('Content-Type: application/json; charset=utf-8');
        $this->vagaDao = new VagaDAO();
        $this->cargoDao = new CargoDAO();
        $this->usuarioDao = new UsuarioDAO();
        $this->candidaturaDao = new CandidaturaDAO();
        $this->categoriaDao = new CategoriaDAO();
        $this->vagaService = new VagaService();

        $this->handleAction();
    }


    // Listar todas as vagas
    public function listar()
{
    // Inicia a sessão (caso ainda não tenha sido iniciada)
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Verifica se há usuário logado e se ele é uma empresa
    //$usuarioLogado = $_SESSION['usuario'] ?? null;
    //$isEmpresa = $usuarioLogado->getTipoUsuario()->getNome() === 'empresa';


    // Se for empresa, mostra todas as vagas
    //if ($isEmpresa) {
      //  $vagas = $this->vagaDao->list();
    //} else {
        // Candidato ou visitante: mostra apenas vagas ativas
        $vagas = $this->vagaDao->listarAtivas();
    //}

    // Monta o array de resposta
    $response = [];
    foreach ($vagas as $vaga) {
        $response[] = [
            'id'         => $vaga->getId(),
            'titulo'     => $vaga->getTitulo(),
            'modalidade' => $vaga->getModalidade(),
            'horario'    => $vaga->getHorario(),
            'regime'     => $vaga->getRegime(),
            'salario'    => $vaga->getSalario(),
            'descricao'  => $vaga->getDescricao(),
            'requisitos' => $vaga->getRequisitos(),
            'status'     => $vaga->getStatus(),
            'empresa'    => $vaga->getEmpresa()->getNome(),
            'cargo'      => $vaga->getCargo()->getNome(),
            'categoria'  => $vaga->getCategoria()->getNome()
        ];
    }

    echo json_encode($response);
}



    protected function detalhes()
    {
        $id = $_GET["id"] ?? null;

        if (!$id || !ctype_digit((string)$id)) {
            $this->jsonResponse(["success" => false, "errors" => ["ID da vaga não informado ou inválido."]], 400);
            return;
        }

        $vaga = $this->vagaDao->findById((int)$id);

        if (!$vaga) {
            $this->jsonResponse(["success" => false, "errors" => ["Vaga não encontrada."]], 404);
            return;
        }


        $empresa   = $vaga->getEmpresa();
        $cargo     = $vaga->getCargo();
        $categoria = $vaga->getCategoria();

        $payload = [
            'id'         => $vaga->getId(),
            'titulo'     => $vaga->getTitulo(),
            'modalidade' => $vaga->getModalidade(),
            'horario'    => $vaga->getHorario(),
            'regime'     => $vaga->getRegime(),
            'salario'    => $vaga->getSalario(),
            'descricao'  => $vaga->getDescricao(),
            'requisitos' => $vaga->getRequisitos(),
            'status'     => $vaga->getStatus(),
            'empresa'    => $empresa   ? $empresa->getNome()   : "",
            'cargo'      => $cargo     ? $cargo->getNome()     : "",
            'categoria'  => $categoria ? $categoria->getNome() : "",
        ];

        $this->jsonResponse($payload);
    }


    protected function create()
    {
        $input = json_decode(file_get_contents("php://input"), true);
        $idEmpresa = $input["usuarioId"] ?? ($_GET["id"] ?? null);

        if (!$idEmpresa) {
            $this->jsonResponse([
                "success" => false,
                "errors" => ["ID da empresa não informado."]
            ]);
            return;
        }

        $usuario = $this->usuarioDao->findById($idEmpresa);

        if (!$usuario) {
            $this->jsonResponse([
                "success" => false,
                "errors" => ["Empresa não encontrada."]
            ]);
            return;
        }

        $modalidades = Modalidade::getAllAsArray();
        $horarios = Horario::getAllAsArray();
        $regimes = Regime::getAllAsArray();
        $status = Status::getAllAsArray();
        $cargos = $this->cargoDao->list();
        $categorias = $this->categoriaDao->list();

        $cargosArray = array_map(fn($e) => [
            "id" => $e->getId(),
            "nome" => $e->getNome()
        ], $cargos);

        $categoriasArray = array_map(fn($p) => [
            "id" => $p->getId(),
            "nome" => $p->getNome()
        ], $categorias);

        $empresaArray = [
            "id" => $usuario->getId(),
            "nome" => $usuario->getNome()
        ];

        $this->jsonResponse([
            "success" => true,
            "id" => 0,
            "modalidades" => $modalidades,
            "horarios" => $horarios,
            "regimes" => $regimes,
            "status" => $status,
            "cargos" => $cargosArray,
            "categorias" => $categoriasArray,
            "empresa" => $empresaArray
        ]);
    }
    protected function edit()
    {
        $id = $_GET["id"] ?? null;

        if (!$id || !ctype_digit((string)$id)) {
            $this->jsonResponse(["success" => false, "errors" => ["ID da vaga não informado."]], 400);
            return;
        }

        $vaga = $this->vagaDao->findById((int)$id);
        if (!$vaga) {
            $this->jsonResponse(["success" => false, "errors" => ["Vaga não encontrada."]], 404);
            return;
        }

        // 🔹 Dados relacionados
        $empresa   = $vaga->getEmpresa();
        $cargo     = $vaga->getCargo();
        $categoria = $vaga->getCategoria();

        // 🔹 Retorna tudo o que o app precisa para edição
        $this->jsonResponse([
            "success" => true,
            "vaga" => [
                "id"          => $vaga->getId(),
                "titulo"      => $vaga->getTitulo(),
                "modalidade"  => $vaga->getModalidade(),
                "horario"     => $vaga->getHorario(),
                "regime"      => $vaga->getRegime(),
                "salario"     => $vaga->getSalario(),
                "descricao"   => $vaga->getDescricao(),
                "requisitos"  => $vaga->getRequisitos(),
                "status"      => $vaga->getStatus(),
                "cargo_id"    => $cargo ? $cargo->getId() : null,
                "categoria_id" => $categoria ? $categoria->getId() : null,
                "empresa_id"  => $empresa ? $empresa->getId() : null
            ],
            "modalidades" => Modalidade::getAllAsArray(),
            "horarios"    => Horario::getAllAsArray(),
            "regimes"     => Regime::getAllAsArray(),
            "status"      => Status::getAllAsArray(),
            "cargos"      => array_map(fn($c) => ["id" => $c->getId(), "nome" => $c->getNome()], $this->cargoDao->list()),
            "categorias"  => array_map(fn($cat) => ["id" => $cat->getId(), "nome" => $cat->getNome()], $this->categoriaDao->list())
        ]);
    }




    protected function save()
    {

        // if (isset($_SESSION[SESSAO_USUARIO_PAPEL]) && $_SESSION[SESSAO_USUARIO_PAPEL] == 1) {
        //     header("Location: " . BASEURL . "/controller/VagaController.php?action=listPublic");
        //     exit;
        // }

        $input = json_decode(file_get_contents("php://input"), true);
        $dados["id"] = isset($input['id']) ? $input['id'] : 0;
        $titulo = trim($input['titulo']) ? trim($input['titulo']) : NULL;
        $modalidade = trim($input['modalidade']) ? trim($input['modalidade']) : NULL;
        $horario = trim($input['horario']) ? trim($input['horario']) : NULL;
        $regime = trim($input['regime']) ? trim($input['regime']) : NULL;
        $salario = trim($input['salario']) ? trim($input['salario']) : NULL;
        $descricao = trim($input['descricao']) ? trim($input['descricao']) : NULL;
        $requisitos = trim($input['requisitos']) ? trim($input['requisitos']) : NULL;
        $status = trim($input['status']) ? trim($input['status']) : Status::ATIVO;
        $cargoId = isset($input['cargo']) && is_numeric($input['cargo']) && (int)$input['cargo'] > 0 ? (int)$input['cargo'] : NULL;
        $cargo = $cargoId !== null ? $this->cargoDao->findById($cargoId) : NULL;
        $categoriaId = isset($input['categoria']) && is_numeric($input['categoria']) && (int)$input['categoria'] > 0 ? (int)$input['categoria'] : NULL;
        $categoria = $categoriaId !== null ? $this->categoriaDao->findById($categoriaId) : NULL;
        $usuarioId = isset($input['usuarioId']) && is_numeric($input['usuarioId']) ? (int)$input['usuarioId'] : NULL;
        $empresa = $usuarioId ? $this->usuarioDao->findById($usuarioId) : null;

        $vaga = new Vaga();
        $vaga->setTitulo($titulo);
        $vaga->setModalidade($modalidade);
        $vaga->setHorario($horario);
        $vaga->setRegime($regime);
        $vaga->setSalario($salario);
        $vaga->setDescricao($descricao);
        $vaga->setRequisitos($requisitos);
        $vaga->setStatus($status);
        $vaga->setCargo($cargo);
        $vaga->setCategoria($categoria);
        $vaga->setEmpresa($empresa);



        $erros = $this->vagaService->validarDados($vaga);
        if (empty($erros)) {

            try {

                if ($dados["id"] == 0) {
                    $this->vagaDao->insert($vaga);
                    $msg = "Vaga salva com sucesso.";
                    $this->jsonResponse([
                        "success" => true,
                        "mensagem" => $msg
                    ]);
                    exit;
                } else {
                    $vaga->setId($dados["id"]);
                    $this->vagaDao->update($vaga);

                    $msg = "Vaga salva com sucesso.";
                    $this->jsonResponse([
                        "success" => true,
                        "mensagem" => $msg
                    ]);
                    exit;
                }
            } catch (PDOException $e) {
                $erros = ["Erro ao salvar a vaga na base de dados.", $e];
            }
        }

        $valoresVaga = [
            "titulo" => $vaga->getTitulo() ?? "",
            "modalidade" => $vaga->getModalidade() ?? "",
            "horario" => $vaga->getHorario() ?? "",
            "regime" => $vaga->getRegime() ?? "",
            "salario" => $vaga->getSalario() ?? "",
            "descricao" => $vaga->getDescricao() ?? "",
            "requisitos" => $vaga->getRequisitos() ?? "",
            "status" => $vaga->getStatus() ?? "",
            "cargo" => $vaga->getCargo() ?? "",
            "categoria" => $vaga->getCategoria() ?? "",
        ];

        $dados["vaga"] = $valoresVaga;
        $dados["modalidades"] = Modalidade::getAllAsArray();
        $dados["horarios"] = Horario::getAllAsArray();
        $dados["regimes"] = Regime::getAllAsArray();
        $dados["cargos"] = $this->cargoDao->list();
        $dados["empresa"] = $this->usuarioDao->findById($vaga->getEmpresa()->getId());

        $this->jsonResponse([
            "success" => false,
            "errors" => $erros,
            "dados" => $dados
        ], 400);
    }
   protected function alterarStatus()
{
    $id = $_GET["id"] ?? null;

    if (!$id || !ctype_digit((string)$id)) {
        $this->jsonResponse([
            "success" => false,
            "errors" => ["ID da vaga inválido."]
        ], 400);
        return;
    }

    try {
        $vaga = $this->vagaDao->findById((int)$id);

        if (!$vaga) {
            $this->jsonResponse([
                "success" => false,
                "errors" => ["Vaga não encontrada."]
            ], 404);
            return;
        }

        // Alterna o status da vaga
        $novoStatus = ($vaga->getStatus() === "Ativo") ? "Inativo" : "Ativo";
        $vaga->setStatus($novoStatus);
        $this->vagaDao->update($vaga);

        $mensagem = $novoStatus === "Ativo"
            ? "Vaga reativada com sucesso!"
            : "Vaga inativada com sucesso!";

        $this->jsonResponse([
            "success" => true,
            "message" => $mensagem,
            "novoStatus" => $novoStatus
        ]);
    } catch (Exception $e) {
        $this->jsonResponse([
            "success" => false,
            "errors" => ["Erro ao alterar status: " . $e->getMessage()]
        ]);
    }
}



    protected function usuarioLogado()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        return isset($_SESSION[SESSAO_USUARIO_ID]);
    }

    protected function listarPorEmpresa()
    {
        $idEmpresa = $_GET["id"] ?? null;

        if (!$idEmpresa) {
            $this->jsonResponse([
                "success" => false,
                "errors" => ["ID da empresa não informado."]
            ]);
            return;
        }

        $vagas = $this->vagaDao->findByEmpresa($idEmpresa);
        $vagasArray = [];

        foreach ($vagas as $vaga) {
            $vagasArray[] = [
                "id" => $vaga->getId(),
                "titulo" => $vaga->getTitulo(),
                "salario" => $vaga->getSalario(),
                "horario" => $vaga->getHorario(),
                "status" => $vaga->getStatus(),
            ];
        }

        $this->jsonResponse([
            "success" => true,
            "vagas" => $vagasArray
        ]);
    }
}
new VagaApiController();