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
                        <?= isset($dados["cargo"]) && $dados["cargo"]->getId() > 0 ? 'Editar' : 'Novo' ?> Cargo
                    </h4>
                </div>
                
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <form id="frmCargo" method="POST" 
                                action="<?= BASEURL ?>/controller/CargoController.php?action=save">
                                
                                <div class="form-group mb-3">
                                    <label for="txtNome" class="form-label fw-bold">Nome do Cargo</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
                                            <i class="fas fa-briefcase"></i>
                                        </span>
                                        <input class="form-control" type="text" id="txtNome" name="nome" 
                                            maxlength="70" placeholder="Informe o nome do cargo"
                                            value="<?= isset($dados["cargo"]) ? $dados["cargo"]->getNome() : '' ?>" 
                                            />
                                    </div>
                                </div>
                                
                                <input type="hidden" id="hddId" name="id" 
                                    value="<?= $dados['id'] ?? 0 ?>" />
                                
                                <div class="d-flex mt-4">
                                    <button type="submit" class="btn btn-success me-2">
                                        <i class="fas fa-save me-1"></i> Salvar
                                    </button>
                                    <button type="reset" class="btn btn-danger me-2">
                                        <i class="fas fa-eraser me-1"></i> Limpar
                                    </button>
                                    <a class="btn btn-secondary ms-auto" 
                                        href="<?= BASEURL ?>/controller/CargoController.php?action=list">
                                        <i class="fas fa-arrow-left me-1"></i> Voltar
                                    </a>
                                </div>
                            </form>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="card bg-light border-0">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <i class="fas fa-info-circle text-primary me-2"></i>Informações
                                    </h5>
                                    <p class="card-text small">
                                        Preencha o nome do cargo para cadastrá-lo no sistema.
                                        Os cargos cadastrados poderão ser utilizados nas vagas de emprego.
                                    </p>
                                </div>
                            </div>

                            <?php require_once(__DIR__ . "/../include/msg.php"); ?>
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
