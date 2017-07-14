<?php

require_once 'InterfaceWeb.class.php';

class HomeView extends InterfaceWeb {

   
    protected function montaCorpo($objeto) {
        
        $imagem = null; 
        $imagem .= "<img src='../img/academia.jpg' style='width:64%; height:90%; margin-left: 16%;'>"; 
        
        parent::adicionaAoCorpo($imagem);
        
    }

    public function recebeDados() {
        
    }

    public function recebeDadosDaConsulta() {
        
    }

}
