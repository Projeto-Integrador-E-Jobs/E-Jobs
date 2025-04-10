<?php

require_once(__DIR__ . "/Controller.php");

class HomeController extends Controller {

    //Método construtor do controller - será executado a cada requisição a está classe
    public function __construct() {
        if(! $this->usuarioLogado())
            exit;

        $this->handleAction();
    }

    //Acão para carregar a página inicial
    public function home() {
        $dados["qtdUsuarios"] = 30;

        $this->loadView("home/home.php", $dados);
    }

}

#Criar objeto da classe para assim executar o construtor
new HomeController();