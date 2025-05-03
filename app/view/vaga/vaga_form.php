<?php
require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="mb-4 text-center">
                        <?php if($dados['id'] == 0) echo "Inserir"; else echo "Alterar"; ?> Vaga
                    </h3>
                    <form id="frmVaga" method="POST" action="<?= BASEURL ?>/controller/VagaController.php?action=save">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="txtTitulo">Título:</label>
                                    <input class="form-control" type="text" id="txtTitulo" name="titulo" maxlength="70" placeholder="Informe o título da vaga" value="<?php echo (isset($dados["vaga"]) ? $dados["vaga"]->getTitulo() : ''); ?>"  />
                                </div>
                                <div class="form-group mb-3">
                                    <label>Modalidade</label>
                                    <select class="form-control" name="modalidade" id="selModalidade" >
                                        <option value="">Selecione a modalidade da vaga</option>
                                        <?php foreach($dados["modalidades"] as $modalidade): ?>
                                            <option value="<?= $modalidade ?>" <?php if(isset($dados["vaga"]) && $dados["vaga"]->getModalidade() == $modalidade) echo "selected"; ?>><?= $modalidade ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Horário</label>
                                    <select class="form-control" name="horario" id="selHorario" >
                                        <option value="">Selecione o horário da vaga</option>
                                        <?php foreach($dados["horarios"] as $horario): ?>
                                            <option value="<?= $horario ?>" <?php if(isset($dados["vaga"]) && $dados["vaga"]->getHorario() == $horario) echo "selected"; ?>><?= $horario ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Regime</label>
                                    <select class="form-control" name="regime" id="selRegime" >
                                        <option value="">Selecione o regime da vaga</option>
                                        <?php foreach($dados["regimes"] as $regime): ?>
                                            <option value="<?= $regime ?>" <?php if(isset($dados["vaga"]) && $dados["vaga"]->getRegime() == $regime) echo "selected"; ?>><?= $regime ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="txtSalario">Salário:</label>
                                    <input class="form-control" type="number" step="0.01" id="txtSalario" name="salario" placeholder="Informe o salário" value="<?php echo (isset($dados["vaga"]) ? $dados["vaga"]->getSalario() : ''); ?>"  />
                                </div>
                                <div class="form-group mb-3">
                                    <label>Cargo:</label>
                                    <select class="form-control" name="cargo" >
                                        <option value="">Selecione o cargo</option>
                                        <?php foreach($dados["cargos"] as $cargo): ?>
                                            <option value="<?= $cargo->getId() ?>" <?php if(isset($dados["vaga"]) && $dados["vaga"]->getCargo()?->getId() == $cargo->getId()) echo "selected"; ?>><?= $cargo->getNome() ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Status:</label>
                                    <select class="form-control" name="status" id="selStatus" >
                                        <option value="">Selecione o status da vaga</option>
                                        <?php foreach($dados["status"] as $status): ?>
                                            <option value="<?= $status ?>" <?php if(isset($dados["vaga"]) && $dados["vaga"]->getStatus() == $status) echo "selected"; ?>><?= $status ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="txtDescricao">Descrição:</label>
                                    <textarea class="form-control" id="txtDescricao" name="descricao" rows="5" placeholder="Informe a descrição da vaga" ><?php echo (isset($dados["vaga"]) ? $dados["vaga"]->getDescricao() : ''); ?></textarea>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="txtRequisitos">Requisitos:</label>
                                    <textarea class="form-control" id="txtRequisitos" name="requisitos" rows="5" placeholder="Informe os requisitos da vaga" ><?php echo (isset($dados["vaga"]) ? $dados["vaga"]->getRequisitos() : ''); ?></textarea>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="txtEmpresa">Empresa:</label>
                                    <input class="form-control" type="text" id="txtEmpresa" name="empresa_nome" value="<?php echo (isset($dados['empresa']) ? $dados['empresa']->getNome() : ''); ?>" disabled />
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="hddId" name="id" value="<?= $dados['id']; ?>" />
                        <input type="hidden" id="usuarioId" name="usuarioId" value="<?= $dados['empresa']->getId(); ?>" />
                        <div class="d-flex justify-content-end gap-2 mt-3">
                            <button type="reset" class="btn btn-secondary">Limpar</button>
                            <button type="submit" class="btn btn-success">Gravar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-12 text-center">
            <a class="btn btn-outline-primary" href="<?= BASEURL ?>/controller/VagaController.php?action=list">Voltar</a>
        </div>
    </div>
</div>

<?php  
require_once(__DIR__ . "/../include/footer.php");
?>
