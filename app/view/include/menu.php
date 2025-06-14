<?php
#Nome do arquivo: view/include/menu.php
#Objetivo: menu da aplicação para ser incluído em outras páginas


$nome = "(Sessão expirada)";
if (isset($_SESSION[SESSAO_USUARIO_NOME]))
    $nome = $_SESSION[SESSAO_USUARIO_NOME];
if (isset($_SESSION[SESSAO_USUARIO_PAPEL]))
    $papel = $_SESSION[SESSAO_USUARIO_PAPEL];

$logado = isset($_SESSION[SESSAO_USUARIO_ID]);
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container">
        <?php if ($logado && ($papel == TipoUsuario::ID_CANDIDATO)): ?>
        <a class="navbar-brand" href="<?= HOME_PAGE ?>">
            <strong>EJobs</strong>
        </a>
        <?php elseif ($logado && $papel == TipoUsuario::ID_ADMINISTRADOR): ?>
        <a class="navbar-brand" href="<?= ADMINHOME_PAGE ?>">
            <strong>EJobs</strong>
        </a>
        <?php elseif ($logado && $papel == TipoUsuario::ID_EMPRESA): ?>
        <a class="navbar-brand" href="<?= EMPRESAHOME_PAGE ?>">
            <strong>EJobs</strong>
        </a>
        <?php else: ?>
        <a class="navbar-brand" href="<?= HOME_PAGE ?>">
            <strong>EJobs</strong>
        </a>    
        <?php endif; ?>

        <button class="navbar-toggler" type="button" data-toggle="collapse"
            data-target="#conteudoNavbarSuportado" aria-controls="conteudoNavbarSuportado"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="conteudoNavbarSuportado">
            <ul class="navbar-nav mr-auto">

                <li class="nav-item">
                    <a class="nav-link" href="<?= BASEURL . '/controller/VagaController.php?action=listPublic' ?>">Vagas</a>
                </li>

                <?php if ($logado && ($papel == TipoUsuario::ID_ADMINISTRADOR)): ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?= BASEURL ?>/controller/UsuarioController.php?action=listEmpresasPendentes">Empresas</a>
                </li>
                <?php endif; ?>

                <?php if ($logado && ($papel == TipoUsuario::ID_ADMINISTRADOR)): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown"
                            role="button" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false"> Cadastros </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item"
                                href="<?= BASEURL . '/controller/UsuarioController.php?action=list' ?>">Usuários</a>
                            <a class="dropdown-item" href="<?= BASEURL . '/controller/CategoriaController.php?action=list' ?>">Categorias</a>
                            <a class="dropdown-item"
                                href="<?= BASEURL . '/controller/CargoController.php?action=list' ?>">Cargos</a>
                        </div>
                    </li>
                <?php endif; ?>
            </ul>

            <ul class="navbar-nav ml-auto">
                <?php if ($logado): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown"
                            role="button" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <?php if ($papel == 3): ?>
                                <i class="fas fa-building mr-1"></i>
                            <?php else: ?>
                                <i class="fas fa-user-circle mr-1"></i>
                            <?php endif; ?>
                            <?= $nome ?>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="<?= BASEURL . '/controller/UsuarioController.php?action=viewProfile' ?>">Meu Perfil</a>
                            <?php if ($papel == TipoUsuario::ID_CANDIDATO): ?>
                                <a class="dropdown-item" href="<?= BASEURL ?>/controller/VagaController.php?action=minhasCandidaturas">Minhas Candidaturas</a>
                            <?php elseif ($papel == TipoUsuario::ID_ADMINISTRADOR): ?>
                                <a class="dropdown-item" href="<?= BASEURL ?>/controller/UsuarioController.php?action=list">Usuarios</a>
                            <?php elseif ($papel == TipoUsuario::ID_EMPRESA): ?>
                                    <a class="dropdown-item" href="<?= BASEURL ?>/controller/VagaController.php?action=list">Minhas Vagas</a>    
                            <?php else: ?>
                                <a class="dropdown-item" href="<?= BASEURL ?>/controller/CargoController.php?action=list">Cargos</a>
                            <?php endif; ?>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="<?= LOGOUT_PAGE ?>">Sair</a>
                        </div>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-light btn-sm mr-2 px-3" href="<?= BASEURL ?>/controller/LoginController.php?action=login">Login</a>
                    </li>
                    <li class="nav-item">
                         <a class="nav-link btn btn-cadastro btn-sm px-3" href="<?= BASEURL ?>/controller/CadastroController.php?action=create">Cadastre-se</a>

                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>