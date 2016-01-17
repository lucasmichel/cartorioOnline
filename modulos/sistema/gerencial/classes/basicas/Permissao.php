<?php
    // codificação utf-8
    class Permissao{
        private $objFormulario;
        private $objAcao;
        
        public function __construct() {}
        
        public function setFormulario(Formulario $obj){
            $this->objFormulario = $obj;
        }
        public function getFormulario(){
            return $this->objFormulario;
        }
        
        public function setAcao(Acao $obj){
            $this->objAcao = $obj;
        }
        public function getAcao(){
            return $this->objAcao;
        }
    }
?>

