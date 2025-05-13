<?php

include_once(__DIR__ . "/../dao/CidadeDAO.php");
require_once(__DIR__ . "/Controller.php");


class CidadeController extends Controller { 
    private CidadeDAO $cidadeDao;

    public function __construct() { 
        
        $this->cidadeDao = new CidadeDAO();
        $this->handleAction();
    }

  

    protected function listarPorEstado() {
        $idEstado = $_GET["id_estado"];

        $cidades = $this->cidadeDao->findByEstado($idEstado);
        echo json_encode($cidades, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);   
    }

   
 

}

new CidadeController();
