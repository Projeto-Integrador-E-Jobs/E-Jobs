<?php
require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>

<h3 class="text-center mb-4">Vagas</h3>

<div class="container">
    <div class="row mb-4">
        <div class="col-3">
            <a class="btn btn-success" 
                href="<?= BASEURL ?>/controller/VagaController.php?action=create">
                <i class="fas fa-plus me-1"></i>Inserir</a>
        </div>

        <div class="col-9">
            <?php require_once(__DIR__ . "/../include/msg.php"); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead class="table-primary">
                        <tr>
                            <th>Título</th>
                            <th>Empresa</th>
                            <th>Cargo</th>
                            <th>Modalidade</th>
                            <th>Regime</th>
                            <th>Salário</th>
                            <th>Status</th>
                            <th class="text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($dados['lista'] as $vaga): ?>
                            <tr>
                                <td><?= $vaga->getTitulo(); ?></td>
                                <td><?= $vaga->getEmpresa()->getNome(); ?></td>
                                <td><?= $vaga->getCargo()->getNome(); ?></td>
                                <td><?= $vaga->getModalidade(); ?></td>
                                <td><?= $vaga->getRegime(); ?></td>
                                <td>R$ <?= number_format($vaga->getSalario(), 2, ',', '.'); ?></td>
                                <td><?= $vaga->getStatus(); ?></td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-info btn-sm" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalDetalhes<?= $vaga->getId() ?>">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <a class="btn btn-primary btn-sm" 
                                            href="<?= BASEURL ?>/controller/VagaController.php?action=edit&id=<?= $vaga->getId() ?>">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a class="btn btn-danger btn-sm" 
                                            onclick="return confirm('Confirma a exclusão da vaga?');"
                                            href="<?= BASEURL ?>/controller/VagaController.php?action=delete&id=<?= $vaga->getId() ?>">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>

                                    <!-- Modal de Detalhes -->
                                    <div class="modal fade" id="modalDetalhes<?= $vaga->getId() ?>" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header bg-primary text-white">
                                                    <h5 class="modal-title">Detalhes da Vaga</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <p><strong>Descrição:</strong></p>
                                                            <p><?= nl2br($vaga->getDescricao()); ?></p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p><strong>Requisitos:</strong></p>
                                                            <p><?= nl2br($vaga->getRequisitos()); ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php  
require_once(__DIR__ . "/../include/footer.php");
?>