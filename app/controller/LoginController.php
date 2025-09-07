<?php 
#Classe controller para a Logar do sistema
require_once(__DIR__ . "/Controller.php");
require_once(__DIR__ . "/../dao/UsuarioDAO.php");
require_once(__DIR__ . "/../service/LoginService.php");
require_once(__DIR__ . "/../model/Usuario.php");
require_once(__DIR__ . "/../model/TipoUsuario.php");
require_once(__DIR__ . "/../model/enum/Status.php");

class LoginController extends Controller {

    private LoginService $loginService;
    private UsuarioDAO $usuarioDao;

    public function __construct() {
        $this->loginService = new LoginService();
        $this->usuarioDao = new UsuarioDAO();
        
        $this->handleAction();
    }

    protected function login() {
        $this->loadView("login/login.php", []);
    }

    /* Método para logar um usuário a partir dos dados informados no formulário */
    protected function logon() {
        $email = isset($_POST['email']) ? trim($_POST['email']) : null;
        $senha = isset($_POST['senha']) ? trim($_POST['senha']) : null;

        //Validar os campos
        $erros = $this->loginService->validarCampos($email, $senha);
        if(empty($erros)) {
            //Valida o login a partir do banco de dados
            $usuario = $this->usuarioDao->findByLoginSenha($email, $senha);
            
        if($usuario) {
            
            switch ($usuario->getStatus()){
               
                case Status::ATIVO:
                    
                        //Se encontrou o usuário, salva a sessão e redireciona para a HOME do sistema
                        $this->loginService->salvarUsuarioSessao($usuario);

                        // Redireciona baseado no tipo de usuário
                        switch ($usuario->getTipoUsuario()->getId()) {
                            case TipoUsuario::ID_CANDIDATO:
                                header("location: " . HOME_PAGE);
                                break;
                            case TipoUsuario::ID_ADMINISTRADOR: 
                                header("location: " . BASEURL . "/controller/AdminController.php?action=home");
                                break;
                            case TipoUsuario::ID_EMPRESA: 
                                header("location: " . BASEURL . "/controller/EmpresaController.php?action=home");
                                break;
                            default:
                                header("location: " . HOME_PAGE);
                        }
                        exit;
                     
                    break;
                case Status::PENDENTE:
                    $erros = ["Aguardando aprovação do admin!"];
                    break;
                case Status::INATIVO:
                    $erros = ["Usúario está inativo!"];
                    break;
            }
        }  else {
                    $erros = ["Login ou senha informados são inválidos!"];
                }
        }

        //Se há erros, volta para o formulário            
        $msg = implode("<br>", $erros);
        $dados["email"] = $email;
        $dados["senha"] = $senha;

        $this->loadView("login/login.php", $dados, $msg);
    }

     /* Método para logar um usuário a partir dos dados informados no formulário */
    protected function logout() {
        $this->loginService->removerUsuarioSessao();

        $this->loadView("login/login.php", [], "", "Usuário deslogado com suscesso!");
    }

}


#Criar objeto da classe para assim executar o construtor
new LoginController();
