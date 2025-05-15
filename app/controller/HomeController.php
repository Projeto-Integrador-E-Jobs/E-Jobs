<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once(__DIR__ . "/Controller.php");
require_once(__DIR__ . "/../dao/VagaDAO.php");
require_once(__DIR__ . "/../dao/CategoriaDAO.php");

class HomeController extends Controller {

    private VagaDAO $vagaDao;
    private CategoriaDAO $categoriaDao;

    //Método construtor do controller - será executado a cada requisição a está classe
    public function __construct() {
        $this->vagaDao = new VagaDAO();
        $this->categoriaDao = new CategoriaDAO();
        $this->handleAction();
    }
    
    public function home() {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $dados = [];

        $dados["categorias"] = $this->categoriaDao->list();
        
        if (isset($_GET['search']) && !empty(trim($_GET['search']))) {
            $searchTerm = trim($_GET['search']);
            $dados['vagas'] = $this->vagaDao->searchByTitle($searchTerm);
            $dados['search_term'] = $searchTerm;
            
        
            error_log("Search term: " . $searchTerm);
            error_log("Number of results: " . count($dados['vagas']));
        }

        $this->loadView("home/home.php", $dados);
    }

}

#Criar objeto da classe para assim executar o construtor
new HomeController();