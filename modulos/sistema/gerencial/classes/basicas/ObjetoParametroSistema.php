<?php

class ObjetoParametroSistema {
    
    private static $objInstance;
    private $quantidadeFolhasLivro = 200;
    private $quantidadeLinhasFolha = 36;
    
    public static function getInstance(){
        if(self::$objInstance == null){
            self::$objInstance = new ObjetoParametroSistema();
        }
        return self::$objInstance;
    }
    
    public function getQuantidadeLinhasFolha(){
        return $this->quantidadeLinhasFolha;
    }
    
    public function getQuantidadeFolhasLivro(){
        return $this->quantidadeFolhasLivro;
    }
    
}
?>
