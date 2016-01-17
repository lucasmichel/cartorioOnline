<?php
    // codificação utf-8
    class Formulario{
        private $intId;
        private $strDescricao;
        private $strCaminho;
        private $strStatus;
        private $strNivel1Descricao;
        private $strNivel2Descricao;
        private $strNivel3Descricao;
        private $objModulo;
        
        // As ações contidas no formulário podem variar conforme a consulta
        // que chama os formulários
        private $arrObjAcoes; 

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

        public function setCaminho($str){
            $this->strCaminho = $str;
        }
        public function getCaminho(){
            return $this->strCaminho;
        }

        public function setStatus($str){
            $this->strStatus = $str;
        }
        public function getStatus(){
            return $this->strStatus;
        }

        public function setNivel1Descricao($str){
            $this->strNivel1Descricao = $str;
        }
        public function getNivel1Descricao(){
            return $this->strNivel1Descricao;
        }

        public function setNivel2Descricao($str){
            $this->strNivel2Descricao = $str;
        }
        public function getNivel2Descricao(){
            return $this->strNivel2Descricao;
        }

        public function setNivel3Descricao($str){
            $this->strNivel3Descricao = $str;
        }
        public function getNivel3Descricao(){
            return $this->strNivel3Descricao;
        }

        public function setModulo(Modulo $obj){
            return $this->objModulo = $obj;
        }
        public function getModulo(){
            return $this->objModulo;
        }

        public function addAcao(Acao $obj){
            $this->arrObjAcoes[count($this->arrObjAcoes)] = $obj;
        }
        public function setAcoes($arrObjs){
            return $this->arrObjAcoes = $arrObjs;
        }
        public function getAcoes(){
            return $this->arrObjAcoes;
        }
    }
?>