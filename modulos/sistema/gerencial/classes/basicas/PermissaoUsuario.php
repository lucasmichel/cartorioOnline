<?php
    // codificação utf-8
    class PermissaoUsuario extends Permissao{
        private $objUsuario;
        
        public function setUsuario(Usuario $obj){
            $this->objUsuario = $obj;
        }
        public function getUsuario(){
            return $this->objUsuario;
        }
    }
?>

