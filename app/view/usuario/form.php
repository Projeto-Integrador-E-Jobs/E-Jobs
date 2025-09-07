<?php
#Nome do arquivo: usuario/list.php
#Objetivo: interface para listagem dos usuários do sistema

require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>
<script src="https://cdn.jsdelivr.net/npm/inputmask@5.0.8/dist/inputmask.min.js"></script>

<div class="container py-4">
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        Cadastrar Usuário
                    </h4>
                </div>

                <div class="card-body">
                    <form id="frmUsuario" method="POST"
                        action="<?= BASEURL ?>/controller/CadastroController.php?action=save">

                        <div class="row">
                            
                            <!-- COLUNA ESQUERDA -->
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="selPapel" class="form-label fw-bold">Papel:</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
                                            <i class="fas fa-user-tag"></i>
                                        </span>
                                        <select class="form-control" name="tipoUsuario" id="selPapel" onchange="aplicarMascara()">
                                            <option value="">Selecione o papel</option>
                                            <?php foreach ($dados["papeis"] as $papel): ?>
                                                <option value="<?= $papel->getId() ?>"
                                                    <?php
                                                    if (isset($dados["usuario"]) && $dados["usuario"]->getTipoUsuario()?->getId() == $papel->getId())
                                                        echo "selected";
                                                    ?>>
                                                    <?= $papel->getNome() ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="txtNome" class="form-label fw-bold">Nome:</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
                                            <i class="fas fa-user"></i>
                                        </span>
                                        <input class="form-control" type="text" id="txtNome" name="nome"
                                            maxlength="70" placeholder="Informe o nome"
                                            value="<?php echo (isset($dados["usuario"]) ? $dados["usuario"]->getNome() : ''); ?>" />
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="txtLogin" class="form-label fw-bold">Email:</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
                                            <i class="fas fa-envelope"></i>
                                        </span>
                                        <input class="form-control" type="email" id="txtLogin" name="email"
                                            maxlength="100" placeholder="Informe o email"
                                            value="<?php echo (isset($dados["usuario"]) ? $dados["usuario"]->getEmail() : ''); ?>" />
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="txtSenha" class="form-label fw-bold">Senha:</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
                                            <i class="fas fa-lock"></i>
                                        </span>
                                        <input class="form-control" type="password" id="txtPassword" name="senha"
                                            maxlength="15" placeholder="Informe a senha"
                                            value="<?php echo (isset($dados["usuario"]) ? $dados["usuario"]->getSenha() : ''); ?>" />
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="txtConfSenha" class="form-label fw-bold">Confirmação da senha:</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
                                            <i class="fas fa-lock"></i>
                                        </span>
                                        <input class="form-control" type="password" id="txtConfSenha" name="conf_senha"
                                            maxlength="15" placeholder="Informe a confirmação da senha"
                                            value="<?php echo isset($dados['confSenha']) ? $dados['confSenha'] : ''; ?>" />
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="txtDocumento" class="form-label fw-bold">Documento:</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
                                            <i class="fas fa-id-card"></i>
                                        </span>
                                        <input class="form-control" type="text" id="txtDocumento" name="documento"
                                            maxlength="20" placeholder="Informe o documento"
                                            value="<?php echo (isset($dados["usuario"]) ? $dados["usuario"]->getDocumento() : ''); ?>" />
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="txtDescricao" class="form-label fw-bold">Descrição:</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
                                            <i class="fas fa-align-left"></i>
                                        </span>
                                        <textarea class="form-control" id="txtDescricao" name="descricao" rows="3" cols="30"
                                            placeholder="Informe a descrição"><?php echo (isset($dados["usuario"]) ? $dados["usuario"]->getDescricao() : ''); ?></textarea>
                                    </div>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label for="selStatus" class="form-label fw-bold">Status:</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
                                            <i class="fas fa-toggle-on"></i>
                                        </span>
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
                                </div>
                            </div>

                            <!-- COLUNA DIREITA -->
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="selEstado" class="form-label fw-bold">Estado:</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
                                            <i class="fas fa-map-marker-alt"></i>
                                        </span>
                                        <select class="form-control" name="estado" id="selEstado" onchange="carregarCidades('<?= BASEURL ?>', 0)">
                                            <option value="0">Selecione o estado</option>
                                            <?php foreach ($dados["estados"] as $estado): ?>
                                                <option value="<?= $estado->getCodigoUf() ?>"
                                                    <?php
                                                    if (isset($dados["usuario"]) && $dados["usuario"]->getCidade()->getEstado()->getCodigoUf() == $estado->getCodigoUf())
                                                        echo "selected";
                                                    ?>>
                                                    <?= $estado->getNome() ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="txtCidade" class="form-label fw-bold">Cidade:</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
                                            <i class="fas fa-city"></i>
                                        </span>
                                        <select class="form-control" name="cidade" id="selCidade">
                                            <option value="">Selecione a cidade</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="txtEndLogradouro" class="form-label fw-bold">Endereço Logradouro:</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
                                            <i class="fas fa-road"></i>
                                        </span>
                                        <input class="form-control" type="text" id="txtEndLogradouro" name="endLogradouro"
                                            maxlength="50" placeholder="Informe o Endereço Logradouro"
                                            value="<?php echo (isset($dados["usuario"]) ? $dados["usuario"]->getEndLogradouro() : ''); ?>" />
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="txtEndBairro" class="form-label fw-bold">Bairro:</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
                                            <i class="fas fa-map"></i>
                                        </span>
                                        <input class="form-control" type="text" id="txtEndBairro" name="endBairro"
                                            maxlength="30" placeholder="Informe o Bairro"
                                            value="<?php echo (isset($dados["usuario"]) ? $dados["usuario"]->getEndBairro() : ''); ?>" />
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="txtEndNumero" class="form-label fw-bold">Número:</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
                                            <i class="fas fa-map-pin"></i>
                                        </span>
                                        <input class="form-control" type="text" id="txtEndNumero" name="endNumero"
                                            maxlength="10" placeholder="Informe o Número"
                                            value="<?php echo (isset($dados["usuario"]) ? $dados["usuario"]->getEndNumero() : ''); ?>" />
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="txtTelefone" class="form-label fw-bold">Telefone:</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">
                                            <i class="fas fa-phone"></i>
                                        </span>
                                        <input class="form-control" type="text" id="txtTelefone" name="telefone"
                                            maxlength="20" placeholder="Informe o Telefone"
                                            value="<?php echo (isset($dados["usuario"]) ? $dados["usuario"]->getTelefone() : ''); ?>" />
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-12">
                                <?php require_once(__DIR__ . "/../include/msg.php"); ?>
                            </div>
                        </div>


                        <div class="row mt-4">
                            <div class="col-12">
                                <button type="submit" class="btn btn-success me-2">
                                    <i class="fas fa-save me-1"></i> Salvar
                                </button>
                                <button type="reset" class="btn btn-danger me-2">
                                    <i class="fas fa-eraser me-1"></i> Limpar
                                </button>
                                <a class="btn btn-secondary"
                                    href="<?= BASEURL ?>/controller/UsuarioController.php?action=list">
                                    <i class="fas fa-arrow-left me-1"></i> Voltar
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var idCidadeSelecionada = "<?= (isset($dados["usuario"]) && $dados["usuario"]->getCidade() ? $dados["usuario"]->getCidade()->getCodigoIbge() : '0') ?>";
    var BASEURL = "<?= BASEURL ?>";
</script>
<script src="<?= BASEURL ?>/view/usuario/js/cidades.js"></script>
<script src="<?= BASEURL ?>/view/usuario/js/mascara.js"></script>


<?php
require_once(__DIR__ . "/../include/footer.php");
?>