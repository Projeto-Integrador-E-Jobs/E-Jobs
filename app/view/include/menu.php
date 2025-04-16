<?php
#Nome do arquivo: view/include/menu.php
#Objetivo: menu da aplicação para ser incluído em outras páginas

$nome = "(Sessão expirada)";
if (isset($_SESSION[SESSAO_USUARIO_NOME]))
    $nome = $_SESSION[SESSAO_USUARIO_NOME];

$logado = isset($_SESSION[SESSAO_USUARIO_ID]);
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="<?= HOME_PAGE ?>">
            <strong>EJobs</strong>
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse"
            data-target="#conteudoNavbarSuportado" aria-controls="conteudoNavbarSuportado"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="conteudoNavbarSuportado">
            <ul class="navbar-nav mr-auto">

                <li class="nav-item">
                    <a class="nav-link" href="#">Vagas</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">Empresas</a>
                </li>

                <?php if ($logado): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown"
                            role="button" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false"> Cadastros </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item"
                                href="<?= BASEURL . '/controller/UsuarioController.php?action=list' ?>">Usuários</a>
                            <a class="dropdown-item" href="#">Outro cadastro</a>
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
                            <i class="fas fa-user-circle mr-1"></i> <?= $nome ?>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="#">Meu Perfil</a>
                            <a class="dropdown-item" href="#">Minhas Candidaturas</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="<?= LOGOUT_PAGE ?>">Sair</a>
                        </div>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-light btn-sm mr-2 px-3" href="<?= BASEURL ?>/login.php">Login</a>
                    </li>
                    <li class="nav-item">
                         <a class="nav-link btn btn-cadastro btn-sm px-3" href="<?= BASEURL ?>/cadastro.php">Cadastre-se</a>

                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>