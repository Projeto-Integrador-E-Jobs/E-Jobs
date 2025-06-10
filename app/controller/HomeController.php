<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once(__DIR__ . "/Controller.php");
require_once(__DIR__ . "/../dao/VagaDAO.php");
require_once(__DIR__ . "/../dao/CategoriaDAO.php");
require_once(__DIR__ . "/../dao/UsuarioDAO.php");
require_once(__DIR__ . "/../dao/CargoDAO.php");

class HomeController extends Controller {

    private VagaDAO $vagaDao;
    private CategoriaDAO $categoriaDao;
    private UsuarioDAO $usuarioDao;
    private CargoDAO $cargoDao;

    //Método construtor do controller - será executado a cada requisição a está classe
    public function __construct() {
        $this->vagaDao = new VagaDAO();
        $this->categoriaDao = new CategoriaDAO();
        $this->usuarioDao = new UsuarioDAO();
        $this->cargoDao = new CargoDAO();
        $this->handleAction();
    }
    
    public function home() {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        // Redireciona empresas para sua home específica
        if (isset($_SESSION[SESSAO_USUARIO_PAPEL])) {
            switch ($_SESSION[SESSAO_USUARIO_PAPEL]) {
                case 2: // Administrador
                    if (!isset($_GET['action']) || $_GET['action'] !== 'home') {
                        header("location: " . BASEURL . "/controller/AdminController.php?action=home");
                        exit;
                    }
                    break;
                case 3: // Empresa
                    header("location: " . BASEURL . "/controller/EmpresaController.php?action=home");
                    exit;
            }
        }

        $dados = [];

        $dados["categorias"] = $this->categoriaDao->listHome();
        
        if (isset($_GET['search']) && !empty(trim($_GET['search']))) {
            $searchTerm = trim($_GET['search']);
            $dados['vagas'] = $this->vagaDao->searchByTitle($searchTerm);
            $dados['search_term'] = $searchTerm;
            
            error_log("Search term: " . $searchTerm);
            error_log("Number of results: " . count($dados['vagas']));
        }

        $this->loadView("home/home.php", $dados);
    }

    public function dashboard() {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']->getTipoUsuario()->getId() != 2) {
            header('location: ' . HOME_PAGE);
            exit;
        }

        $dados = [
            'usuarios' => $this->usuarioDao->list(),
            'categorias' => $this->categoriaDao->list(),
            'cargos' => $this->cargoDao->list(),
            'vagas' => $this->vagaDao->list()
        ];

        $this->loadView("admin/dashboard.php", $dados);
    }

}

#Criar objeto da classe para assim executar o construtor
new HomeController();