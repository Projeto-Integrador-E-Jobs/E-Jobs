<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once(__DIR__ . "/Controller.php");

class HomeController extends Controller {

    //Método construtor do controller - será executado a cada requisição a está classe
    public function __construct() {
        $this->handleAction();
    }
    
    //Acão para carregar a página inicial
    public function home() {
        
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

        $dados["qtdUsuarios"] = 30;

        $this->loadView("home/home.php", $dados);
    }

}

#Criar objeto da classe para assim executar o construtor
new HomeController();