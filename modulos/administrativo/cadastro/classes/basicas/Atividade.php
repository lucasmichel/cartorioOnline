<?php
    // codificaçao utf-8
    class Atividade{
        private $intId;                
        private $strDescricao;
        private $strExigeData;
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
        
        public function getExigeData(){
            return $this->strExigeData;
        }
        public function setExigeData($strExigeData){
            $this->strExigeData = $strExigeData;
        }
        
        public function getStatus(){
            return $this->strStatus;
        }
        public function setStatus($strStatus){
            $this->strStatus = $strStatus;
        }
        
    }
?>