<?php
include_once(__DIR__ . "/../service/NotificacaoService.php");
include_once(__DIR__ . "/../model/Candidatura.php");
include_once(__DIR__ . "/../model/Vaga.php");


class NotificacaoObserver
{
    private NotificacaoService $service;

    public function __construct(NotificacaoService $service)
    {
        $this->service = $service;
    }

    public function candidaturaCriada(Candidatura $candidatura)
    {
        $candidatoId = $candidatura->getCandidato()->getId();       
        $empresaId   = $candidatura->getVaga()->getEmpresa()->getId(); 
        $vagaId      = $candidatura->getVaga()->getId();        

        $this->service->criarNotificacao(
            $candidatoId,                  
            $empresaId,                     
            "Candidatura",                 
            "Nova candidatura para: " . $candidatura->getVaga()->getTitulo(),
            $vagaId
        );
    }


    public function candidaturaAprovada(Candidatura $candidatura)
    {
        $empresaId   = $candidatura->getVaga()->getEmpresa()->getId(); 
        $candidatoId = $candidatura->getCandidato()->getId();     
        $vagaId      = $candidatura->getVaga()->getId();

        $this->service->criarNotificacao(
            $empresaId,                      
            $candidatoId,                  
            "Aprovacao",               
            "Você foi aprovado na vaga: " . $candidatura->getVaga()->getTitulo(),
            $vagaId
        );
    }
}
