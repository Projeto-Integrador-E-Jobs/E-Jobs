<?php 
require_once(__DIR__ . "/../dao/UsuarioDAO.php");
require_once(__DIR__ . "/../dao/VagaDAO.php");
require_once(__DIR__ . "/Controller.php");
require_once(__DIR__ . "/../dao/CandidaturaDAO.php");
require_once (__DIR__ . "/../model/enum/StatusCandidatura.php");



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
    }

    private function findVagaById() {
        $id = 0;
        if (isset($_GET['id']))
            $id = $_GET['id'];

        $vaga = $this->vagaDao->findById($id);
        return $vaga;
    }

}

new CandidaturaController();