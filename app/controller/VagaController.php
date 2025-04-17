<?php
require_once(__DIR__ . "/Controller.php");
require_once(__DIR__ . "/../dao/VagaDAO.php");
require_once(__DIR__ . "/../dao/UsuarioDAO.php");
require_once(__DIR__ . "/../dao/CargoDAO.php");
require_once(__DIR__ . "/../service/VagaService.php");
require_once(__DIR__ . "/../model/Vaga.php");
require_once(__DIR__ . "/../model/enum/Modalidade.php");
require_once(__DIR__ . "/../model/enum/Regime.php");
require_once(__DIR__ . "/../model/enum/Horario.php");


class VagaController extends Controller {

    private VagaDAO $vagaDao;
    private UsuarioDAO $usuarioDao;
    private CargoDAO $cargoDao;
    private VagaService $vagaService;

    //Método construtor do controller - será executado a cada requisição a está classe
    public function __construct() {
        $action = $_GET["action"];
        $list = "listPublic";

        if ($action != $list && ! $this->usuarioLogado()) {
            exit;
        }

        $this->vagaDao = new VagaDAO();
        $this->cargoDao = new CargoDAO();
        $this->usuarioDao = new UsuarioDAO();
        $this->vagaService = new VagaService();
        
        $this->handleAction();
    }

    protected function listPublic(string $msgErro = "", string $msgSucesso = "") {
        $vagas = $this->vagaDao->list();
        //print_r($usuarios);
        $dados["lista"] = $vagas;

        $this->loadView("vaga/vagaPublica_list.php", $dados,  $msgErro, $msgSucesso);
    }

    protected function listUsuario(string $msgErro = "", string $msgSucesso = "") {
        $vagas = $this->vagaDao->findByEmpresa($_SESSION[SESSAO_USUARIO_ID]);
        $dados["lista"] = $vagas;

        $this->loadView("vaga/vaga_list.php", $dados,  $msgErro, $msgSucesso);
    }

    protected function create() {
        $usuario = $this->usuarioDao->findById($_SESSION[SESSAO_USUARIO_ID]);
        $dados["id"] = 0;
        $dados["modalidades"] = Modalidade::getAllAsArray();
        $dados["horarios"] = Horario::getAllAsArray();
        $dados["regimes"] = Regime::getAllAsArray();
        $dados["cargos"] = $this->cargoDao->list();
        $dados["empresa"] = $this->usuarioDao->findById($usuario->getId());
        $this->loadView("vaga/vaga_form.php", $dados);
    }

    protected function edit() {
        $vaga = $this->findVagaById();
        if($vaga) {
            $dados["id"] = $vaga->getId();
            $dados["vaga"] = $vaga;
            $dados["modalidades"] = Modalidade::getAllAsArray();
            $dados["horarios"] = Horario::getAllAsArray();
            $dados["regimes"] = Regime::getAllAsArray();
            $dados["cargos"] = $this->cargoDao->list();
            $dados["empresa"] = $this->usuarioDao->findById($vaga->getEmpresa()->getId());

            $this->loadView("vaga/vaga_form.php", $dados);
        } else
            $this->listUsuario("Vaga não encontrado.");
    }

    protected function save() {
        //Captura os dados do formulário
        $dados["id"] = isset($_POST['id']) ? $_POST['id'] : 0;
        $titulo = trim($_POST['titulo']) ? trim($_POST['titulo']) : NULL;
        $modalidade = trim($_POST['modalidade']) ? trim($_POST['modalidade']) : NULL;
        $horario = trim($_POST['horario']) ? trim($_POST['horario']) : NULL;
        $regime = trim($_POST['regime']) ? trim($_POST['regime']) : NULL;
        $salario = trim($_POST['salario']) ? trim($_POST['salario']) : NULL;
        $descricao = trim($_POST['descricao']) ? trim($_POST['descricao']) : NULL;
        $requisitos = trim($_POST['requisitos']) ? trim($_POST['requisitos']) : NULL;
        $cargoId = isset($_POST['cargo']) && is_numeric($_POST['cargo']) && (int)$_POST['cargo'] > 0 ? (int)$_POST['cargo'] : NULL;
        $cargo = $cargoId !== null ? $this->cargoDao->findById($cargoId) : NULL;
        $usuarioId = isset($_POST['usuarioId']) && is_numeric($_POST['usuarioId']) ? (int)$_POST['usuarioId'] : NULL;
        $empresa = $usuarioId ? $this->usuarioDao->findById($usuarioId) : null;

        //Cria objeto Usuario
        $vaga = new Vaga();
        $vaga->setTitulo($titulo);
        $vaga->setModalidade($modalidade);
        $vaga->setHorario($horario);
        $vaga->setRegime($regime);
        $vaga->setSalario($salario);
        $vaga->setDescricao($descricao);
        $vaga->setRequisitos($requisitos);
        $vaga->setCargo($cargo);
        $vaga->setEmpresa($empresa);
        

        //Validar os dados
        $erros = $this->vagaService->validarDados($vaga);
        if(empty($erros)) {
            //Persiste o objeto
            try {
    
                if($dados["id"] == 0){ //Inserindo
                    $this->vagaDao->insert($vaga);
                } else { //Alterando
                    $vaga->setId($dados["id"]);
                    $this->vagaDao->update($vaga);
                }

                //TODO - Enviar mensagem de sucesso
                $msg = "Vaga salva com sucesso.";
                $this->listUsuario("", $msg);
                exit;
            } catch (PDOException $e) {
                $erros = ["Erro ao salvar a vaga na base de dados.", $e];
            }
        }

        //Se há erros, volta para o formulário
        
        //Carregar os valores recebidos por POST de volta para o formulário
        
        $dados["vaga"] = $vaga;
        $dados["modalidades"] = Modalidade::getAllAsArray();
        $dados["horarios"] = Horario::getAllAsArray();
        $dados["regimes"] = Regime::getAllAsArray();
        $dados["cargos"] = $this->cargoDao->list();
        $dados["empresa"] = $this->usuarioDao->findById($vaga->getEmpresa()->getId());

        $msgsErro = is_array($erros) ? implode("<br>", $erros) : $erros;
        $this->loadView("vaga/vaga_form.php", $dados, $msgsErro);
    }

    protected function delete() {
        $vaga = $this->findVagaById();
        if($vaga) {
            $this->vagaDao->deleteById($vaga->getId());
            header("location: " . BASEURL . "/controller/VagaController.php?action=list");
        } else
            $this->listUsuario("Usuario não econtrado!");
    }

    private function findVagaById() {
        $id = 0;
        if(isset($_GET['id']))
            $id = $_GET['id'];

        $vaga = $this->vagaDao->findById($id);
        return $vaga;
    }

}

new VagaController();
