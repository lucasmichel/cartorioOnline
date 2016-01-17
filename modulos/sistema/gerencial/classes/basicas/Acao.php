<?php
    // codificação utf-8
    class Acao{
        private $intId;        
        private $strDescricao;
        private $strStatus;

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

        public function setStatus($str){
            $this->strStatus = $str;
        }
        public function getStatus(){
            return $this->strStatus;
        }
    }
?>