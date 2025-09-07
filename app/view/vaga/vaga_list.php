<?php
require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>

<h3 class="text-center">Vagas</h3>

<div class="container">
    <div class="row">
        <div class="col-3">
            <a class="btn btn-success" 
                href="<?= BASEURL ?>/controller/VagaController.php?action=create">
                Inserir</a>
        </div>

        <?php if(isset($dados["show_status_filter"]) && $dados["show_status_filter"]): ?>
        <div class="col-3">
            <form method="GET" action="<?= BASEURL ?>/controller/VagaController.php" class="d-flex">
                <input type="hidden" name="action" value="listUsuario">
                <select name="status" class="form-select" onchange="this.form.submit()">
                    <option value="">Todos os Status</option>
                    <?php 
                    if(isset($dados["status"]) && is_array($dados["status"])) {
                        foreach($dados["status"] as $status): ?>
                            <option value="<?= $status ?>"><?= $status ?></option>
                        <?php endforeach;
                    }
                    ?>
                </select>
            </form>
        </div>
        <?php endif; ?>

        <div class="col-<?= isset($dados["show_status_filter"]) && $dados["show_status_filter"] ? '6' : '9' ?>">
            <?php require_once(__DIR__ . "/../include/msg.php"); ?>
        </div>
    </div>

    <div class="row" style="margin-top: 10px;">
        <div class="col-12">
            <?php if (empty($dados['lista'])): ?>
                <div class="alert alert-warning text-center">Nenhuma vaga encontrada.</div>
            <?php else: ?>
                <table id="tabVagas" class='table table-striped table-bordered'>
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Modalidade</th>
                            <th>Horário</th>
                            <th>Regime</th>
                            <th>Status</th>
                            <th>Alterar</th>
                            <th>Inativar</th>
                            <th>Candidatos</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($dados['lista'] as $vaga): ?>
                            <tr>
                                <td><?= htmlspecialchars($vaga->getTitulo()) ?></td>
                                <td><?= htmlspecialchars($vaga->getModalidade()) ?></td>
                                <td><?= htmlspecialchars($vaga->getHorario()) ?></td>
                                <td><?= htmlspecialchars($vaga->getRegime()) ?></td>
                                <td><?= htmlspecialchars($vaga->getStatus()) ?></td>
                                <td>
                                    <a class="btn btn-primary" 
                                        href="<?= BASEURL ?>/controller/VagaController.php?action=edit&id=<?= $vaga->getId() ?>">
                                        Alterar
                                    </a>
                                </td>
                                <td>
                                    <a class="btn btn-danger" 
                                        onclick="return confirm('Confirma a inativação da vaga?');"
                                        href="<?= BASEURL ?>/controller/VagaController.php?action=inativarVaga&id=<?= $vaga->getId() ?>">
                                        Inativar
                                    </a>
                                </td>
                                <td>
                                    <a class="btn btn-info" 
                                        href="<?= BASEURL ?>/controller/CandidaturaController.php?action=listarCandidatos&id=<?= $vaga->getId() ?>">
                                        Visualizar Candidatos
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