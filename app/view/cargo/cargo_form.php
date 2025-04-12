<?php
require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>



<div class="container">
    
    <div class="row" style="margin-top: 10px;">
        
        <div class="col-6">
            <form id="frmUsuario" method="POST" 
                action="<?= BASEURL ?>/controller/CargoController.php?action=save" >
                <div class="form-group">
                    <label for="txtNome">Nome do Cargo </label>
                    <input class="form-control" type="text" id="txtNome" name="nome" 
                        maxlength="70" placeholder="Informe o nome do Cargo"
                        value="<?php echo (isset($dados["cargo"]) ? $dados["cargo"]->getNome() : ''); ?>" />
                </div>
                
                <input type="hidden" id="hddId" name="id" 
                    value="<?= $dados['id']; ?>" />

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
        <a class="btn btn-secondary" 
                href="<?= BASEURL ?>/controller/CargoController.php?action=list">Voltar</a>
        </div>
    </div>
</div>

<?php  
require_once(__DIR__ . "/../include/footer.php");
?>