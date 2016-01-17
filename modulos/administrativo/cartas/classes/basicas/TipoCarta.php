<?php
    // codificaçao utf-8
    class TipoCarta{
        private $intId;                
        private $strDescricao;
        private $strTexto;
        private $strStatus;
        
        public function __construct(){}
        
        public function getId(){
            return $this->intId;
        }
        public function setId($intId){
            $this->intId = $intId;
        }
        
        public function getDescricao(){
            return $this->strDescricao;
        }
        public function setDescricao($strDescricao){
            $this->strDescricao = $strDescricao;
        }
        
        public function getTexto(){
            return $this->strTexto;
        }
        public function setTexto($strTexto){
            $this->strTexto = $strTexto;
        }
        
        public function getStatus(){
            return $this->strStatus;
        }
        public function setStatus($strStatus){
            $this->strStatus = $strStatus;
        }
        
    }
?>