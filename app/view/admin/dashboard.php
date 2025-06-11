<?php
require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>

<link rel="stylesheet" href="<?= BASEURL ?>/view/admin/dashboard.css">

<div class="container py-4">
    <h2 class="text-center mb-4">Painel Administrativo</h2>

    <div class="row mb-4">
        <div class="col-md-4 mb-4">
            <div class="dashboard-card p-4 text-center">
                <div class="dashboard-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-number"><?= count($dados['usuarios']) ?></div>
                <div class="stat-label">Total de Usuários</div>
                <a href="<?= BASEURL ?>/controller/UsuarioController.php?action=list" class="btn btn-outline-primary mt-3">
                    <i class="fas fa-list me-1"></i> Gerenciar Usuários
                </a>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="dashboard-card p-4 text-center">
                <div class="dashboard-icon">
                    <i class="fas fa-briefcase"></i>
                </div>
                <div class="stat-number"><?= count($dados['categorias']) ?></div>
                <div class="stat-label">Categorias</div>
                <a href="<?= BASEURL ?>/controller/CategoriaController.php?action=list" class="btn btn-outline-primary mt-3">
                    <i class="fas fa-list me-1"></i> Gerenciar Categorias
                </a>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="dashboard-card p-4 text-center">
                <div class="dashboard-icon">
                    <i class="fas fa-user-tie"></i>
                </div>
                <div class="stat-number"><?= count($dados['cargos']) ?></div>
                <div class="stat-label">Cargos</div>
                <a href="<?= BASEURL ?>/controller/CargoController.php?action=list" class="btn btn-outline-primary mt-3">
                    <i class="fas fa-list me-1"></i> Gerenciar Cargos
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Ações Rápidas</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <a href="<?= BASEURL ?>/controller/UsuarioController.php?action=create" class="btn btn-success w-100">
                                <i class="fas fa-user-plus me-2"></i>Novo Usuário
                            </a>
                        </div>
                        <div class="col-md-4 mb-3">
                            <a href="<?= BASEURL ?>/controller/CategoriaController.php?action=create" class="btn btn-success w-100">
                                <i class="fas fa-folder-plus me-2"></i>Nova Categoria
                            </a>
                        </div>
                        <div class="col-md-4 mb-3">
                            <a href="<?= BASEURL ?>/controller/CargoController.php?action=create" class="btn btn-success w-100">
                                <i class="fas fa-plus-circle me-2"></i>Novo Cargo
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php require_once(__DIR__ . "/../include/footer.php"); ?> 