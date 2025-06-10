<?php
require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>

<div class="container py-4">
    <h2 class="text-center mb-4">Painel Administrativo</h2>

    <!-- Stats Cards -->
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

    <!-- Quick Actions -->
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

<style>
.dashboard-card {
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    transition: transform 0.2s;
}

.dashboard-card:hover {
    transform: translateY(-5px);
}

.dashboard-icon {
    font-size: 2.5rem;
    color: #0d6efd;
    margin-bottom: 1rem;
}

.stat-number {
    font-size: 2rem;
    font-weight: bold;
    color: #333;
    margin-bottom: 0.5rem;
}

.stat-label {
    font-size: 1.1rem;
    color: #666;
    margin-bottom: 1rem;
}
</style>

<?php require_once(__DIR__ . "/../include/footer.php"); ?> 