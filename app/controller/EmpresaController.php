<?php
require_once(__DIR__ . "/Controller.php");
require_once(__DIR__ . "/../dao/UsuarioDAO.php");
require_once(__DIR__ . "/../dao/VagaDAO.php");

class EmpresaController extends Controller {
    private UsuarioDAO $usuarioDao;
    private VagaDAO $vagaDao;

    public function __construct() {
        if (!$this->usuarioLogado()) {
            header("location: " . BASEURL . "/controller/LoginController.php?action=login");
            exit;
        }

        // Verifica se é uma empresa
        if ($_SESSION[SESSAO_USUARIO_PAPEL] != 3) {
            header("location: " . BASEURL . "/controller/VagaController.php?action=listPublic");
            exit;
        }

        $this->usuarioDao = new UsuarioDAO();
        $this->vagaDao = new VagaDAO();
        
        $this->handleAction();
    }

    protected function home() {
        $empresaId = $_SESSION[SESSAO_USUARIO_ID];
        $empresa = $this->usuarioDao->findById($empresaId);
        
        // Busca todas as vagas da empresa
        $vagas = $this->vagaDao->findByEmpresa($empresaId);
        
        // Filtra apenas vagas ativas
        $vagasAtivas = array_filter($vagas, function($vaga) {
            return $vaga->getStatus() == 'Ativo';
        });
        
        // Pega as 5 vagas ativas mais recentes
        $vagasDestaque = array_slice($vagasAtivas, 0, 5);
        
        $dados = [
            'empresa' => $empresa,
            'total_vagas' => count($vagasAtivas),
            'vagas_destaque' => $vagasDestaque
        ];
        
        $this->loadView("empresa/home.php", $dados);
    }
}

new EmpresaController(); 