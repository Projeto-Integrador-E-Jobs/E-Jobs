<?php
require_once(__DIR__ . "/Controller.php");
require_once(__DIR__ . "/../dao/UsuarioDAO.php");
require_once(__DIR__ . "/../dao/CategoriaDAO.php");
require_once(__DIR__ . "/../dao/CargoDAO.php");
require_once(__DIR__ . "/../dao/VagaDAO.php");

class AdminController extends Controller {
    private UsuarioDAO $usuarioDao;
    private CategoriaDAO $categoriaDao;
    private CargoDAO $cargoDao;
    private VagaDAO $vagaDao;

    public function __construct() {
        $this->usuarioDao = new UsuarioDAO();
        $this->categoriaDao = new CategoriaDAO();
        $this->cargoDao = new CargoDAO();
        $this->vagaDao = new VagaDAO();
        $this->handleAction();
    }

    public function home() {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']->getTipoUsuario()->getId() != 2) {
            header('location: ' . HOME_PAGE);
        }
        $dados = [
            'usuarios' => $this->usuarioDao->list(),
            'categorias' => $this->categoriaDao->list(),
            'cargos' => $this->cargoDao->list()
        ];
        $this->loadView("admin/dashboard.php", $dados);
    }
}

new AdminController(); 