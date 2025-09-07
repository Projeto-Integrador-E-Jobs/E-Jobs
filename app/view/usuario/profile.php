<?php
require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>

<style>
.profile-card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 0 20px rgba(0,0,0,0.1);
}

.profile-header {
    background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
    border-radius: 15px 15px 0 0;
    padding: 2rem;
}

.profile-icon {
    width: 80px;
    height: 80px;
    background: rgba(255,255,255,0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1rem;
}

.profile-icon i {
    font-size: 2.5rem;
    color: white;
}

.info-card {
    background: #f8f9fa;
    border-radius: 10px;
    padding: 1.5rem;
    margin-bottom: 1rem;
    transition: all 0.3s ease;
}

.info-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.info-icon {
    width: 40px;
    height: 40px;
    background: #e9ecef;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
}

.info-icon i {
    font-size: 1.2rem;
    color: #0d6efd;
}

.edit-btn {
    position: absolute;
    top: 1rem;
    right: 1rem;
    background: rgba(255,255,255,0.2);
    border: none;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.edit-btn:hover {
    background: rgba(255,255,255,0.3);
    transform: scale(1.1);
}

.edit-btn i {
    color: white;
    font-size: 1.2rem;
}
</style>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card profile-card">
                <div class="profile-header text-white position-relative">
                    <div class="text-center">
                        <div class="profile-icon mx-auto">
                            <i class="fas fa-user"></i>
                        </div>
                        <h3 class="mb-0"><?= htmlspecialchars($dados["usuario"]->getNome()) ?></h3>
                        <p class="mb-0 opacity-75"><?= htmlspecialchars($dados["usuario"]->getEmail()) ?></p>
                    </div>
                    <?php if ($dados["isOwnProfile"]): ?>
                    <a href="<?= BASEURL ?>/controller/UsuarioController.php?action=editProfile" class="edit-btn">
                        <i class="fas fa-pencil-alt"></i>
                    </a>
                    <?php endif; ?>
                </div>
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-card d-flex align-items-center">
                                <div class="info-icon">
                                    <i class="fas fa-id-card"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Documento</small>
                                    <strong><?= htmlspecialchars($dados["usuario"]->getDocumento()) ?></strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-card d-flex align-items-center">
                                <div class="info-icon">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Telefone</small>
                                    <strong><?= htmlspecialchars($dados["usuario"]->getTelefone()) ?></strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-card d-flex align-items-center">
                                <div class="info-icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Estado</small>
                                    <strong><?= htmlspecialchars($dados["usuario"]->getCidade()->getEstado()->getNome()) ?></strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-card d-flex align-items-center">
                                <div class="info-icon">
                                    <i class="fas fa-city"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Cidade</small>
                                    <strong><?= htmlspecialchars($dados["usuario"]->getCidade()->getNome()) ?></strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="info-card d-flex align-items-start">
                                <div class="info-icon">
                                    <i class="fas fa-map"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Endereço</small>
                                    <strong>
                                        <?= htmlspecialchars($dados["usuario"]->getEndLogradouro()) ?>, 
                                        <?= htmlspecialchars($dados["usuario"]->getEndBairro()) ?>, 
                                        Nº <?= htmlspecialchars($dados["usuario"]->getEndNumero()) ?>
                                    </strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php if ($dados["usuario"]->getDescricao()): ?>
                    <div class="row">
                        <div class="col-12">
                            <div class="info-card d-flex align-items-start">
                                <div class="info-icon">
                                    <i class="fas fa-file-alt"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Descrição</small>
                                    <strong><?= nl2br(htmlspecialchars($dados["usuario"]->getDescricao())) ?></strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once(__DIR__ . "/../include/footer.php"); ?> 