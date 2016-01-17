<?php
    // codificaçao utf-8
    class Carta{
        private $intId;                
        private $objTipoCarta;                
        private $objUsuarioCadastro;                
        private $objUsuarioAlterarcao;                
        private $strTexto;
        private $datDataHoraCadastro;
        private $datDataHoraAlteracao;
        private $objPessoaCarta;
        
        public function __construct(){}
        
        public function getId(){
            return $this->intId;
        }
        public function setId($intId){
            $this->intId = $intId;
        }
        
        public function getTipoCarta(){
            return $this->objTipoCarta;
        }
        public function setTipoCarta($objTipoCarta){
            $this->objTipoCarta = $objTipoCarta;
        }
        
        public function getUsuarioCadastro(){
            return $this->objUsuarioCadastro;
        }
        public function setUsuarioCadastro($objUsuarioCadastro){
            $this->objUsuarioCadastro = $objUsuarioCadastro;
        }
        
        public function getUsuarioAlteracao(){
            return $this->objUsuarioAlterarcao;
        }
        public function setUsuarioAlteracao($objUsuarioAlteracao){
            $this->objUsuarioAlterarcao = $objUsuarioAlteracao;
        }
        
        public function getTexto(){
            return $this->strTexto;
        }
        public function setTexto($strTexto){
            $this->strTexto = $strTexto;
        }
        
        public function getDataHoraCadastro(){
            return $this->datDataHoraCadastro;
        }
        public function setDataHoraCadastro($datDataHoraCadastro){
            $this->datDataHoraCadastro = $datDataHoraCadastro;
        }
        
        public function getDataHoraAlteracao(){
            return $this->datDataHoraAlteracao;
        }
        public function setDataHoraAlteracao($datDataHoraAlteracao){
            $this->datDataHoraAlteracao = $datDataHoraAlteracao;
        }
        
        public function getObjPessoaCarta() {
            return $this->objPessoaCarta;
        }

        public function setObjPessoaCarta($objPessoaCarta) {
            $this->objPessoaCarta = $objPessoaCarta;
        }

    }
?>