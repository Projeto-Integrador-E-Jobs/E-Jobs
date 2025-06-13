<?php
require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Perfil do Candidato</h4>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <a href="<?= BASEURL ?>/controller/CandidaturaController.php?action=listarCandidatos" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Voltar
                        </a>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Nome:</strong> <?= htmlspecialchars($dados['candidato']->getNome()) ?></p>
                            <p><strong>Email:</strong> <?= htmlspecialchars($dados['candidato']->getEmail()) ?></p>
                            <p><strong>Telefone:</strong> <?= htmlspecialchars($dados['candidato']->getTelefone()) ?></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Cidade:</strong> <?= htmlspecialchars($dados['candidato']->getCidade()?->getNome()) ?></p>
                            <p><strong>Estado:</strong> <?= htmlspecialchars($dados['candidato']->getCidade()?->getEstado()?->getUf()) ?></p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <h5>Descrição</h5>
                        <p><?= htmlspecialchars($dados['candidato']->getDescricao()) ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require_once(__DIR__ . "/../include/footer.php");
?> 