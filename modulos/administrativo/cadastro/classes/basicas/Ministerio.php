<?php
    // codificação utf-8
    class Ministerio{
        private $intId;
        private $strDescricao;
        private $objEndereco;
        private $strObservacao;
        private $arrObjReunioes = array();
        private $strDataHoraCadastro;
        private $strStatus;
        private $objAreaMinisterial;

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
        
        public function setEndereco($objEndereco){
            $this->objEndereco = $objEndereco;
        }
        
        public function getEndereco(){
            return $this->objEndereco;
        }

        public function setObservacao($strObservacao){
            $this->strObservacao = $strObservacao;
        }
        
        public function getObservacao(){
            return $this->strObservacao;
        }
        
        public function adicionarReuniao(Reuniao $obj){
            $this->arrObjReunioes[count($this->arrObjReunioes)] = $obj;
        }
        
        public function getReunioes(){
            return $this->arrObjReunioes;
        }
        
        public function setDataHoraCadastro($strDataHoraCadastro){
            $this->strDataHoraCadastro = $strDataHoraCadastro;
        }
        
        public function getDataHoraCadastro(){
            return $this->strDataHoraCadastro;
        }
        
        public function setStatus($strStatus){
            $this->strStatus = $strStatus;
        }

        public function getStatus(){
            return $this->strStatus;
        }
        
        public function getObjAreaMinisterial() {
            return $this->objAreaMinisterial;
        }

        public function setObjAreaMinisterial($objAreaMinisterial) {
            $this->objAreaMinisterial = $objAreaMinisterial;
        }

    }
?>
