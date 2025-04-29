<?php
require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="<?= BASEURL ?>/view/include/header.css">
<link rel="stylesheet" href="<?= BASEURL ?>/view/vaga/vaga.css">


<h3 class="text-center mb-4">Vagas Disponíveis</h3>

<div class="container">
    <div class="row">
        <div class="col-12">
            <?php require_once(__DIR__ . "/../include/msg.php"); ?>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        <?php foreach($dados['lista'] as $vaga): ?>
            <div class="col">
                <div class="card h-100 border-0 rounded-3 shadow-sm hover-shadow transition-all">
                    <div class="card-header bg-primary text-white rounded-top-3">
                        <h5 class="card-title mb-0"><?= $vaga->getTitulo(); ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="company-logo me-3">
                                <i class="fas fa-building fa-2x text-primary"></i>
                            </div>
                            <div>
                                <h6 class="mb-0"><?= $vaga->getEmpresa()->getNome(); ?></h6>
                                <small class="text-muted"><?= $vaga->getCargo()->getNome(); ?></small>
                            </div>
                        </div>

                        <div class="job-details">
                            <div class="d-flex justify-content-between mb-2">
                                <span><i class="fas fa-clock text-primary"></i> <?= $vaga->getHorario(); ?></span>
                                <span><i class="fas fa-calendar-alt text-primary"></i> <?= $vaga->getRegime(); ?></span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span><i class="fas fa-laptop-house text-primary"></i> <?= $vaga->getModalidade(); ?></span>
                                <span><i class="fas fa-money-bill-wave text-primary"></i> <?= $vaga->getSalario(); ?></span>
                            </div>
                        </div>

                        <div class="mt-3">
                            <h6 class="text-primary mb-2">Descrição</h6>
                            <p class="small text-muted"><?= $vaga->getDescricao(); ?></p>
                        </div>

                        <div class="mt-3">
                            <h6 class="text-primary mb-2">Requisitos</h6>
                            <p class="small text-muted"><?= $vaga->getRequisitos(); ?></p>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-top-0">
                        <button class="btn btn-outline-primary w-100">
                            <i class="fas fa-paper-plane me-2"></i> Candidatar-se
                        </button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>



<?php  
require_once(__DIR__ . "/../include/footer.php");
?>