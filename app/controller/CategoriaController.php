<?php

include_once(__DIR__ . "/../dao/CategoriaDAO.php");
include_once(__DIR__ . "/../service/CategoriaService.php");
require_once(__DIR__ . "/Controller.php");
require_once(__DIR__ . "/../model/TipoUsuario.php");

class CategoriaController extends Controller { 
    private CategoriaDAO $categoriaDao;
    private CategoriaService $categoriaService; 

    public function __construct() { 
        if(! $this->usuarioLogado())
            exit;

        $papel = $_SESSION[SESSAO_USUARIO_PAPEL];
        if ($papel == TipoUsuario::ID_CANDIDATO) {
            header("location: " . HOME_PAGE);
            exit;
        }

        $this->categoriaDao = new CategoriaDAO();
        $this->categoriaService = new CategoriaService();
        $this->handleAction();
    }

    protected function create() {
        $dados["id"] = 0;
        $this->loadView("categoria/categoria_form.php", $dados);
    }

    protected function edit() {
        $categoria = $this->findCategoriaById();
        if($categoria) {
            $dados["id"] = $categoria->getId();
            $dados["categoria"] = $categoria;
            $this->loadView("categoria/categoria_form.php", $dados);
        } else
            $this->list("Categoria não encontrada.");
    }

    protected function list(string $msgErro = "", string $msgSucesso = "") {
        $categorias = $this->categoriaDao->list();
        $dados["lista"] = $categorias;

        $this->loadView("categoria/categoria_list.php", $dados,  $msgErro, $msgSucesso);
    }

    protected function save() {
        $dados["id"] = isset($_POST['id']) ? $_POST['id'] : 0;
        $nome = trim($_POST['nome']) ? trim($_POST['nome']) : NULL;
        $icone = trim($_POST['icone']) ? trim($_POST['icone']) : NULL;

        $categoria = new Categoria();
        $categoria->setNome($nome);
        $categoria->setIcone($icone);
        $categoria->setId($dados["id"]);

        //1- Validar os dados (service)
        $erros = $this->categoriaService->validarDados($categoria);
        if(! $erros) {
            echo "Inserir na base de dados!";
            //2- Inserir os dados na base (dao)
            try {
                
                if($dados["id"] == 0) 
                    $this->categoriaDao->insert($categoria);
                else { 
                    $this->categoriaDao->update($categoria);
                }

                //3- Redirecionar para a action list do CargoController
                header("location: " . BASEURL . "/controller/CategoriaController.php?action=list");
                exit;
            } catch (PDOException $e) {
                $erros = ["Erro ao salvar o cargo na base de dados."];                
            }
        }

        $dados["categoria"] = $categoria;
        $msgErro = implode("<br>", $erros);

        $this->loadView("categoria/categoria_form.php", $dados, $msgErro);
    }

    protected function delete() {
        $categoria = $this->findCategoriaById();
        if($categoria) {
            $this->categoriaDao->deleteById($categoria->getId());
            header("location: " . BASEURL . "/controller/CategoriaController.php?action=list");
        } else
            $this->list("Categoria não econtrada!");
    }

    private function findCategoriaById() {
        $id = 0;
        if(isset($_GET['id']))
            $id = $_GET['id'];

        $categoria = $this->categoriaDao->findById($id);
        return $categoria;
    }


}

new CategoriaController();
