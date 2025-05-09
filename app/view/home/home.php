<?php
# Nome do arquivo: view/home/home.php
# Objetivo: página inicial do sistema de empregos

require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>

<link rel="stylesheet" href="<?= BASEURL ?>/view/home/home.css">
<link rel="stylesheet" href="<?= BASEURL ?>/view/include/header.css">


<div class="container">
    <div class="row mt-4 mb-5">
        <div class="col-12 text-center py-5 bg-primary text-white rounded banner">
            <h1 class="display-4">Encontre seu próximo emprego</h1>
            <p class="lead">Milhares de vagas disponíveis para você</p>

            <form class="mt-4 job-search-form" method="GET" action="<?= BASEURL ?>/controller/VagaController.php">
                <input type="hidden" name="action" value="listPublic">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <input type="text" name="search" class="form-control form-control-lg"
                            placeholder="Digite o título da vaga"
                            value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>"
                            required>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-success btn-lg btn-block">Buscar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-12">
            <h2 class="text-center mb-4">Categorias Populares</h2>
        </div>

        <?php
        $categorias = [
            ["nome" => "Tecnologia", "icone" => "fa-laptop-code", "vagas" => 240],
            ["nome" => "Marketing", "icone" => "fa-bullhorn", "vagas" => 186],
            ["nome" => "Vendas", "icone" => "fa-chart-line", "vagas" => 142],
            ["nome" => "Design", "icone" => "fa-paint-brush", "vagas" => 104]
        ];

        foreach ($categorias as $categoria) {
        ?>
            <div class="col-md-3 mb-4">
                <div class="card text-center category-card">
                    <div class="card-body">
                        <i class="fas <?= $categoria['icone'] ?> fa-3x mb-3 text-primary"></i>
                        <h5 class="card-title"><?= $categoria['nome'] ?></h5>
                        <p class="card-text text-muted"><?= $categoria['vagas'] ?> vagas disponíveis</p>
                        <a href="<?= BASEURL ?>/job/list.php?categoria=<?= urlencode($categoria['nome']) ?>" class="stretched-link"></a>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
    </div>



    <?php
    require_once(__DIR__ . "/../include/footer.php");
    ?>