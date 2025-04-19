<?php
#Classe controller para Usuário
require_once(__DIR__ . "/Controller.php");
require_once(__DIR__ . "/../dao/UsuarioDAO.php");
require_once(__DIR__ . "/../dao/TipoUsuarioDAO.php");
require_once(__DIR__ . "/../dao/EstadoDAO.php");
require_once(__DIR__ . "/../service/UsuarioService.php");
require_once(__DIR__ . "/../service/LoginService.php");
require_once(__DIR__ . "/../model/Usuario.php");
require_once(__DIR__ . "/../model/enum/Status.php");

class CadastroController extends Controller {

    private UsuarioDAO $usuarioDao;
    private TipoUsuarioDAO $tipoUsuarioDAO;
    private EstadoDAO $estadoDAO;
    private UsuarioService $usuarioService;
    private LoginService $loginService;

    //Método construtor do controller - será executado a cada requisição a está classe
    public function __construct() {
    
        $this->usuarioDao = new UsuarioDAO();
        $this->tipoUsuarioDAO = new TipoUsuarioDAO();
        $this->estadoDAO = new EstadoDAO();
        $this->usuarioService = new UsuarioService();
        $this->loginService = new LoginService();


        $this->handleAction();
    }

    protected function create() {
        $dados["id"] = 0;
        $dados["estados"] = $this->estadoDAO->list();
        $dados["papeis"] = $this->tipoUsuarioDAO->listSemADM();
        
        $this->loadView("usuario/form_cadastro.php", $dados);
        
    }


    protected function save() {
        //Captura os dados do formulário
        $idTipoUsuario = isset($_POST['tipoUsuario']) && is_numeric($_POST['tipoUsuario']) ? (int)$_POST['tipoUsuario'] : NULL;
        $tipoUsuario = $idTipoUsuario ? $this->tipoUsuarioDAO->findById($idTipoUsuario) : null;
        $nome = trim($_POST['nome']) ? trim($_POST['nome']) : NULL;
        $email = trim($_POST['email']) ? trim($_POST['email']) : NULL;
        $senha = trim($_POST['senha']) ? trim($_POST['senha']) : NULL;
        $confSenha = trim($_POST['conf_senha']) ? trim($_POST['conf_senha']) : NULL;
        $documento = trim($_POST['documento']) ? trim($_POST['documento']) : NULL;
        $descricao = trim($_POST['descricao']) ? trim($_POST['descricao']) : NULL;
        $estadoId = isset($_POST['estado']) && is_numeric($_POST['estado']) && (int)$_POST['estado'] > 0 ? (int)$_POST['estado'] : NULL;
        $estado = $estadoId !== null ? $this->estadoDAO->findById($estadoId) : NULL;
        $cidade = trim($_POST['cidade']) ? trim($_POST['cidade']) : NULL;
        $endLogradouro = trim($_POST['endLogradouro']) ? trim($_POST['endLogradouro']) : NULL;
        $endBairro = trim($_POST['endBairro']) ? trim($_POST['endBairro']) : NULL;
        $endNumero = trim($_POST['endNumero']) ? trim($_POST['endNumero']) : NULL;
        $telefone = trim($_POST['telefone']) ? trim($_POST['telefone']) : NULL;
        
        

        //Cria objeto Usuario
        $usuario = new Usuario();
        $usuario->setTipoUsuario($tipoUsuario);
        $usuario->setNome($nome);
        $usuario->setEmail($email);
        $usuario->setSenha($senha);
        $usuario->setDocumento($documento);
        $usuario->setDescricao($descricao);
        $usuario->setEstado($estado);
        $usuario->setCidade($cidade);
        $usuario->setEndLogradouro($endLogradouro);
        $usuario->setEndBairro($endBairro);
        $usuario->setEndNumero($endNumero);
        $usuario->setTelefone($telefone);
        if($usuario->getTipoUsuario() != null)
            if($usuario->getTipoUsuario()->getNome() == "EMPRESA"){
                $usuario->setStatus("Pendente");
            }else
                $usuario->setStatus("Ativo");
        //Validar os dados
        $erros = $this->usuarioService->validarDados($usuario, $confSenha);
        if(empty($erros)) {
            //Persiste o objeto
            try {
                $endCompleto = $estado->getNome() . ", " . $cidade . ", " . $endLogradouro . ", " . $endBairro . ", " . $endNumero;
                $usuario->setEndCompleto($endCompleto);
                $this->usuarioDao->insert($usuario);
               
                $usuario = $this->usuarioDao->findByLoginSenha($usuario->getEmail(),$usuario->getSenha());                    
                
                $this->loginService->salvarUsuarioSessao($usuario);
                header("location: " . HOME_PAGE);
                exit;
            } catch (PDOException $e) {
                $erros = "[Erro ao salvar o usuário na base de dados.]";                
            }
        }

        //Se há erros, volta para o formulário
        
        //Carregar os valores recebidos por POST de volta para o formulário

        
        $dados["usuario"] = $usuario;
        $dados["confSenha"] = $confSenha;
        $dados["estados"] = $this->estadoDAO->list();
        $dados["papeis"] = $this->tipoUsuarioDAO->list();

        $msgsErro = is_array($erros) ? implode("<br>", $erros) : $erros;
        $this->loadView("usuario/form_cadastro.php", $dados, $msgsErro);
    }


}


#Criar objeto da classe para assim executar o construtor
new CadastroController();
