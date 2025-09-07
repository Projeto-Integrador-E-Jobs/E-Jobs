<?php
require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>

<link rel="stylesheet" href="vaga.css">

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="detalhes-card">

                <?php include_once(__DIR__ . "/../include/msg.php") ?>
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="mb-0"><?= htmlspecialchars($dados['vaga']->getTitulo()); ?></h3>
                    <div>
                        <a href="VagaController.php?action=listPublic" class="btn btn-outline-primary me-2">
                            <i class="fas fa-arrow-left me-1"></i>Voltar
                        </a>
                        <?php if (isset($_SESSION[SESSAO_USUARIO_ID])): ?>
                            <?php if (isset($dados['candidatura'])): ?>
                                <button class="btn btn-secondary" disabled>
                                    <i class="fas fa-check me-1"></i>Candidatura já realizada
                                </button>
                            <?php else: ?>
                                <a href="CandidaturaController.php?action=candidatar&id=<?= $dados['vaga']->getId() ?>" class="btn btn-success">
                                    <i class="fas fa-paper-plane me-1"></i>Candidatar-se
                                </a>
                            <?php endif; ?>
                        <?php else: ?>
                            <a href="<?= BASEURL ?>/controller/LoginController.php?action=login" class="btn btn-success">
                                <i class="fas fa-sign-in-alt me-1"></i>Login para se candidatar
                            </a>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-building detalhes-icon"></i>
                            <span class="detalhes-label">Empresa:</span>
                            <span class="detalhes-info"><?= htmlspecialchars($dados['vaga']->getEmpresa()->getNome()); ?></span>
                        </div>

                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-user-tie detalhes-icon"></i>
                            <span class="detalhes-label">Cargo:</span>
                            <span class="detalhes-info"><?= htmlspecialchars($dados['vaga']->getCargo()->getNome()); ?></span>
                        </div>

                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-laptop-house detalhes-icon"></i>
                            <span class="detalhes-label">Modalidade:</span>
                            <span class="detalhes-info"><?= htmlspecialchars($dados['vaga']->getModalidade()); ?></span>
                        </div>

                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-clock detalhes-icon"></i>
                            <span class="detalhes-label">Horário:</span>
                            <span class="detalhes-info"><?= htmlspecialchars($dados['vaga']->getHorario()); ?></span>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-file-contract detalhes-icon"></i>
                            <span class="detalhes-label">Regime:</span>
                            <span class="detalhes-info"><?= htmlspecialchars($dados['vaga']->getRegime()); ?></span>
                        </div>

                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-money-bill-wave detalhes-icon"></i>
                            <span class="detalhes-label">Salário:</span>
                            <span class="detalhes-info">R$ <?= number_format($dados['vaga']->getSalario(), 2, ',', '.'); ?></span>
                        </div>

                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-toggle-on detalhes-icon"></i>
                            <span class="detalhes-label">Status:</span>
                            <span class="detalhes-info"><?= htmlspecialchars($dados['vaga']->getStatus()); ?></span>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <div class="mb-4">
                        <h5 class="mb-3">
                            <i class="fas fa-tasks detalhes-icon"></i>
                            Requisitos
                        </h5>
                        <p class="detalhes-info"><?= (htmlspecialchars($dados['vaga']->getRequisitos())); ?></p>
                    </div>

                    <div>
                        <h5 class="mb-3">
                            <i class="fas fa-align-left detalhes-icon"></i>
                            Descrição
                        </h5>
                        <p class="detalhes-info"><?= (htmlspecialchars($dados['vaga']->getDescricao())); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require_once(__DIR__ . "/../include/footer.php");
?> 