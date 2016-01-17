<?php
    // codificação utf-8
    class Modulo{ 
        private $intId;
        private $strDescricao;        
        private $strStatus;
        private $objModuloCategoria;        
        private $strCaminho;
        private $strImagem;

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
        
        public function setStatus($str){
            $this->strStatus = $str;
        }
        public function getStatus(){
            return $this->strStatus;
        }
        
        public function setModuloCategoria(ModuloCategoria $obj){
            $this->objModuloCategoria = $obj;
        }
        public function getModuloCategoria(){
            return $this->objModuloCategoria;
        }

        public function setCaminho($strCaminho){
            $this->strCaminho = $strCaminho;
        }
        public function getCaminho(){
            return $this->strCaminho;
        }

        public function setImagem($strImagem){
            $this->strImagem = $strImagem;
        }
        public function getImagem(){
            return $this->strImagem;
        }
    }
?>