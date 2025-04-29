<?php
require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title mb-0 text-center">
                        <i class="fas fa-briefcase me-2"></i>
                        <?php if($dados['id'] == 0) echo "Inserir"; else echo "Alterar"; ?> Vaga
                    </h3>
                </div>
                <div class="card-body">
                    <form id="frmVaga" method="POST" 
                        action="<?= BASEURL ?>/controller/VagaController.php?action=save" class="needs-validation" novalidate>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="txtTitulo" class="form-label">
                                    <i class="fas fa-heading me-2"></i>Título
                                </label>
                                <input class="form-control" type="text" id="txtTitulo" name="titulo" 
                                    maxlength="70" placeholder="Informe o título da vaga"
                                    value="<?php echo (isset($dados["vaga"]) ? $dados["vaga"]->getTitulo() : ''); ?>" required />
                                <div class="invalid-feedback">Por favor, informe o título da vaga.</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">
                                    <i class="fas fa-laptop-house me-2"></i>Modalidade
                                </label>
                                <select class="form-select" name="modalidade" id="selModalidade" required>
                                    <option value="">Selecione...</option>
                                    <?php foreach($dados["modalidades"] as $modalidade): ?>
                                        <option value="<?= $modalidade ?>" 
                                            <?php 
                                                if(isset($dados["vaga"]) && $dados["vaga"]->getModalidade() == $modalidade) 
                                                    echo "selected";
                                            ?>    
                                        >
                                            <?= $modalidade ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback">Por favor, selecione a modalidade.</div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">
                                    <i class="fas fa-clock me-2"></i>Horário
                                </label>
                                <select class="form-select" name="horario" id="selHorario" required>
                                    <option value="">Selecione...</option>
                                    <?php foreach($dados["horarios"] as $horario): ?>
                                        <option value="<?= $horario ?>" 
                                            <?php 
                                                if(isset($dados["vaga"]) && $dados["vaga"]->getHorario() == $horario) 
                                                    echo "selected";
                                            ?>    
                                        >
                                            <?= $horario ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback">Por favor, selecione o horário.</div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">
                                    <i class="fas fa-calendar-alt me-2"></i>Regime
                                </label>
                                <select class="form-select" name="regime" id="selRegime" required>
                                    <option value="">Selecione...</option>
                                    <?php foreach($dados["regimes"] as $regime): ?>
                                        <option value="<?= $regime ?>" 
                                            <?php 
                                                if(isset($dados["vaga"]) && $dados["vaga"]->getRegime() == $regime) 
                                                    echo "selected";
                                            ?>    
                                        >
                                            <?= $regime ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback">Por favor, selecione o regime.</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="txtSalario" class="form-label">
                                    <i class="fas fa-money-bill-wave me-2"></i>Salário
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">R$</span>
                                    <input class="form-control" type="number" step="0.01" id="txtSalario" name="salario" 
                                        placeholder="0,00" required
                                        value="<?php echo (isset($dados["vaga"]) ? $dados["vaga"]->getSalario() : ''); ?>"/>
                                    <div class="invalid-feedback">Por favor, informe o salário.</div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    <i class="fas fa-user-tie me-2"></i>Cargo
                                </label>
                                <select class="form-select" name="cargo" required>
                                    <option value="">Selecione...</option>
                                    <?php foreach($dados["cargos"] as $cargo): ?>
                                        <option value="<?= $cargo->getId() ?>" 
                                            <?php 
                                                if(isset($dados["vaga"]) && $dados["vaga"]->getCargo()?->getId() == $cargo->getId()) 
                                                    echo "selected";
                                            ?>><?= $cargo->getNome() ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback">Por favor, selecione o cargo.</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="txtDescricao" class="form-label">
                                    <i class="fas fa-info-circle me-2"></i>Descrição
                                </label>
                                <textarea class="form-control" id="txtDescricao" name="descricao" rows="3"
                                    placeholder="Informe a descrição da vaga" required><?php echo (isset($dados["vaga"]) ? $dados["vaga"]->getDescricao() : ''); ?></textarea>
                                <div class="invalid-feedback">Por favor, informe a descrição.</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="txtRequisitos" class="form-label">
                                    <i class="fas fa-list-check me-2"></i>Requisitos
                                </label>
                                <textarea class="form-control" id="txtRequisitos" name="requisitos" rows="3"
                                    placeholder="Informe os requisitos da vaga" required><?php echo (isset($dados["vaga"]) ? $dados["vaga"]->getRequisitos() : ''); ?></textarea>
                                <div class="invalid-feedback">Por favor, informe os requisitos.</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="txtEmpresa" class="form-label">
                                    <i class="fas fa-building me-2"></i>Empresa
                                </label>
                                <input class="form-control" type="text" id="txtEmpresa" name="empresa_nome" 
                                    value="<?php echo (isset($dados['empresa']) ? $dados['empresa']->getNome() : ''); ?>" 
                                    disabled />
                            </div>
                        </div>

                        <input type="hidden" id="hddId" name="id" value="<?= $dados['id']; ?>" />
                        <input type="hidden" id="usuarioId" name="usuarioId" value="<?= $dados['empresa']->getId(); ?>" />

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="<?= BASEURL ?>/controller/VagaController.php?action=list" class="btn btn-secondary me-md-2">
                                <i class="fas fa-arrow-left me-2"></i>Voltar
                            </a>
                            <button type="reset" class="btn btn-danger me-md-2">
                                <i class="fas fa-eraser me-2"></i>Limpar
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Gravar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Form validation
(function () {
    'use strict'
    var forms = document.querySelectorAll('.needs-validation')
    Array.prototype.slice.call(forms).forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }
            form.classList.add('was-validated')
        }, false)
    })
})()
</script>

<?php  
require_once(__DIR__ . "/../include/footer.php");
?>
