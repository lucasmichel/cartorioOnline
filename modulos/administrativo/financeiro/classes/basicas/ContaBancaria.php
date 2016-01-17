<?php
    // codificação utf-8
    class ContaBancaria{
        private $intId;
        private $objBanco;        
        private $strDescricao;
        private $strDataAbertura;        
        private $strAgencia;
        private $strConta;
        private $douSaldoInicial;        
        private $strObservacao;        
        private $strStatus;
        
        public function __construct() {}
        
        public function setId($int){
            $this->intId = $int;
        }        
        public function getId(){
            return $this->intId;
        }
        
        public function setBanco($objBanco){
            $this->objBanco = $objBanco;
        }
        public function getBanco(){
            return $this->objBanco;
        }
        
        public function setDescricao($str){
            $this->strDescricao = $str;
        }        
        public function getDescricao(){
            return $this->strDescricao;
        }
        
        public function setDataAbertura($str){
            $this->strDataAbertura = $str;
        }        
        public function getDataAbertura(){
            return $this->strDataAbertura;
        }
        
        public function setAgencia($str){
            $this->strAgencia = $str;
        }        
        public function getAgencia(){
            return $this->strAgencia;
        }
        
        public function setConta($str){
            $this->strConta = $str;
        }        
        public function getConta(){
            return $this->strConta;
        }
        
        public function setSaldoInicial($str){
            $this->douSaldoInicial = $str;
        }        
        public function getSaldoInicial(){
            return $this->douSaldoInicial;
        }
        
        public function setObservacao($str){
            $this->strObservacao = $str;
        }        
        public function getObservacao(){
            return $this->strObservacao;
        }
        
        public function setStatus($str){
            $this->strStatus = $str;
        }        
        public function getStatus(){
            return $this->strStatus;
        }
    }
?>
