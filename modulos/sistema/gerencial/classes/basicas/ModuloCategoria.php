<?php
    // codificação utf-8
    class ModuloCategoria{
        private $intId;
        private $strDescricao;
        private $strBackgroundModulo;
        private $strBackgroundSubModulo;
        private $strImagem;
        private $intOrdem;
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

        public function setImagem($strImagem){
            $this->strImagem = $strImagem;
        }

        public function getImagem(){
            return $this->strImagem;
        }

        public function setBackgroundModulo($strBackgroundModulo){
            $this->strBackgroundModulo = $strBackgroundModulo;
        }

        public function getBackgroundModulo(){
            return $this->strBackgroundModulo;
        }

        public function setBackgroundSubModulo($strBackgroundSubModulo){
            $this->strBackgroundSubModulo = $strBackgroundSubModulo;
        }

        public function getBackgroundSubModulo(){
            return $this->strBackgroundSubModulo;
        }

        public function setOrdem($intOrdem){
            $this->intOrdem = $intOrdem;
        }

        public function getOrdem(){
            return $this->intOrdem;
        }

        public function setStatus($strStatus){
            $this->strStatus = $strStatus;
        }

        public function getStatus(){
            return $this->strStatus;
        }
    }
?>