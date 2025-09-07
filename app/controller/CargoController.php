<?php

include_once(__DIR__ . "/../dao/CargoDAO.php");
include_once(__DIR__ . "/../service/CargoService.php");
require_once(__DIR__ . "/Controller.php");
require_once(__DIR__ . "/../model/TipoUsuario.php");

class CargoController extends Controller { 
    private CargoDAO $cargoDao;
    private CargoService $cargoService; 

    public function __construct() { 
        if(! $this->usuarioLogado())
            exit;

        $papel = $_SESSION[SESSAO_USUARIO_PAPEL];
        if ($papel == TipoUsuario::ID_CANDIDATO) {
            header("location: " . HOME_PAGE);
            exit;
        }

        $this->cargoDao = new CargoDAO();
        $this->cargoService = new CargoService();
        $this->handleAction();
    }

    protected function create() {
        $dados["id"] = 0;
        $this->loadView("cargo/cargo_form.php", $dados);
    }

    protected function edit() {
        $cargo = $this->findCargoById();
        if($cargo) {
            $dados["id"] = $cargo->getId();
            $dados["cargo"] = $cargo;
            $this->loadView("cargo/cargo_form.php", $dados);
        } else
            $this->list("Cargo não encontrado.");
    }

    protected function list(string $msgErro = "", string $msgSucesso = "") {
        $cargos = $this->cargoDao->list();
        $dados["lista"] = $cargos;

        $this->loadView("cargo/cargo_list.php", $dados,  $msgErro, $msgSucesso);
    }

    protected function save() {
        $dados["id"] = isset($_POST['id']) ? $_POST['id'] : 0;
        $nome = trim($_POST['nome']) ? trim($_POST['nome']) : NULL;

        $cargo = new Cargo();
        $cargo->setNome($nome);
        $cargo->setId($dados["id"]);

        //1- Validar os dados (service)
        $erros = $this->cargoService->validarDados($cargo);
        if(! $erros) {
            echo "Inserir na base de dados!";
            //2- Inserir os dados na base (dao)
            try {
                
                if($dados["id"] == 0) 
                    $this->cargoDao->insert($cargo);
                else { 
                    $this->cargoDao->update($cargo);
                }

                //3- Redirecionar para a action list do CargoController
                header("location: " . BASEURL . "/controller/CargoController.php?action=list");
                exit;
            } catch (PDOException $e) {
                $erros = ["Erro ao salvar o cargo na base de dados."];                
            }
        }

        $dados["cargo"] = $cargo;
        $msgErro = implode("<br>", $erros);

        $this->loadView("cargo/cargo_form.php", $dados, $msgErro);
    }

    protected function delete() {
        $cargo = $this->findCargoById();
        if($cargo) {
            $this->cargoDao->deleteById($cargo->getId());
            header("location: " . BASEURL . "/controller/CargoController.php?action=list");
        } else
            $this->list("Cargo não econtrado!");
    }

    private function findCargoById() {
        $id = 0;
        if(isset($_GET['id']))
            $id = $_GET['id'];

        $cargo = $this->cargoDao->findById($id);
        return $cargo;
    }


}

new CargoController();
