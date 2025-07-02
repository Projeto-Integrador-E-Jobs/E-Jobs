<?php
require_once(__DIR__ . "/Controller.php");
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


class VagaController extends Controller
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
        $allowedActions = ["listPublic", "viewVagas"];

        if (!in_array($action, $allowedActions) && !$this->usuarioLogado()) {
            header("location: " . BASEURL . "/controller/LoginController.php?action=login");
            exit;
        }


        $this->vagaDao = new VagaDAO();
        $this->cargoDao = new CargoDAO();
        $this->usuarioDao = new UsuarioDAO();
        $this->candidaturaDao = new CandidaturaDAO();
        $this->categoriaDao = new CategoriaDAO();
        $this->vagaService = new VagaService();

        $this->handleAction();
    }

    protected function listPublic(string $msgErro = "", string $msgSucesso = "")
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 12; 
        $offset = ($page - 1) * $limit;
        $totalPaginas = 1;

        $idCategoria = 0;
        if(isset($_GET["idCategoria"]))
            $idCategoria = $_GET["idCategoria"];
        $modalidade = "";
        if(isset($_GET["modalidade"]))
            $modalidade = $_GET["modalidade"];
        $cargaHoraria = "";
        if(isset($_GET["horario"]))
            $cargaHoraria = $_GET["horario"];
        $regime = "";
        if(isset($_GET["regime"]))
            $regime = $_GET["regime"];
        $salario = "";
        if(isset($_GET["salario"]))
            $salario = $_GET["salario"];
        $cargo = 0;
        if(isset($_GET["cargo_id"]))
            $cargo = $_GET["cargo_id"];
        $search = "";
        if(isset($_GET['search']))
            $search = trim($_GET['search']);
        $idCidade = 0;
        if(isset($_GET["cidade_id"]))
            $idCidade = (int) $_GET["cidade_id"];


        //monta url com os filtros
        $queryString = http_build_query([
            'idCategoria' => $idCategoria,
            'modalidade' => $modalidade,
            'horario' => $cargaHoraria,
            'regime' => $regime,
            'salario' => $salario,
            'cargo_id' => $cargo,
            'search' => $search,
            'cidade_id' => $idCidade
        ]);
        
        $vagas = $this->vagaDao->listByFiltros($search,$idCategoria,$modalidade,$cargaHoraria,$regime,$salario,$cargo, $limit, $offset, $idCidade);
        $totalVagas = $this->vagaDao->countFiltros($search, $idCategoria, $modalidade, $cargaHoraria, $regime, $salario, $cargo, $idCidade);
        $totalPaginas = ceil($totalVagas / $limit);
        
        $dados["lista"] = $vagas;
        $dados["search_term"] = $search;
        $dados["show_status_filter"] = false;
        $dados["modalidades"] = Modalidade::getAllAsArray();
        $dados["horarios"] = Horario::getAllAsArray();
        $dados["regimes"] = Regime::getAllAsArray();
        $dados["status"] = Status::getAllAsArray();
        $dados["cargos"] = $this->cargoDao->list();
        $dados["salarios"] = Salario::getAllAsArray();
        $dados["categorias"] = $this->categoriaDao->list();
        $dados["pagina_atual"] = $page;
        $dados["queryString"] = $queryString;
        $dados["total_paginas"] = $totalPaginas;

        $this->loadView("vaga/vagaPublica_list.php", $dados,  $msgErro, $msgSucesso);
    }

    protected function listUsuario(string $msgErro = "", string $msgSucesso = "")
    {
        if (isset($_SESSION[SESSAO_USUARIO_PAPEL]) && $_SESSION[SESSAO_USUARIO_PAPEL] == 1) {
            header("Location: " . BASEURL . "/controller/VagaController.php?action=listPublic");
            exit;
        }

        $status = isset($_GET['status']) ? trim($_GET['status']) : '';
        $empresaId = $_SESSION[SESSAO_USUARIO_ID];
        
        if ($status !== '') {
            $vagas = $this->vagaDao->filterByStatusAndEmpresa($status, $empresaId);
        } else {
            $vagas = $this->vagaDao->findByEmpresa($empresaId);
        }
        
        $dados["lista"] = $vagas;
        $dados["status"] = Status::getAllAsArray();
        $dados["selected_status"] = $status;
        $dados["show_status_filter"] = true; 

        $this->loadView("vaga/vaga_list.php", $dados,  $msgErro, $msgSucesso);
    }

    protected function create()
    {
        if (isset($_SESSION[SESSAO_USUARIO_PAPEL]) && $_SESSION[SESSAO_USUARIO_PAPEL] == 1) {
            header("Location: " . BASEURL . "/controller/VagaController.php?action=listPublic");
            exit;
        }

        $usuario = $this->usuarioDao->findById($_SESSION[SESSAO_USUARIO_ID]);
        $dados["id"] = 0;
        $dados["modalidades"] = Modalidade::getAllAsArray();
        $dados["horarios"] = Horario::getAllAsArray();
        $dados["regimes"] = Regime::getAllAsArray();
        $dados["status"] = Status::getAllAsArray();
        $dados["cargos"] = $this->cargoDao->list();
        $dados["categorias"] = $this->categoriaDao->list();
        $dados["empresa"] = $this->usuarioDao->findById($usuario->getId());
        $this->loadView("vaga/vaga_form.php", $dados);
    }

    protected function edit()
    {
        if (isset($_SESSION[SESSAO_USUARIO_PAPEL]) && $_SESSION[SESSAO_USUARIO_PAPEL] == 1) {
            header("Location: " . BASEURL . "/controller/VagaController.php?action=listPublic");
            exit;
        }

        $vaga = $this->findVagaById();
        if ($vaga) {
            $dados["id"] = $vaga->getId();
            $dados["vaga"] = $vaga;
            $dados["modalidades"] = Modalidade::getAllAsArray();
            $dados["horarios"] = Horario::getAllAsArray();
            $dados["regimes"] = Regime::getAllAsArray();
            $dados["status"] = Status::getAllAsArray();
            $dados["cargos"] = $this->cargoDao->list();
            $dados["categorias"] = $this->categoriaDao->list();
            $dados["empresa"] = $this->usuarioDao->findById($vaga->getEmpresa()->getId());

            $this->loadView("vaga/vaga_form.php", $dados);
        } else
            $this->listUsuario("Vaga não encontrado.");
    }

    protected function save()
    {
    
        if (isset($_SESSION[SESSAO_USUARIO_PAPEL]) && $_SESSION[SESSAO_USUARIO_PAPEL] == 1) {
            header("Location: " . BASEURL . "/controller/VagaController.php?action=listPublic");
            exit;
        }

        $dados["id"] = isset($_POST['id']) ? $_POST['id'] : 0;
        $titulo = trim($_POST['titulo']) ? trim($_POST['titulo']) : NULL;
        $modalidade = trim($_POST['modalidade']) ? trim($_POST['modalidade']) : NULL;
        $horario = trim($_POST['horario']) ? trim($_POST['horario']) : NULL;
        $regime = trim($_POST['regime']) ? trim($_POST['regime']) : NULL;
        $salario = trim($_POST['salario']) ? trim($_POST['salario']) : NULL;
        $descricao = trim($_POST['descricao']) ? trim($_POST['descricao']) : NULL;
        $requisitos = trim($_POST['requisitos']) ? trim($_POST['requisitos']) : NULL;
        $status = trim($_POST['status']) ? trim($_POST['status']) : Status::ATIVO;
        $cargoId = isset($_POST['cargo']) && is_numeric($_POST['cargo']) && (int)$_POST['cargo'] > 0 ? (int)$_POST['cargo'] : NULL;
        $cargo = $cargoId !== null ? $this->cargoDao->findById($cargoId) : NULL;
        $categoriaId = isset($_POST['categoria']) && is_numeric($_POST['categoria']) && (int)$_POST['categoria'] > 0 ? (int)$_POST['categoria'] : NULL;
        $categoria = $categoriaId !== null ? $this->categoriaDao->findById($categoriaId) : NULL;
        $usuarioId = isset($_POST['usuarioId']) && is_numeric($_POST['usuarioId']) ? (int)$_POST['usuarioId'] : NULL;
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
                  
                    header("location: " . BASEURL . "/controller/VagaController.php?action=list");
                    exit;
                } else { 
                    $vaga->setId($dados["id"]);
                    $this->vagaDao->update($vaga);

                    $msg = "Vaga salva com sucesso.";
                    $this->listUsuario("", $msg);
                    exit;
                }
            } catch (PDOException $e) {
                $erros = ["Erro ao salvar a vaga na base de dados.", $e];
            }
        }

    
        $dados["vaga"] = $vaga;
        $dados["modalidades"] = Modalidade::getAllAsArray();
        $dados["horarios"] = Horario::getAllAsArray();
        $dados["regimes"] = Regime::getAllAsArray();
        $dados["cargos"] = $this->cargoDao->list();
        $dados["empresa"] = $this->usuarioDao->findById($vaga->getEmpresa()->getId());

        $msgsErro = is_array($erros) ? implode("<br>", $erros) : $erros;
        $this->loadView("vaga/vaga_form.php", $dados, $msgsErro);
    }

    protected function delete()
    {
        if (isset($_SESSION[SESSAO_USUARIO_PAPEL]) && $_SESSION[SESSAO_USUARIO_PAPEL] == 1) {
            header("Location: " . BASEURL . "/controller/VagaController.php?action=listPublic");
            exit;
        }

        $vaga = $this->findVagaById();
        if ($vaga) {
            $this->vagaDao->deleteById($vaga->getId());
            header("location: " . BASEURL . "/controller/VagaController.php?action=list");
        } else
            $this->listUsuario("Usuario não econtrado!");
    }

     protected function inativarVaga() {
        if (isset($_SESSION[SESSAO_USUARIO_PAPEL]) && $_SESSION[SESSAO_USUARIO_PAPEL] == 1) {
            header("Location: " . BASEURL . "/controller/VagaController.php?action=listPublic");
            exit;
        }

        $vaga = $this->findVagaById();
        if ($vaga) {
            $this->vagaDao->inativarVaga($vaga->getId());
            header("location: " . BASEURL . "/controller/VagaController.php?action=list");
        } else
            $this->listUsuario("Usuario não econtrado!");
    }

    private function findVagaById()
    {
        $id = 0;
        if (isset($_GET['id']))
            $id = $_GET['id'];

        $vaga = $this->vagaDao->findById($id);
        return $vaga;
    }

    protected function viewVagas()
    {
        $this->usuarioLogado();

        $msgErro = "";
        if (isset($_GET["erro"])) {
             $msgErro = urldecode($_GET["erro"]);
}
        $vaga = $this->findVagaById();
        if ($vaga) {
            $dados["vaga"] = $vaga;
            
            // Verifica se o usuário está logado para mostrar informações de candidatura
            if (isset($_SESSION[SESSAO_USUARIO_ID])) {
                $candidatoId = $_SESSION[SESSAO_USUARIO_ID];
                $candidatura = $this->candidaturaDao->findByCandidatoAndVaga($candidatoId, $vaga->getId());
                if($candidatura) {
                    $dados["candidatura"] = $candidatura;
                }
            }
                $this->loadView("vaga/vaga_detalhes.php", $dados, $msgErro);
        } else {
            $this->listPublic("Vaga não encontrada.");
        }
    }

    protected function list(string $msgErro = "", string $msgSucesso = "")
    {
        if (isset($_SESSION[SESSAO_USUARIO_PAPEL]) && $_SESSION[SESSAO_USUARIO_PAPEL] == 1) {
            header("Location: " . BASEURL . "/controller/VagaController.php?action=listPublic");
            exit;
        }

        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        $status = isset($_GET['status']) ? trim($_GET['status']) : '';
        $empresaId = $_SESSION[SESSAO_USUARIO_ID];

        if (!empty($search)) {
            $vagas = $this->vagaDao->searchByTitle($search);
        } else if (!empty($status)) {
            $vagas = $this->vagaDao->filterByStatus($status);
        } else {
            $vagas = $this->vagaDao->findByEmpresa($empresaId);
        }

        $vagas = $this->vagaDao->findByEmpresa($_SESSION[SESSAO_USUARIO_ID]);
        $dados["lista"] = $vagas;
        $dados["status"] = Status::getAllAsArray();
        $dados["selected_status"] = $status;
        $dados["show_status_filter"] = true;

        $this->loadView("vaga/vaga_list.php", $dados, $msgErro, $msgSucesso);
    }

    protected function minhasCandidaturas(string $msgErro = "", string $msgSucesso = "")
    {
        if (!$this->usuarioLogado()) {
            header("location: " . BASEURL . "/controller/LoginController.php?action=login");
            exit;
        }

        $candidatoId = $_SESSION[SESSAO_USUARIO_ID];
        $candidaturas = $this->candidaturaDao->findByCandidato($candidatoId);
        
        $dados["lista"] = $candidaturas;
        $this->loadView("vaga/minhas_candidaturas.php", $dados, $msgErro, $msgSucesso);
    }

    protected function viewCandidatos(string $msgErro = "", string $msgSucesso = "")
    {
        if (isset($_SESSION[SESSAO_USUARIO_PAPEL]) && $_SESSION[SESSAO_USUARIO_PAPEL] == 1) {
            header("Location: " . BASEURL . "/controller/VagaController.php?action=listPublic");
            exit;
        }

        $vaga = $this->findVagaById();
        if ($vaga) {
            $candidaturas = $this->candidaturaDao->findByVaga($vaga->getId());
            $dados["vaga"] = $vaga;
            $dados["lista"] = $candidaturas;
            $this->loadView("vaga/candidatos_list.php", $dados, $msgErro, $msgSucesso);
        } else {
            $this->listUsuario("Vaga não encontrada.");
        }
    }

    // Sobrescreve o método usuarioLogado para permitir acesso público à listagem de vagas
     protected function usuarioLogado() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        return isset($_SESSION[SESSAO_USUARIO_ID]);
    }
}

new VagaController();
