<?php
# Objetivo: página de login
require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>

<div class="container">
    <div class="row" style="margin-top: 20px;">
        <div class="col-6">
            <div class="alert alert-info">
                <h4>Informe os dados para logar:</h4>
                <br>

                <!-- Formulário de login -->
                <form id="frmLogin" action="./LoginController.php?action=logon" method="POST" >
                    <div class="form-group">
                        <label for="txtLogin">Email:</label>
                        <input type="text" class="form-control" name="email" id="txtLogin"
                            placeholder="Informe o email"
                            value="<?php echo isset($dados['email']) ? $dados['email'] : '' ?>" />        
                    </div>

                    <div class="form-group">
                        <label for="txtSenha">Senha:</label>
                        <input type="password" class="form-control" name="senha" id="txtSenha"
                            placeholder="Informe a senha"
                            value="<?php echo isset($dados['senha']) ? $dados['senha'] : '' ?>" />        
                    </div>

                    <button type="submit" class="btn btn-success">Logar</button>
                </form>
            </div>
        </div>

        <div class="col-6">
            <?php include_once(__DIR__ . "/../include/msg.php") ?>
        </div>
    </div>
</div>

<?php  
require_once(__DIR__ . "/../include/footer.php");
?>
