<?php
require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>

<h3 class="text-center">Candidatos da Vaga: <?= htmlspecialchars($dados['vaga']->getTitulo()) ?></h3>

<div class="container">
    <div class="row">
        <div class="col-3">
            <a class="btn btn-secondary" 
                href="<?= BASEURL ?>/controller/VagaController.php?action=list">
                Voltar</a>
        </div>

        <div class="col-9">
            <?php require_once(__DIR__ . "/../include/msg.php"); ?>
        </div>
    </div>

    <div class="row" style="margin-top: 10px;">
        <div class="col-12">
            <?php if (empty($dados['lista'])): ?>
                <div class="alert alert-warning text-center">Nenhum candidato encontrado para esta vaga.</div>
            <?php else: ?>
                <table id="tabCandidatos" class='table table-striped table-bordered'>
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Data da Candidatura</th>
                            <th>Perfil</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($dados['lista'] as $candidatura): ?>
                            <tr>
                                <td><?= htmlspecialchars($candidatura->getCandidato()->getNome()) ?></td>
                                <td><?= htmlspecialchars($candidatura->getCandidato()->getEmail()) ?></td>
                                <td><?= date('d/m/Y', strtotime($candidatura->getDataCandidatura())) ?></td>
                                <td>
                                    <a class="btn btn-info" 
                                        href="<?= BASEURL ?>/controller/CandidaturaController.php?action=viewCandidato&id=<?= $candidatura->getCandidato()->getId() ?>">
                                        <i class="fas fa-user"></i> Visualizar Perfil
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php  
require_once(__DIR__ . "/../include/footer.php");
?> 