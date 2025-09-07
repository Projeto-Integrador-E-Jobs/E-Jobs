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
<link rel="stylesheet" href="/app/view/vaga/vaga.css"> 

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
    <form method="GET" action="<?= BASEURL ?>/controller/VagaController.php">
        <input type="hidden" name="action" value="listPublic">
        <div class="row justify-content-center mt-3">
            <div class="col-md-3">
                        <input type="text" name="search" class="form-control"
                            placeholder="Digite o título da vaga"
                            value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>"
                            >
            </div>

            <div class="col-md-3">
                        <input type="text" id="inputCidade" list="listaCidades" 
                            name="cidade" class="form-control" autocomplete="off"
                            placeholder="Busca por cidade"
                            value="<?= isset($_GET['cidade']) ? htmlspecialchars($_GET['cidade']) : '' ?>"
                            >
                        <input type="hidden" id="cidadeId" name="cidade_id">    
                        <datalist id="listaCidades"></datalist>
                        
            </div>

            <div class="col-md-2">
                <select class="form-control" name="idCategoria">
                    <option value="">Categoria</option>
                    <?php foreach($dados["categorias"] as $categoria): ?>
                        <option value="<?= $categoria->getId() ?>" <?= (isset($_GET["idCategoria"]) && $_GET["idCategoria"] == $categoria->getId()) ? "selected" : "" ?>>
                            <?= $categoria->getNome() ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-2">
                <select class="form-control" name="cargo_id">
                    <option value="">Cargo</option>
                    <?php foreach($dados["cargos"] as $cargo): ?>
                        <option value="<?= $cargo->getId() ?>" <?= (isset($_GET["cargo_id"]) && $_GET["cargo_id"] == $cargo->getId()) ? "selected" : "" ?>>
                            <?= $cargo->getNome() ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="row justify-content-center mt-3">
            <div class="col-md-2">
                <select class="form-control" name="modalidade">
                    <option value="">Modalidade</option>
                    <?php foreach($dados["modalidades"] as $modal): ?>
                        <option value="<?= $modal ?>" <?= (isset($_GET["modalidade"]) && $_GET["modalidade"] === $modal) ? "selected" : "" ?>>
                            <?= $modal ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-2">
                <select class="form-control" name="horario">
                    <option value="">Horário</option>
                    <?php foreach($dados["horarios"] as $horario): ?>
                        <option value="<?= $horario ?>" <?= (isset($_GET["horario"]) && $_GET["horario"] === $horario) ? "selected" : "" ?>>
                            <?= $horario ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-2">
                <select class="form-control" name="regime">
                    <option value="">Regime</option>
                    <?php foreach($dados["regimes"] as $regime): ?>
                        <option value="<?= $regime ?>" <?= (isset($_GET["regime"]) && $_GET["regime"] === $regime) ? "selected" : "" ?>>
                            <?= $regime ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-2">
                <select class="form-control" name="salario">
                    <option value="">Salário</option>
                    <?php foreach($dados["salarios"] as $salario): ?>
                        <option value="<?= $salario ?>" <?= (isset($_GET["salario"]) && $_GET["salario"] === $salario) ? "selected" : "" ?>>
                            <?= $salario ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-2">
                <button type="submit" class="btn btn-success w-100">Filtrar</button>
            </div>
        </div>
    </form>

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
                                    <a href="VagaController.php?action=viewVagas&id=<?= $vaga->getId() ?>" class="btn btn-primary">
                                        <i class="fas fa-info-circle me-1"></i>Detalhes
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php if ($dados['total_paginas'] > 1): ?>
    <nav>
        <ul class="pagination d-flex justify-content-center mt-4" >
            <?php for ($i = 1; $i <= $dados['total_paginas']; $i++): ?>
                <li class="page-item <?= ($dados['pagina_atual'] == $i) ? 'active' : '' ?>">
                     <a class="page-link" href="<?= BASEURL ?>/controller/VagaController.php?action=listPublic&page=<?= $i ?>&<?= $dados["queryString"] ?>">
                        <?= $i ?>
                    </a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
    <?php endif; ?>


</div>
<script> var BASEURL = "<?= BASEURL ?>"; </script>
<script src="<?= BASEURL ?>/view/vaga/js/cidades.js"></script>
<?php  
require_once(__DIR__ . "/../include/footer.php");
?>
