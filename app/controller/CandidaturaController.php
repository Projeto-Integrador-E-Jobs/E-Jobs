<?php 
require_once(__DIR__ . "/../dao/UsuarioDAO.php");
require_once(__DIR__ . "/../dao/VagaDAO.php");
require_once(__DIR__ . "/Controller.php");
require_once(__DIR__ . "/../dao/CandidaturaDAO.php");
require_once (__DIR__ . "/../model/enum/StatusCandidatura.php");
require_once(__DIR__ . "/../model/TipoUsuario.php");



class CandidaturaController extends Controller {
 
    private VagaDAO $vagaDao;
    private UsuarioDAO $usuarioDao;
    private CandidaturaDAO $candidaturaDao;


    public function __construct()
    {
        if(! $this->usuarioLogado())
            exit;

        //Criar os DAOS
        $this->vagaDao = new VagaDAO();
        $this->usuarioDao = new UsuarioDAO();
        $this->candidaturaDao = new CandidaturaDAO();
        $this -> handleAction();
    }


    protected function candidatar() {
        
        $vaga = $this->findVagaById();
        if(! $vaga) {
            echo "Vaga não encontrada!";
            exit;
        } 

        $candidatoId = $_SESSION[SESSAO_USUARIO_ID];
        $candidato = $this->usuarioDao->findById($candidatoId);


        /*

        $candidaturaExistente = $this->candidaturaDao->findByCandidatoAndVaga($candidatoId, $vaga->getId());
        if ($candidaturaExistente) {
            $this->viewVagas();
            return;
        }

        */

        if($candidato->getTipoUsuario()->getId() == TipoUsuario::ID_CANDIDATO){
            $candidatura = new Candidatura();
            $candidatura->setCandidato($candidato)
                    ->setVaga($vaga)
                    ->setStatus(StatusCandidatura::EM_ANDAMENTO);

            try {
                $this->candidaturaDao->insert($candidatura);

                header("location: " . BASEURL . "/controller/VagaController.php?action=viewVagas&id=" . $vaga->getId());
            } catch (Exception $e) {
                echo "Erro ao realizar candidatura: " . $e->getMessage();
            }
        } else {
            $msgErro = urlencode("Apenas candidatos podem se candidatar a vagas.");
            header("location: " . BASEURL . "/controller/VagaController.php?action=viewVagas&id=" . $vaga->getId() . "&erro=$msgErro");
        }
    }

    protected function listarCandidatos(string $msgErro = "", string $msgSucesso = "") {
        // Verifica se é uma empresa
        if ($_SESSION[SESSAO_USUARIO_PAPEL] != TipoUsuario::ID_EMPRESA) {
            header("location: " . BASEURL . "/controller/VagaController.php?action=listPublic");
            exit;
        }

        $vaga = $this->findVagaById();
        if (!$vaga) {
            header("location: " . BASEURL . "/controller/VagaController.php?action=list");
            exit;
        }

        // Verifica se a vaga pertence à empresa logada
        if ($vaga->getEmpresa()->getId() != $_SESSION[SESSAO_USUARIO_ID]) {
            header("location: " . BASEURL . "/controller/VagaController.php?action=list");
            exit;
        }

        $candidaturas = $this->candidaturaDao->findByVaga($vaga->getId());
        $dados["vaga"] = $vaga;
        $dados["lista"] = $candidaturas;
        
        $this->loadView("vaga/candidatos_list.php", $dados, $msgErro, $msgSucesso);
    }

    private function findVagaById() {
        $id = 0;
        if (isset($_GET['id']))
            $id = $_GET['id'];

        $vaga = $this->vagaDao->findById($id);
        return $vaga;
    }

    protected function viewCandidato() {
        // Only companies can view candidate profiles
        if ($_SESSION[SESSAO_USUARIO_PAPEL] != TipoUsuario::ID_EMPRESA) {
            header("location: " . BASEURL . "/controller/VagaController.php?action=listPublic");
            exit;
        }

        if (!isset($_GET['id'])) {
            header("location: " . BASEURL . "/controller/VagaController.php?action=list");
            exit;
        }

        $candidato = $this->usuarioDao->findById($_GET['id']);
        if (!$candidato) {
            header("location: " . BASEURL . "/controller/VagaController.php?action=list");
            exit;
        }

        $dados['candidato'] = $candidato;
        $this->loadView("usuario/perfil_candidato.php", $dados);
    }

}

new CandidaturaController();