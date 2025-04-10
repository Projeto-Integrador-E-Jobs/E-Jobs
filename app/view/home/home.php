<?php
#Nome do arquivo: usuario/list.php
#Objetivo: interface para listagem dos usuários do sistema

require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>

<link rel="stylesheet" href="<?= BASEURL ?>/view/home/home.css">

<!--h1>HOME DO SISTEMA... aqui posso adicionar um card, alguns dados ou 
    qualquer outra informação pertinente à página inicial</h1-->

    
    <div class="row mt-3 justify-content-center">
        <div class="col-3 text-center">
            <span class="text-muted badge-font" >
                Usuários cadastrados:
            </span>
            <span class="badge badge-info badge-font" >
                <?= $dados["qtdUsuarios"] ?>
            </span>
        </div>
    </div>
</div>

<?php  
require_once(__DIR__ . "/../include/footer.php");
?>
