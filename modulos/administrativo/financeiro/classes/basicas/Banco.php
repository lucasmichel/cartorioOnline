<?php
    // codificação utf-8
    class Banco{
        private $intId;
        private $strDescricao;
        private $strCodigo;
        private $strStatus;
        
        public function __construct() {}
        
        public function setId($int){
            $this->intId = $int;
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
        
        public function setCodigo($str){
            $this->strCodigo = $str;
        }        
        public function getCodigo(){
            return $this->strCodigo;
        }
        
        public function setStatus($str){
            $this->strStatus = $str;
        }        
        public function getStatus(){
            return $this->strStatus;
        }
    }
?>
