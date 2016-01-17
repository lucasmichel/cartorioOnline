<?php
    // codificação utf-8
    class ControlePatrimonio{
        private $intId;
        private $objGrupoBens;
        private $strCodigo;
        private $strDescricao;
        private $objUnidadeMedida;
        private $objTipoIncorporacao;
        private $objDataAquisicao;
        private $douValor;
        private $douPercentualDepreciacao;
        private $objCondicaoUso;
        private $objSituacaoPatrimonio;

        public function __construct() {}
        
        public function setId($intId){
            $this->intId = $intId;
        }
        
        public function getId(){
            return $this->intId;
        }

        public function setGrupoBens($objGrupoBens){
            $this->objGrupoBens = $objGrupoBens;
        }
        
        public function getGrupoBens(){
            return $this->objGrupoBens;
        }

        public function setCodigo($strCodigo){
            $this->strCodigo = $strCodigo;
        }
        
        public function getCodigo(){
            return $this->strCodigo;
        }
        
        public function setDescricao($strDescricao){
            $this->strDescricao = $strDescricao;
        }
        
        public function getDescricao(){
            return $this->strDescricao;
        }
        
        public function setUnidadeMedida($objUnidadeMedida){
            $this->objUnidadeMedida = $objUnidadeMedida;
        }
        
        public function getUnidadeMedida(){
            return $this->objUnidadeMedida;
        }
        
        public function setTipoIncorporacao($objTipoIncorporacao){
            $this->objTipoIncorporacao = $objTipoIncorporacao;
        }
        
        public function getTipoIncorporacao(){
            return $this->objTipoIncorporacao;
        }
        
        public function setDataAquisicao($objDataAquisicao){
            $this->objDataAquisicao = $objDataAquisicao;
        }
        
        public function getDataAquisicao(){
            return $this->objDataAquisicao;
        }
        
        public function setValor($douValor){
            $this->douValor = $douValor;
        }
        
        public function getValor(){
            return $this->douValor;
        }
        
        public function setPercentualDepreciacao($douPercentualDepreciacao){
            $this->douPercentualDepreciacao = $douPercentualDepreciacao;
        }
        
        public function getPercentualDepreciacao(){
            return $this->douPercentualDepreciacao;
        }
        
        public function setCondicaoUso($objCondicaoUso){
            $this->objCondicaoUso = $objCondicaoUso;
        }
        
        public function getCondicaoUso(){
            return $this->objCondicaoUso;
        }
        
        public function setSituacaoPatrimonio($objSituacaoPatrimonio){
            $this->objSituacaoPatrimonio = $objSituacaoPatrimonio;
        }
        
        public function getSituacaoPatrimonio(){
            return $this->objSituacaoPatrimonio;
        }
    }
?>