<?php
    // codificação utf-8
    class EstadoCivil{
        private $intId;
        private $strDescricao;
        private $strExigeConjuge;
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
        
        public function setExigeConjuge($strExigeConjuge){
            $this->strExigeConjuge = $strExigeConjuge;
        }
        public function getExigeConjuge(){
            return $this->strExigeConjuge;
        }

        public function setStatus($strStatus){
            $this->strStatus = $strStatus;
        }
        public function getStatus(){
            return $this->strStatus;
        }
    }
?>