<?php
#Classe controller para Usuário
require_once(__DIR__ . "/ApiController.php");
require_once(__DIR__ . "/../dao/UsuarioDAO.php");
require_once(__DIR__ . "/../dao/TipoUsuarioDAO.php");
require_once(__DIR__ . "/../dao/EstadoDAO.php");
require_once(__DIR__ . "/../service/UsuarioService.php");
require_once(__DIR__ . "/../service/LoginService.php");
require_once(__DIR__ . "/../model/Usuario.php");
require_once(__DIR__ . "/../model/enum/Status.php");

class CadastroApiController extends ApiController {

    private UsuarioDAO $usuarioDao;
    private TipoUsuarioDAO $tipoUsuarioDAO;
    private EstadoDAO $estadoDao;
    private UsuarioService $usuarioService;
    private LoginService $loginService;

    public function __construct() {
    
        $this->usuarioDao = new UsuarioDAO();
        $this->tipoUsuarioDAO = new TipoUsuarioDAO();
        $this->estadoDao = new EstadoDAO();
        $this->usuarioService = new UsuarioService();
        $this->loginService = new LoginService();


        $this->handleAction();
    }

    protected function create() {
        $estados = $this->estadoDao->list();
        $papeis = $this->tipoUsuarioDAO->listSemAdm();
        
        $estadosArray = array_map(fn($e) => [
                                                "codigo_uf" => $e->getCodigoUf(),
                                                "nome" => $e->getNome()
                                            ], $estados);

        $papeisArray = array_map(fn($p) => [
                                                "id" => $p->getId(),
                                                "nome" => $p->getNome()
                                            ], $papeis);

        $this->jsonResponse([
                            "success" => true,
                            "estados" => $estadosArray,
                            "papeis" => $papeisArray
                        ]);
        
    }

    protected function save() {
        $dados = [
                    "estados" => $this->estadoDao->listJson() ?: [],
                    "papeis" => $this->tipoUsuarioDAO->listJson() ?: []
        ];

        //Captura os dados do formulário
        $input = json_decode(file_get_contents("php://input"), true);
        $idTipoUsuario = isset($input['tipoUsuario']) && is_numeric($input['tipoUsuario']) ? (int)$input['tipoUsuario'] : NULL;
        $nome = isset($input['nome']) ? trim((string)$input['nome']) : null;
        $email = isset($input['email']) ? trim((string)$input['email']) : null;
        $senha = isset($input['senha']) ? trim((string)$input['senha']) : null;
        $confSenha = isset($input['conf_senha']) ? trim((string)$input['conf_senha']) : null;
        
        $documento = NULL;
        if(isset($input['documento']))
            $documento  = isset($input['documento']) ? trim((string)$input['documento']) : null;
        
        $descricao  = isset($input['descricao'])  ? trim((string)$input['descricao'])  : null;
        $estadoId = isset($input['estado']) && is_numeric($input['estado']) ? $input['estado'] : NULL;
        $cidadeId = isset($input['cidade']) ? trim($input['cidade']) : NULL;
        $endLogradouro = isset($input['endLogradouro']) ? trim($input['endLogradouro']) : NULL;
        $endBairro = isset($input['endBairro']) ? trim($input['endBairro']) : NULL;
        $endNumero = isset($input['endNumero']) ? trim($input['endNumero']) : NULL;
        $telefone = isset($input['telefone']) ? trim($input['telefone']) : NULL;
        
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
                if($usuario->getStatus() == Status::ATIVO){                  
                    $this->loginService->salvarUsuarioSessao($usuario);
                    
                  $this->jsonResponse([
                            "success" => true,
                            "usuario" => [
                                "tipoUsuario" => $usuario->getTipoUsuario()->getId() ?? "",
                                "nome" => $usuario->getNome() ?? "",
                            ]
                    ]);

                
                    exit;
                } else { $this->jsonResponse([
                            "success" => true,
                            "status" => "pendente"
                        ]);
                    }
            } catch (PDOException $e) {
                $erros = ["Erro ao salvar o usuário na base de dados."];                
            }
        }

        //Se há erros, volta para o formulário
        
        //Carregar os valores recebidos por POST de volta para o formulário

        $user = [
                "tipoUsuario" => $usuario->getTipoUsuario()->getId() ?? "",
                "nome" => $usuario->getNome() ?? "",
                "email" => $usuario->getEmail() ?? "",
                "senha" => $usuario->getSenha() ?? "",
                "documento" => $usuario->getDocumento() ?? "",
                "descricao" => $usuario->getDescricao() ?? "",
                "cidade" => [ "id" => $cidade->getCodigoIbge() ?? "",
                              "uf" => ["codigoUf" => $cidade->getEstado()->getCodigoUf()]],
                "endLogradouro" => $usuario->getEndLogradouro() ?? "",
                "endBairro" => $usuario->getEndBairro() ?? "",
                "endNumero" => $usuario->getEndNumero() ?? "",
                "telefone" => $usuario->getTelefone() ?? "",
         ];
        $dados["usuario"] = $user;
        $dados["confSenha"] = $confSenha;
        $dados["estados"] = $this->estadoDao->listJson();
        $dados["papeis"] = $this->tipoUsuarioDAO->listJson();

         $this->jsonResponse([
            "success" => false,
            "errors" => $erros,
            "dados" => $dados
        ], 400);
    }

}

#Criar objeto da classe para assim executar o construtor
new CadastroApiController();
