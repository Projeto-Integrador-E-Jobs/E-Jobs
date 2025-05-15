<?php
require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>

<div class="container py-4">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <?= isset($dados["categoria"]) && $dados["categoria"]->getId() > 0 ? 'Editar' : 'Novo' ?> Categoria
                    </h4>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <form id="frmUsuario" method="POST"
                                action="<?= BASEURL ?>/controller/CategoriaController.php?action=save">

                                <div class="form-group mb-3">
                                    <label for="txtNome" class="form-label fw-bold">Nome da Categoria</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
                                            <i class="fas fa-briefcase"></i>
                                        </span>
                                        <input class="form-control" type="text" id="txtNome" name="nome"
                                            maxlength="70" placeholder="Informe o nome da categoria"
                                            value="<?php echo (isset($dados["categoria"]) ? $dados["categoria"]->getNome() : ''); ?>" />
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="txtNome" class="form-label fw-bold">Ícone</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
                                            <i class="fas fa-briefcase"></i>
                                        </span>
                                        <input class="form-control" type="text" id="txtIcone" name="icone"
                                            maxlength="70" placeholder="Informe o icone"
                                            value="<?php echo (isset($dados["categoria"]) ? $dados["categoria"]->getIcone() : ''); ?>" />
                                    </div>
                                </div>

                                <input type="hidden" id="hddId" name="id"
                                    value="<?= $dados['id']; ?>" />

                                <div class="d-flex mt-4">
                                    <?php require_once(__DIR__ . "/../include/msg.php"); ?>
                                </div>

                                <div class="d-flex mt-4">
                                    <button type="submit" class="btn btn-success me-2">
                                        <i class="fas fa-save me-1"></i> Salvar
                                    </button>
                                    <button type="reset" class="btn btn-danger me-2">
                                        <i class="fas fa-eraser me-1"></i> Limpar
                                    </button>
                                    <a class="btn btn-secondary ms-auto"
                                        href="<?= BASEURL ?>/controller/CategoriaController.php?action=list">
                                        <i class="fas fa-arrow-left me-1"></i> Voltar
                                    </a>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require_once(__DIR__ . "/../include/footer.php");
?>