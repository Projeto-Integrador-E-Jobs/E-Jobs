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
        $dados["estados"] = $this->estadoDAO->list();
        $dados["papeis"] = $this->tipoUsuarioDAO->listSemADM();
        
        $this->loadView("usuario/form_cadastro.php", $dados);
        
    }

    protected function save() {
        //Captura os dados do formulário
        $idTipoUsuario = isset($_POST['tipoUsuario']) && is_numeric($_POST['tipoUsuario']) ? (int)$_POST['tipoUsuario'] : NULL;
        $nome = trim($_POST['nome']) ? trim($_POST['nome']) : NULL;
        $email = trim($_POST['email']) ? trim($_POST['email']) : NULL;
        $senha = trim($_POST['senha']) ? trim($_POST['senha']) : NULL;
        $confSenha = trim($_POST['conf_senha']) ? trim($_POST['conf_senha']) : NULL;
        
        $documento = NULL;
        if(isset($_POST['documento']))
            $documento = trim($_POST['documento']) ? trim($_POST['documento']) : NULL;
        
        $descricao = trim($_POST['descricao']) ? trim($_POST['descricao']) : NULL;
        $estadoId = isset($_POST['estado']) && is_numeric($_POST['estado']) ? $_POST['estado'] : NULL;
        $cidadeId = trim($_POST['cidade']) ? trim($_POST['cidade']) : NULL;
        $endLogradouro = trim($_POST['endLogradouro']) ? trim($_POST['endLogradouro']) : NULL;
        $endBairro = trim($_POST['endBairro']) ? trim($_POST['endBairro']) : NULL;
        $endNumero = trim($_POST['endNumero']) ? trim($_POST['endNumero']) : NULL;
        $telefone = trim($_POST['telefone']) ? trim($_POST['telefone']) : NULL;
        
        //Cria objeto Usuario
        $usuario = new Usuario();

        if($idTipoUsuario) {
            $tipoUsuario = new TipoUsuario();
            $tipoUsuario->setId($idTipoUsuario);
            $usuario->setTipoUsuario($tipoUsuario);
        } else
            $usuario->setTipoUsuario(null);

        $usuario->setNome($nome);
        $usuario->setEmail($email);
        $usuario->setSenha($senha);
        $usuario->setDocumento($documento);
        $usuario->setDescricao($descricao);
        
        $cidade = new Cidade();
        if($cidadeId)
            $cidade->setCodigoIbge($cidadeId);
        else
            $cidade->setCodigoIbge(null);
        $cidade->setEstado(new Estado());
        $cidade->getEstado()->setCodigoUf($estadoId);
        $usuario->setCidade($cidade);

        $usuario->setEndLogradouro($endLogradouro);
        $usuario->setEndBairro($endBairro);
        $usuario->setEndNumero($endNumero);
        $usuario->setTelefone($telefone);
        if($usuario->getTipoUsuario() != null && $usuario->getTipoUsuario()->getId() == TipoUsuario::ID_EMPRESA)
            $usuario->setStatus(Status::PENDENTE);
        else
            $usuario->setStatus(Status::ATIVO);
        
        //Validar os dados
        $erros = $this->usuarioService->validarDados($usuario, $confSenha);
        if(empty($erros)){
            if($usuario->getTipoUsuario()->getId() == TipoUsuario::ID_CANDIDATO){
                if (! $this->usuarioService->validarCPF($usuario->getDocumento())) {
                    array_push($erros, "O CPF informado é inválido.");
                }
                
            }
            if(empty($erros)){
            $erros = array_merge($erros,$this->usuarioService->validarDocumento($usuario->getDocumento()));
            $erros = array_merge($erros,$this->usuarioService->validarEmail($usuario->getEmail()));
            }
        }
        if(empty($erros)) {
            //Persiste o objeto
            try {
                $this->usuarioDao->insert($usuario);
               
                $usuario = $this->usuarioDao->findByLoginSenha($usuario->getEmail(),$usuario->getSenha());  
                if($usuario->getStatus == Status::ATIVO){                  
                    $this->loginService->salvarUsuarioSessao($usuario);
                    
                    // Redireciona baseado no tipo de usuário
                    switch ($usuario->getTipoUsuario()->getId()) {
                        case TipoUsuario::ID_CANDIDATO: 
                            header("location: " . BASEURL . "/controller/VagaController.php?action=minhasCandidaturas");
                            break;
                        case TipoUsuario::ID_ADMINISTRADOR:
                            header("location: " . BASEURL . "/controller/HomeController.php?action=dashboard");
                            break;
                        case TipoUsuario::ID_EMPRESA:
                            header("location: " . BASEURL . "/controller/EmpresaController.php?action=home");
                            break;
                        default:
                            header("location: " . HOME_PAGE);
                    }
                
                    exit;
                } else {header("location: " . HOME_PAGE);}
            } catch (PDOException $e) {
                $erros = ["Erro ao salvar o usuário na base de dados."];                
            }
        }

        //Se há erros, volta para o formulário
        
        //Carregar os valores recebidos por POST de volta para o formulário

        
        $dados["usuario"] = $usuario;
        $dados["confSenha"] = $confSenha;
        $dados["estados"] = $this->estadoDAO->list();
        $dados["papeis"] = $this->tipoUsuarioDAO->listSemADM();

        $msgsErro = is_array($erros) ? implode("<br>", $erros) : $erros;
        $this->loadView("usuario/form_cadastro.php", $dados, $msgsErro);
    }


}


#Criar objeto da classe para assim executar o construtor
new CadastroController();
