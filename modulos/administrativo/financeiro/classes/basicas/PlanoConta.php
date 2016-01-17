<?php
    // codificação utf-8
    class PlanoConta{
        private $intId;
        private $strDescricao;
        private $strCodigoContabil;  
        private $strMovimento;
        private $strTipo;
        private $strStatus;
        private $pai;
        
        public function __construct() {}
        
        public function setId($intId){
            $this->intId = $intId;
        }
        public function getId(){
            return $this->intId;
        }
        
        public function setDescricao($str){
            $this->strDescricao = $str;
        }        
        public function getDescricao(){
            return $this->strDescricao;
        }
        
        public function setCodigoContabil($str){
            $this->strCodigoContabil = $str;
        }        
        public function getCodigoContabil(){
            return $this->strCodigoContabil;
        }
        
        public function setMovimento($str){
            $this->strMovimento = $str;
        }
        public function getMovimento(){
            return $this->strMovimento;
        }
        
        public function setTipo($str){
            $this->strTipo = $str;
        }
        public function getTipo(){
            return $this->strTipo;
        }
        
        public function setStatus($str){
            $this->strStatus = $str;
        }        
        public function getStatus(){
            return $this->strStatus;
        }
        
        public function setPai($pai){
            $this->pai = $pai;
        }
        public function getPai(){
            return $this->pai;
        }
    }
?>
