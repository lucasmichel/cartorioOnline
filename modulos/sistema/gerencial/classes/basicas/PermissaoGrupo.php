<?php
    // codificação utf-8
    class PermissaoGrupo extends Permissao{
        private $objGrupo;
        
        public function setGrupo(Grupo $obj){
            $this->objGrupo = $obj;
        }
        public function getGrupo(){
            return $this->objGrupo;
        }
    }
?>

