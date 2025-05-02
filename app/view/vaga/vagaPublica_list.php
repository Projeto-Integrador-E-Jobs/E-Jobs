<?php
require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>

<style>
.vaga-card {
    transition: transform 0.2s, box-shadow 0.2s, border-color 0.2s;
    border: 1.5px solid #e3e3e3;
    border-radius: 1rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    background: #fff;
}
.vaga-card:hover {
    transform: translateY(-6px) scale(1.03);
    box-shadow: 0 8px 24px rgba(0,0,0,0.13);
    border-color: #0d6efd;
    z-index: 2;
}
.vaga-icon {
    width: 22px;
    text-align: center;
    color: #0d6efd;
    margin-right: 8px;
}
.vaga-label {
    font-weight: 500;
    color: #333;
}
.vaga-info {
    color: #555;
}
</style>

<h3 class="text-center">Vagas</h3>

<?php if (!empty($dados['search_term'])): ?>
    <h5 class="text-center">Resultados para: "<?= htmlspecialchars($dados['search_term']) ?>"</h5>
<?php endif; ?>

<div class="container">
    <div class="row">
        <div class="col-9">
            <?php require_once(__DIR__ . "/../include/msg.php"); ?>
        </div>
    </div>

    <div class="row" style="margin-top: 10px;">
        <div class="col-12">
            <?php if (empty($dados['lista'])): ?>
                <div class="alert alert-warning text-center">Nenhuma vaga encontrada.</div>
            <?php else: ?>
                <div class="row">
                    <?php foreach($dados['lista'] as $vaga): ?>
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="vaga-card h-100 p-4 d-flex flex-column">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-briefcase vaga-icon"></i>
                                    <span class="vaga-label fs-5 flex-grow-1"> <?= htmlspecialchars($vaga->getTitulo()); ?> </span>
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-building vaga-icon"></i>
                                    <span class="vaga-label">Empresa:</span>
                                    <span class="vaga-info ms-1"> <?= htmlspecialchars($vaga->getEmpresa()->getNome()); ?> </span>
                                </div>
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fas fa-laptop-house vaga-icon"></i>
                                    <span class="vaga-label">Modalidade:</span>
                                    <span class="vaga-info ms-1"> <?= htmlspecialchars($vaga->getModalidade()); ?> </span>
                                </div>
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fas fa-clock vaga-icon"></i>
                                    <span class="vaga-label">Horário:</span>
                                    <span class="vaga-info ms-1"> <?= htmlspecialchars($vaga->getHorario()); ?> </span>
                                </div>
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fas fa-file-contract vaga-icon"></i>
                                    <span class="vaga-label">Regime:</span>
                                    <span class="vaga-info ms-1"> <?= htmlspecialchars($vaga->getRegime()); ?> </span>
                                </div>
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fas fa-money-bill-wave vaga-icon"></i>
                                    <span class="vaga-label">Salário:</span>
                                    <span class="vaga-info ms-1"> R$ <?= number_format($vaga->getSalario(), 2, ',', '.'); ?> </span>
                                </div>
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fas fa-user-tie vaga-icon"></i>
                                    <span class="vaga-label">Cargo:</span>
                                    <span class="vaga-info ms-1"> <?= htmlspecialchars($vaga->getCargo()->getNome()); ?> </span>
                                </div>
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fas fa-tasks vaga-icon"></i>
                                    <span class="vaga-label">Requisitos:</span>
                                    <span class="vaga-info ms-1"> <?= htmlspecialchars($vaga->getRequisitos()); ?> </span>
                                </div>
                                <div class="d-flex align-items-start mb-2">
                                    <i class="fas fa-align-left vaga-icon mt-1"></i>
                                    <span class="vaga-label">Descrição:</span>
                                    <span class="vaga-info ms-1"> <?= htmlspecialchars($vaga->getDescricao()); ?> </span>
                                </div>
                                <div class="mt-auto text-end">
                                    <!-- Botão de detalhes pode ser adicionado aqui futuramente -->
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php  
require_once(__DIR__ . "/../include/footer.php");
?>
