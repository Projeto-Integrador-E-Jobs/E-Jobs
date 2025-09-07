<?php
require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>

<link rel="stylesheet" href="<?= BASEURL ?>/view/empresa/home.css">

<div class="container py-4">
    <div class="welcome-section">
        <h1 class="welcome-title">Bem-vindo(a), <?= htmlspecialchars($dados['empresa']->getNome()) ?>!</h1>
        <p class="welcome-subtitle">Gerencie suas vagas de forma eficiente</p>
    </div>

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