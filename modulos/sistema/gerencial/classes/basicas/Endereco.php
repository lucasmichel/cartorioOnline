<?php
    // codificação utf-8
    class Endereco{
        private $strLogradouro;
        private $strNumero;
        private $strComplemento;
        private $strBairro;
        private $strPontoReferencia;
        private $strCidade;
        private $strCep; 
        private $strUf; // localizado em Sistema/Gerencial
        private $strPais;  // localizado em Sistema/Gerencial
        
        public function __construct(){}
        
        public function setLogradouro($strLogradouro){
            $this->strLogradouro = $strLogradouro;
        }
        
        public function getLogradouro(){
            return $this->strLogradouro;
        }
        
        public function setNumero($strNumero){
            $this->strNumero = $strNumero;
        }
        
        public function getNumero(){
            return $this->strNumero;
        }
        
        public function setComplemento($strComplemento){
            $this->strComplemento = $strComplemento;
        }
        
        public function getComplemento(){
            return $this->strComplemento;
        }
        
        public function setPontoReferencia($strPontoReferencia){
            $this->strPontoReferencia = $strPontoReferencia;
        }
        
        public function getPontoReferencia(){
            return $this->strPontoReferencia;
        }
        
        public function setBairro($strBairro){
            $this->strBairro = $strBairro;
        }
        
        public function getBairro(){
            return $this->strBairro;
        }
        
        public function setCidade($strCidade){
            $this->strCidade = $strCidade;
        }
        
        public function getCidade(){
            return $this->strCidade;
        }
        
        public function setCep($strCep){
            $this->strCep = $strCep;
        }
        
        public function getCep(){
            return $this->strCep;
        }
        
        public function setUf($strUf){
            $this->strUf = $strUf;
        }
        
        public function getUf(){
            return $this->strUf;
        }
        
        public function setPais($strPais){
            $this->strPais = $strPais;
        }
        
        public function getPais(){
            return $this->strPais;
        }
    }
?>
