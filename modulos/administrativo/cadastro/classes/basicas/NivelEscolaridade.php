<?php
    // codificação utf-8
    class NivelEscolaridade{
        private $intId;
        private $strDescricao;
        private $strExigeFormacao;
        private $strStatus;

        public function __construct() {}

        public function setId($intId){
            $this->intId = $intId;
        }

        public function getId(){
            return $this->intId;
        }
  
        public function setDescricao($strDescricao){
            $this->strDescricao = $strDescricao;
        }

        public function getDescricao(){
            return $this->strDescricao;
        }
        
        public function setExigeFormacao($strExigeFormacao){
            $this->strExigeFormacao = $strExigeFormacao;
        }
        
        public function getExigeFormacao(){
            return $this->strExigeFormacao;
        }
  
        public function setStatus($strStatus){
            $this->strStatus = $strStatus;
        }

        public function getStatus(){
            return $this->strStatus;
        }
    }
?>