<?php
require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4">Minhas Candidaturas</h2>
            
            <?php if (empty($dados["lista"])): ?>
                <div class="alert alert-info">
                    Você ainda não se candidatou a nenhuma vaga.
                    <a href="<?= BASEURL ?>/controller/VagaController.php?action=listPublic" class="alert-link">Ver vagas disponíveis</a>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Vaga</th>
                                <th>Empresa</th>
                                <th>Cargo</th>
                                <th>Data da Candidatura</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($dados["lista"] as $candidatura): ?>
                                <tr>
                                    <td><?= htmlspecialchars($candidatura->getVaga()->getTitulo()) ?></td>
                                    <td><?= htmlspecialchars($candidatura->getVaga()->getEmpresa()->getNome()) ?></td>
                                    <td><?= htmlspecialchars($candidatura->getVaga()->getCargo()->getNome()) ?></td>
                                    <td><?= date('d/m/Y H:i', strtotime($candidatura->getDataCandidatura())) ?></td>
                                    <td>
                                        <span class="badge <?= $candidatura->getVaga()->getStatus() == 'Inativo' ? 'bg-primary' : 'bg-success' ?>">
                                            <?= $candidatura->getVaga()->getStatus() == 'Inativo' ? 'Finalizado' : 'Em Andamento' ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="<?= BASEURL ?>/controller/VagaController.php?action=viewVagas&id=<?= $candidatura->getVaga()->getId() ?>" 
                                           class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i> Ver Detalhes
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once(__DIR__ . "/../include/footer.php"); ?> 