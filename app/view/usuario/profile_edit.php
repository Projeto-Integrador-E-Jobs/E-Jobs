<?php
require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>

<style>
.profile-edit-card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 0 20px rgba(0,0,0,0.1);
}

.profile-edit-header {
    background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
    border-radius: 15px 15px 0 0;
    padding: 2rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    font-weight: 500;
    color: #495057;
}

.form-control {
    border-radius: 8px;
    border: 1px solid #ced4da;
    padding: 0.75rem 1rem;
}

.form-control:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
}

select.form-control {
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%236c757d' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 1rem center;
    background-size: 16px 12px;
    padding-right: 2.5rem;
}

select.form-control:disabled {
    background-color: #e9ecef;
    cursor: not-allowed;
}

.location-select {
    position: relative;
}

.location-select .form-control {
    padding-left: 2.5rem;
}

.location-select i {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #6c757d;
    pointer-events: none;
}

.btn-save {
    padding: 0.75rem 2rem;
    border-radius: 8px;
    font-weight: 500;
}

.btn-cancel {
    padding: 0.75rem 2rem;
    border-radius: 8px;
    font-weight: 500;
    background-color: #6c757d;
    border-color: #6c757d;
}

.btn-cancel:hover {
    background-color: #5a6268;
    border-color: #545b62;
}
</style>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card profile-edit-card">
                <div class="profile-edit-header text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-user-edit me-2"></i>
                        Editar Perfil
                    </h4>
                </div>
                <div class="card-body p-4">
                    <form action="<?= BASEURL ?>/controller/UsuarioController.php?action=saveProfile" method="POST">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="txtNome" class="form-label">Nome</label>
                                    <input type="text" class="form-control" id="txtNome" name="nome" 
                                           value="<?= htmlspecialchars($dados["usuario"]->getNome()) ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="txtEmail" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="txtEmail" name="email" 
                                           value="<?= htmlspecialchars($dados["usuario"]->getEmail()) ?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="txtDocumento" class="form-label">Documento</label>
                                    <input type="text" class="form-control" id="txtDocumento" name="documento" 
                                           value="<?= htmlspecialchars($dados["usuario"]->getDocumento()) ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="txtTelefone" class="form-label">Telefone</label>
                                    <input type="text" class="form-control" id="txtTelefone" name="telefone" 
                                           value="<?= htmlspecialchars($dados["usuario"]->getTelefone()) ?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="<?= BASEURL ?>/controller/UsuarioController.php?action=viewProfile" class="btn btn-cancel text-white">
                                <i class="fas fa-times me-2"></i>Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary btn-save">
                                <i class="fas fa-save me-2"></i>Salvar Alterações
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const estadoSelect = document.getElementById('txtEstado');
    const cidadeSelect = document.getElementById('txtCidade');
    const cidadeAtual = '<?= $dados["usuario"]->getCidade()->getCodigoIbge() ?>';

    function carregarCidades(estadoId) {
        cidadeSelect.innerHTML = '<option value="">Carregando...</option>';
        
        fetch(`${BASEURL}/controller/CidadeController.php?action=listByEstado&estado=${estadoId}`)
            .then(response => response.json())
            .then(cidades => {
                cidadeSelect.innerHTML = '<option value="">Selecione a cidade</option>';
                cidades.forEach(cidade => {
                    const option = document.createElement('option');
                    option.value = cidade.codigo_ibge;
                    option.textContent = cidade.nome;
                    if (cidade.codigo_ibge === cidadeAtual) {
                        option.selected = true;
                    }
                    cidadeSelect.appendChild(option);
                });
            });
    }

    estadoSelect.addEventListener('change', function() {
        if (this.value) {
            carregarCidades(this.value);
        } else {
            cidadeSelect.innerHTML = '<option value="">Selecione a cidade</option>';
        }
    });

    // Carregar cidades iniciais se houver estado selecionado
    if (estadoSelect.value) {
        carregarCidades(estadoSelect.value);
    }
});
</script>

<?php require_once(__DIR__ . "/../include/footer.php"); ?> 