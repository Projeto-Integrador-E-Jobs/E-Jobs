<?php

include_once(__DIR__ . "/../dao/CargoDAO.php");
require_once(__DIR__ . "/Controller.php");



class CargoController extends Controller { 
    private CargoDAO $cargoDAO; 

    public function __construct() { 
        $this->cargoDAO = new CargoDAO();
        $this->handleAction();
    }

    protected function create() {
        $dados["id"] = 0;
        $this->loadView("cargo/cargo_form.php", $dados);
    }

    protected function list(string $msgErro = "", string $msgSucesso = "") {
        $cargos = $this->cargoDAO->list();
        $dados["lista"] = $cargos;

        $this->loadView("cargo/cargo_list.php", $dados,  $msgErro, $msgSucesso);
    }

    protected function save() {
        $dados["id"] = isset($_POST['id']) ? $_POST['id'] : 0;
        $nome = trim($_POST['nome']) ? trim($_POST['nome']) : NULL;

        $cargo = new Cargo();
        $cargo->setNome($nome);
        
        //Validar os dados (CargoService)


        //Inserir no banco (CargoDAO)
        
        $dados["cargo"] = $cargo;
  

        $this->loadView("cargo/cargo_form.php", $dados);
    }


}

//Cria o objeto da classe
new CargoController();
