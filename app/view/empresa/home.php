<?php
require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>

<style>
.dashboard-card {
    transition: transform 0.2s, box-shadow 0.2s;
    border: 1.5px solid #e3e3e3;
    border-radius: 1rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    background: #fff;
    height: 100%;
}

.dashboard-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 24px rgba(0,0,0,0.13);
    border-color: #0d6efd;
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
}

.stat-label {
    color: #666;
    font-size: 1.1rem;
}

.welcome-section {
    background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
    color: white;
    padding: 2rem;
    border-radius: 1rem;
    margin-bottom: 2rem;
}

.welcome-title {
    font-size: 1.8rem;
    margin-bottom: 0.5rem;
}

.welcome-subtitle {
    font-size: 1.1rem;
    opacity: 0.9;
}

.vaga-card {
    border: none;
    border-radius: 1rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    transition: transform 0.2s;
    margin-bottom: 1rem;
}

.vaga-card:hover {
    transform: translateY(-3px);
}

.vaga-icon {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: #e9ecef;
    color: #0d6efd;
}
</style>

<div class="container py-4">
    <!-- Welcome Section -->
    <div class="welcome-section">
        <h1 class="welcome-title">Bem-vindo(a), <?= htmlspecialchars($dados['empresa']->getNome()) ?>!</h1>
        <p class="welcome-subtitle">Gerencie suas vagas de forma eficiente</p>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-6 mb-4">
            <div class="dashboard-card p-4 text-center">
                <div class="dashboard-icon">
                    <i class="fas fa-briefcase"></i>
                </div>
                <div class="stat-number"><?= $dados['total_vagas'] ?></div>
                <div class="stat-label">Vagas Ativas</div>
                <a href="<?= BASEURL ?>/controller/VagaController.php?action=list" class="btn btn-outline-primary mt-3">
                    <i class="fas fa-list me-1"></i> Ver Todas
                </a>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="dashboard-card p-4 text-center">
                <div class="dashboard-icon">
                    <i class="fas fa-plus-circle"></i>
                </div>
                <div class="stat-label">Nova Vaga</div>
                <a href="<?= BASEURL ?>/controller/VagaController.php?action=create" class="btn btn-primary mt-3">
                    <i class="fas fa-plus me-1"></i> Criar Vaga
                </a>
            </div>
        </div>
    </div>

    <!-- Vagas Ativas -->
    <div class="row">
        <div class="col-12">
            <div class="dashboard-card p-4">
                <h4 class="mb-3">
                    <i class="fas fa-star me-2"></i>
                    Vagas Ativas
                </h4>
                <?php if (!empty($dados['vagas_destaque'])): ?>
                    <div class="list-group">
                        <?php foreach ($dados['vagas_destaque'] as $vaga): ?>
                            <div class="list-group-item vaga-card">
                                <div class="d-flex align-items-center">
                                    <div class="vaga-icon me-3">
                                        <i class="fas fa-briefcase"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1"><?= htmlspecialchars($vaga->getTitulo()) ?></h6>
                                        <small class="text-muted">
                                            <?= htmlspecialchars($vaga->getCargo()->getNome()) ?> • 
                                            <?= htmlspecialchars($vaga->getModalidade()) ?>
                                        </small>
                                    </div>
                                    <span class="badge bg-success">
                                        <?= htmlspecialchars($vaga->getStatus()) ?>
                                    </span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="text-muted">Nenhuma vaga ativa no momento</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php require_once(__DIR__ . "/../include/footer.php"); ?> 