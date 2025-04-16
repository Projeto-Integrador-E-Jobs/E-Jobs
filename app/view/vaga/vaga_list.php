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

        <div class="col-9">
            <?php require_once(__DIR__ . "/../include/msg.php"); ?>
        </div>
    </div>

    <div class="row" style="margin-top: 10px;">
        <div class="col-12">
            <table id="tabUsuarios" class='table table-striped table-bordered'>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Titulo</th>
                        <th>Modalidade</th>
                        <th>Horário</th>
                        <th>Regime</th>
                        <th>Salário</th>
                        <th>Descrição</th>
                        <th>Requisitos</th>
                        <th>Cargo</th>
                        <th>Empresa</th>
                        <th>Alterar</th>
                        <th>Excluir</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($dados['lista'] as $vaga): ?>
                        <tr>
                            <td><?php echo $vaga->getId(); ?></td>
                            <td><?= $vaga->getTitulo(); ?></td>
                            <td><?= $vaga->getModalidade(); ?></td>
                            <td><?= $vaga->getHorario(); ?></td>
                            <td><?= $vaga->getRegime(); ?></td>
                            <td><?= $vaga->getSalario(); ?></td>
                            <td><?= $vaga->getDescricao(); ?></td>
                            <td><?= $vaga->getRequisitos(); ?></td>
                            <td><?= $vaga->getCargo()->getNome(); ?></td>
                            <td><?= $vaga->getEmpresa()->getNome(); ?></td>
                            <td><a class="btn btn-primary" 
                                href="<?= BASEURL ?>/controller/VagaController.php?action=edit&id=<?= $vaga->getId() ?>">
                                Alterar</a> 
                            </td>
                            <td><a class="btn btn-danger" 
                                onclick="return confirm('Confirma a exclusão do usuário?');"
                                href="<?= BASEURL ?>/controller/VagaController.php?action=delete&id=<?= $vaga->getId() ?>">
                                Excluir</a> 
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php  
require_once(__DIR__ . "/../include/footer.php");
?>
