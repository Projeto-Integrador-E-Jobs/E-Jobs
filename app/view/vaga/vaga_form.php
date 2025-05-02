<?php
require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>

<h3 class="text-center">
    <?php if($dados['id'] == 0) echo "Inserir"; else echo "Alterar"; ?> Vaga
</h3>

<div class="container">
    <div class="row" style="margin-top: 10px;">
        <div class="col-6">
            <form id="frmVaga" method="POST" 
                action="<?= BASEURL ?>/controller/VagaController.php?action=save" >

                <div class="form-group">
                    <label for="txtTitulo">Título:</label>
                    <input class="form-control" type="text" id="txtTitulo" name="titulo" 
                        maxlength="70" placeholder="Informe o título da vaga"
                        value="<?php echo (isset($dados["vaga"]) ? $dados["vaga"]->getTitulo() : ''); ?>" />
                </div>

                <div class="form-group">
                    <label>Modalidade</label>
                    <select class="form-control" name="modalidade" id="selModalidade">
                        <option value="">Selecione a modalidade da vaga</option>
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
                </div>

                <div class="form-group">
                    <label>Horário</label>
                    <select class="form-control" name="horario" id="selHorario">
                        <option value="">Selecione o horário da vaga</option>
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
                </div>

                <div class="form-group">
                    <label>Regime</label>
                    <select class="form-control" name="regime" id="selRegime">
                        <option value="">Selecione o regime da vaga</option>
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
                </div>

                <div class="form-group">
                    <label for="txtSalario">Salário:</label>
                    <input class="form-control" type="number" step="0.01" id="txtSalario" name="salario" 
                        placeholder="Informe o salário"
                        value="<?php echo (isset($dados["vaga"]) ? $dados["vaga"]->getSalario() : ''); ?>"/>
                </div>

                <div class="form-group">
                    <label for="txtDescricao">Descrição:</label>
                    <textarea class="form-control" id="txtDescricao" name="descricao" rows="3"
                        placeholder="Informe a descrição da vaga">
                        <?php echo (isset($dados["vaga"]) ? $dados["vaga"]->getDescricao() : ''); ?></textarea>
                </div>

                <div class="form-group">
                    <label for="txtRequisitos">Requisitos:</label>
                    <textarea class="form-control" id="txtRequisitos" name="requisitos" rows="3"
                        placeholder="Informe os requisitos da vaga"><?php echo (isset($dados["vaga"]) ? $dados["vaga"]->getRequisitos() : ''); ?></textarea>
                </div>

                <div class="form-group">
                    <label>Cargo:</label>
                    <select class="form-control" name="cargo">
                        <option value="">Selecione o cargo</option>
                        <?php foreach($dados["cargos"] as $cargo): ?>
                            <option value="<?= $cargo->getId() ?>" 
                                <?php 
                                    if(isset($dados["vaga"]) && $dados["vaga"]->getCargo()?->getId() == $cargo->getId()) 
                                        echo "selected";
                                ?>><?= $cargo->getNome() ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="txtEmpresa">Empresa:</label>
                    <input class="form-control" type="text" id="txtEmpresa" name="empresa_nome" 
                        value="<?php echo (isset($dados['empresa']) ? $dados['empresa']->getNome() : ''); ?>" 
                        disabled />
                </div>

                <input type="hidden" id="hddId" name="id" value="<?= $dados['id']; ?>" />
                <input type="hidden" id="usuarioId" name="usuarioId" value="<?= $dados['empresa']->getId(); ?>" />

                <button type="submit" class="btn btn-success">Gravar</button>
                <button type="reset" class="btn btn-danger">Limpar</button>
            </form>            
        </div>

        <div class="col-6">
            <?php require_once(__DIR__ . "/../include/msg.php"); ?>
        </div>
    </div>

    <div class="row" style="margin-top: 30px;">
        <div class="col-12">
            <a class="btn btn-secondary" href="<?= BASEURL ?>/controller/VagaController.php?action=list">Voltar</a>
        </div>
    </div>
</div>

<?php  
require_once(__DIR__ . "/../include/footer.php");
?>
