<?php
#Nome do arquivo: usuario/list.php
#Objetivo: interface para listagem dos usuários do sistema

require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>

<h3 class="text-center">
    <?php if($dados['id'] == 0) echo "Inserir"; else echo "Alterar"; ?> 
    Usuário
</h3>

<div class="container">
    
    <div class="row" style="margin-top: 10px;">
        
        <div class="col-6">
            <form id="frmUsuario" method="POST" 
                action="<?= BASEURL ?>/controller/UsuarioController.php?action=save" >
                <div class="form-group">
                    <label for="txtNome">Nome:</label>
                    <input class="form-control" type="text" id="txtNome" name="nome" 
                        maxlength="70" placeholder="Informe o nome"
                        value="<?php echo (isset($dados["usuario"]) ? $dados["usuario"]->getNome() : ''); ?>" />
                </div>
                
                <div class="form-group">
                    <label for="txtLogin">Email:</label>
                    <input class="form-control" type="text" id="txtLogin" name="email" 
                        maxlength="15" placeholder="Informe o email"
                        value="<?php echo (isset($dados["usuario"]) ? $dados["usuario"]->getEmail() : ''); ?>"/>
                </div>

                <div class="form-group">
                    <label for="txtSenha">Senha:</label>
                    <input class="form-control" type="password" id="txtPassword" name="senha" 
                        maxlength="15" placeholder="Informe a senha"
                        value="<?php echo (isset($dados["usuario"]) ? $dados["usuario"]->getSenha() : ''); ?>"/>
                </div>

                <div class="form-group">
                    <label for="txtConfSenha">Confirmação da senha:</label>
                    <input class="form-control" type="password" id="txtConfSenha" name="conf_senha" 
                        maxlength="15" placeholder="Informe a confirmação da senha"
                        value="<?php echo isset($dados['confSenha']) ? $dados['confSenha'] : '';?>"/>
                </div>

                <div class="form-group">
                    <label for="txtDocumento">Documento:</label>
                    <input class="form-control" type="text" id="txtDocumento" name="documento" 
                        maxlength="20" placeholder="Informe o documento"
                        value="<?php echo (isset($dados["usuario"]) ? $dados["usuario"]->getDocumento() : ''); ?>"/>
                </div>

                <div class="form-group">
                    <label for="txtDescricao">Descrição:</label>
                    <textarea class="form-control" id="txtDescricao" name="descricao" rows="3"
                        placeholder="Informe a descrição"><?php echo (isset($dados["usuario"]) ? $dados["usuario"]->getDescricao() : ''); ?></textarea>
                </div>

                <div class="form-group">
                    <label>Estado</label>
                    <select class="form-control" name="estado" id="selEstado">
                        <option value="">Selecione o estado</option>
                        <?php foreach($dados["estados"] as $estado): ?>
                            <option value="<?= $estado->getId() ?>" 
                                <?php 
                                    if(isset($dados["usuario"]) && $dados["usuario"]->getEstado()?->getId() == $estado->getId()) 
                                        echo "selected";
                                ?>    
                            >
                                <?= $estado->getNome() ?>
                            </option>
                        <?php endforeach; ?>

                    </select>
                </div>

                <div class="form-group">
                    <label for="txtCidade">Cidade:</label>
                    <input class="form-control" type="text" id="txtCidade" name="cidade" 
                        maxlength="20" placeholder="Informe a Cidade"
                        value="<?php echo (isset($dados["usuario"]) ? $dados["usuario"]->getCidade() : ''); ?>"/>
                </div>

                <div class="form-group">
                    <label for="txtEndLogradouro">Endereço Lougradouro:</label>
                    <input class="form-control" type="text" id="txtEndLogradouro" name="endLogradouro" 
                        maxlength="20" placeholder="Informe o Endereço Lougradouro"
                        value="<?php echo (isset($dados["usuario"]) ? $dados["usuario"]->getEndLogradouro() : ''); ?>"/>
                </div>

                <div class="form-group">
                    <label for="txtEndBairro">Bairro:</label>
                    <input class="form-control" type="text" id="txtEndBairro" name="endBairro" 
                        maxlength="20" placeholder="Informe o Bairro"
                        value="<?php echo (isset($dados["usuario"]) ? $dados["usuario"]->getEndBairro() : ''); ?>"/>
                </div>

                <div class="form-group">
                    <label for="txtEndNumero">Número:</label>
                    <input class="form-control" type="text" id="txtEndNumero" name="endNumero" 
                        maxlength="20" placeholder="Informe o Número"
                        value="<?php echo (isset($dados["usuario"]) ? $dados["usuario"]->getEndNumero() : ''); ?>"/>
                </div>

                <div class="form-group">
                    <label for="txtTelefone">Informe o telefone:</label>
                    <input class="form-control" type="text" id="txtTelefone" name="telefone" 
                        maxlength="20" placeholder="Informe o Número"
                        value="<?php echo (isset($dados["usuario"]) ? $dados["usuario"]->getTelefone() : ''); ?>"/>
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <select class="form-control" name="status" id="selStatus">
                        <option value="">Selecione o status do usuário</option>
                        <?php foreach($dados["status"] as $status): ?>
                            <option value="<?= $status ?>" 
                                <?php 
                                    if(isset($dados["usuario"]) && $dados["usuario"]->getStatus() == $status) 
                                        echo "selected";
                                ?>    
                            >
                                <?= $status ?>
                            </option>
                        <?php endforeach; ?>

                    </select>
                </div>

                <div class="form-group">
                    <label>Papel</label>
                    <select class="form-control" name="tipoUsuario" id="selPapel">
                        <option value="">Selecione o papel</option>
                        <?php foreach($dados["papeis"] as $papel): ?>
                            <option value="<?= $papel->getId() ?>" 
                                <?php 
                                    if(isset($dados["usuario"]) && $dados["usuario"]->getTipoUsuario()?->getId() == $papel->getId()) 
                                        echo "selected";
                                ?>    
                            >
                                <?= $papel->getNome() ?>
                            </option>
                        <?php endforeach; ?>

                    </select>
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
                href="<?= BASEURL ?>/controller/UsuarioController.php?action=list">Voltar</a>
        </div>
    </div>
</div>

<?php  
require_once(__DIR__ . "/../include/footer.php");
?>