<?php
require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0">Perfil do Candidato</h3>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <strong>Nome:</strong>
                        </div>
                        <div class="col-md-8">
                            <?= htmlspecialchars($dados['candidato']->getNome()) ?>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <strong>Email:</strong>
                        </div>
                        <div class="col-md-8">
                            <?= htmlspecialchars($dados['candidato']->getEmail()) ?>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <strong>Telefone:</strong>
                        </div>
                        <div class="col-md-8">
                            <?= htmlspecialchars($dados['candidato']->getTelefone()) ?>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <strong>Descrição:</strong>
                        </div>
                        <div class="col-md-8">
                            <?= nl2br(htmlspecialchars($dados['candidato']->getDescricao())) ?>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="<?= BASEURL ?>/controller/VagaController.php?action=viewCandidatos&id=<?= $dados['vaga_id'] ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Voltar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once(__DIR__ . "/../include/footer.php"); ?> 