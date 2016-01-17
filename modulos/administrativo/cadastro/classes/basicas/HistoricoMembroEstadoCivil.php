<?php
    // codificação utf-8
    class HistoricoMembroEstadoCivil {
        
        private $objEstadoCivil;    
        private $strData;
        private $strDataHoraCadastro;
        private $objUsuarioCadastro;
        private $strObservacao;
        
        public function setEstadoCivil(EstadoCivil $obj){
            $this->objEstadoCivil = $obj;
        }
        public function getEstadoCivil(){
            return $this->objEstadoCivil;
        }
        
        public function setData($strData){
            $this->strData = $strData;
        }        
        public function getData(){
            return $this->strData;
        }
        
        public function setDataHoraCadastro($strDataHoraCadastro){
            $this->strData = $strDataHoraCadastro;
        }        
        public function getDataHoraCadastro(){
            return $this->strDataHoraCadastro;
        }
        
        public function setUsuarioCadastro(Usuario $obj){
            $this->objUsuarioCadastro = $obj;
        }
        public function getUsuarioCadastro(){
            return $this->objUsuarioCadastro;
        }
        
        public function setObservacao($strObservacao){
            $this->strObservacao = $strObservacao;
        }        
        public function getObservacao(){
            return $this->strObservacao;
        }
    }
?>