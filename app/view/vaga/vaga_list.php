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
                Inserir</a>
        </div>

        <div class="col-9">
            <?php require_once(__DIR__ . "/../include/msg.php"); ?>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        <?php foreach($dados['lista'] as $vaga): ?>
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title"><?= $vaga->getTitulo(); ?></h5>
                        <h6 class="card-subtitle mb-2 text-muted"><?= $vaga->getEmpresa()->getNome(); ?></h6>
                        
                        <div class="card-text">
                            <p><strong>Cargo:</strong> <?= $vaga->getCargo()->getNome(); ?></p>
                            <p><strong>Modalidade:</strong> <?= $vaga->getModalidade(); ?></p>
                            <p><strong>Horário:</strong> <?= $vaga->getHorario(); ?></p>
                            <p><strong>Regime:</strong> <?= $vaga->getRegime(); ?></p>
                            <p><strong>Salário:</strong> <?= $vaga->getSalario(); ?></p>
                            <p><strong>Descrição:</strong> <?= $vaga->getDescricao(); ?></p>
                            <p><strong>Requisitos:</strong> <?= $vaga->getRequisitos(); ?></p>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-top-0">
                        <div class="d-flex justify-content-between">
                            <a class="btn btn-primary btn-sm" 
                                href="<?= BASEURL ?>/controller/VagaController.php?action=edit&id=<?= $vaga->getId() ?>">
                                Alterar
                            </a>
                            <a class="btn btn-danger btn-sm" 
                                onclick="return confirm('Confirma a exclusão da vaga?');"
                                href="<?= BASEURL ?>/controller/VagaController.php?action=delete&id=<?= $vaga->getId() ?>">
                                Excluir
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php  
require_once(__DIR__ . "/../include/footer.php");
?>
